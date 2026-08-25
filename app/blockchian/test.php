<?php
declare(strict_types=1);

/**
 * FP-HC vs Hash+Merkle baseline
 * รันด้วย: php benchmark_fp_hc_vs_baseline.php
 *
 * - เปรียบเทียบ:
 *   1) FP-HC (Fixed-Point Hash Chain)
 *   2) Baseline: hash+Merkle (แบบ addBlockFast แต่ตัด DB ออก)
 *
 * - พิมพ์ตารางสรุป:
 *   Scheme, Param, AvgHash/block, MinHash, MaxHash, AvgTime(ms)
 */

// ======================= CONFIG =========================

// FP-HC parameters
const FPHC_K_BITS              = 8;     // ลอง 8 / 12 / 16 ตามใจ
const FPHC_K_BYTES             = FPHC_K_BITS / 8;
const FPHC_MAX_ITERS_PER_NONCE = 2000;  // จำกัด iteration ต่อ nonce
const FPHC_MAX_NONCE_TRIALS    = 2000;  // จำกัดจำนวน nonce ที่ลอง

// จำนวนบล็อก/จำนวนรอบในการทดสอบ
const NUM_BLOCKS_PER_RUN = 20;
const NUM_RUNS           = 5;

// baseline params (จำนวน tx ต่อ block ที่จะเทียบ)
const BASELINE_TX_COUNTS = [1, 10]; // 1 tx, 10 tx

// เปิด error เพื่อ debug
error_reporting(E_ALL);
ini_set('display_errors', '1');

// =================== UTILITIES ==========================

function truncate_hash(string $data, int $kBytes): string
{
    $full = hash('sha256', $data, true); // binary
    return substr($full, 0, $kBytes);
}

function state_hex_to_bin(string $hex, int $kBytes): string
{
    $bin = hex2bin($hex);
    if ($bin === false) {
        throw new RuntimeException("Invalid hex string: $hex");
    }
    if (strlen($bin) !== $kBytes) {
        throw new RuntimeException("State length must be {$kBytes} bytes, got " . strlen($bin));
    }
    return $bin;
}

// FP-HC mapping: F(prev_state, message, nonce, x)
function F_mapping(string $prev_state_bin, string $msg_bytes, int $nonce, string $x_bin, int $kBytes): string
{
    $nonce_hex   = str_pad(dechex($nonce), 16, '0', STR_PAD_LEFT); // 8 bytes
    $nonce_bytes = hex2bin($nonce_hex);
    if ($nonce_bytes === false) {
        throw new RuntimeException("Failed to encode nonce");
    }

    $data = $prev_state_bin . $msg_bytes . $nonce_bytes . $x_bin;
    return truncate_hash($data, $kBytes);
}

function create_genesis_state(int $kBytes): string
{
    return bin2hex(random_bytes($kBytes));
}

// Simple SHA-256 wrapper (hex)
function sha256_hex(string $s): string
{
    return hash('sha256', $s);
}

// Merkle root (เหมือนใน addBlockFast แต่ไม่มี DB)
function merkleRootWithStats(array $txs, int &$hashCount): string
{
    $hashCount = 0;

    if (empty($txs)) {
        $hashCount++;
        return sha256_hex('');
    }

    $hashes = [];
    foreach ($txs as $t) {
        $hashes[] = sha256_hex(json_encode($t, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $hashCount++;
    }

    while (count($hashes) > 1) {
        $next = [];
        for ($i = 0; $i < count($hashes); $i += 2) {
            $a = $hashes[$i];
            $b = $hashes[$i + 1] ?? $a;
            $next[] = sha256_hex($a . $b);
            $hashCount++;
        }
        $hashes = $next;
    }

    return $hashes[0];
}

// คำนวณค่าเฉลี่ย
function avg(array $values): float
{
    if (count($values) === 0) {
        return 0.0;
    }
    return array_sum($values) / count($values);
}

// =================== FP-HC BLOCK MINING ==========================

/**
 * ขุดบล็อกแบบมี nonce:
 * หาคู่ (state, nonce) ที่ทำให้ state = F(prev_state, message, nonce, state)
 * คืน:
 *  [
 *    'iterations' => int,    // == hash count (เพราะ 1 iteration = 1 hash)
 *    'time_ms'    => float,
 *  ]
 * ถ้าไม่เจอภายใน limit → คืน null
 */
function mine_block_with_nonce_fphc(string $prev_state_hex, string $message, int $kBytes): ?array
{
    $prev_state_bin = state_hex_to_bin($prev_state_hex, $kBytes);
    $msg_bytes      = $message;

    $total_iters = 0;
    $t0 = microtime(true);

    for ($nonce = 0; $nonce < FPHC_MAX_NONCE_TRIALS; $nonce++) {
        // seed x เริ่มต้นแบบสุ่มสำหรับ nonce นี้
        $x = random_bytes($kBytes);

        for ($i = 0; $i < FPHC_MAX_ITERS_PER_NONCE; $i++) {
            $total_iters++;
            $y = F_mapping($prev_state_bin, $msg_bytes, $nonce, $x, $kBytes);
            if ($y === $x) {
                $t1 = microtime(true);
                return [
                    'iterations' => $total_iters,
                    'time_ms'    => ($t1 - $t0) * 1000.0,
                    'nonce'      => $nonce,
                ];
            }
            $x = $y;
        }
        // ถ้าไม่เจอใน nonce นี้ → ลอง nonce ถัดไป
    }

    return null;
}

// ทดสอบ FP-HC หลาย block หลาย run
function benchmark_fphc(): array
{
    $allHashCounts = [];
    $allTimesMs    = [];

    $kBytes = FPHC_K_BYTES;

    for ($run = 0; $run < NUM_RUNS; $run++) {
        $genesis    = create_genesis_state($kBytes);
        $prev_state = $genesis;

        for ($b = 1; $b <= NUM_BLOCKS_PER_RUN; $b++) {
            // สร้าง message แบบคาร์บอนเครดิตสุ่ม
            $farmLetter = chr(rand(65, 90));   // A-Z
            $farmNumber = rand(1, 10);
            $carbon     = rand(50, 200);
            $message    = sprintf(
                "CarbonRecord: project=CR2025, farm=%s%d, carbon=%dkg",
                $farmLetter,
                $farmNumber,
                $carbon
            );

            $blockRes = mine_block_with_nonce_fphc($prev_state, $message, $kBytes);
            if ($blockRes === null) {
                // ถ้าไม่พบ fixed point ภายใน limit → ข้ามบล็อกนี้
                break;
            }

            $allHashCounts[] = $blockRes['iterations']; // iterations == hash calls
            $allTimesMs[]    = $blockRes['time_ms'];

            // สำหรับ chain จริงต้องได้ state ใหม่ แต่นี่เราไม่ต้องใช้ state จริงก็ได้
            // แต่เพื่อความสมบูรณ์ เราจะใช้ hash(prev_state|message|nonce) เป็น state ใหม่แบบง่าย ๆ
            $prev_state = substr(sha256_hex($prev_state . $message . $blockRes['nonce']), 0, $kBytes * 2);
        }
    }

    if (count($allHashCounts) === 0) {
        return [
            'scheme'       => 'FP-HC',
            'param'        => 'K_BITS=' . FPHC_K_BITS,
            'avg_hash'     => 0,
            'min_hash'     => 0,
            'max_hash'     => 0,
            'avg_time_ms'  => 0.0,
        ];
    }

    return [
        'scheme'       => 'FP-HC',
        'param'        => 'K_BITS=' . FPHC_K_BITS,
        'avg_hash'     => avg($allHashCounts),
        'min_hash'     => min($allHashCounts),
        'max_hash'     => max($allHashCounts),
        'avg_time_ms'  => avg($allTimesMs),
    ];
}

// =================== BASELINE HASH+MERKLE ==========================

/**
 * baseline แบบ addBlockFast ตัด DB ออก:
 * - สร้าง payload tx
 * - คำนวณ merkleRootWithStats
 * - คำนวณ header hash 1 ครั้ง
 * - วัด hash count + time per block
 */
function benchmark_baseline_for_tx_count(int $txCount): array
{
    $allHashCounts = [];
    $allTimesMs    = [];

    for ($run = 0; $run < NUM_RUNS; $run++) {
        $prevHash = str_repeat('0', 64);

        for ($b = 0; $b < NUM_BLOCKS_PER_RUN; $b++) {
            // สร้าง payload สมมติคล้าย ๆ addBlockFast
            $txPayloads = [];
            for ($t = 0; $t < $txCount; $t++) {
                $txPayloads[] = [
                    'type' => 'Contract call',
                    'msg'  => "baseline tx #{$t} block #{$b} run #{$run}",
                ];
            }

            $hashCountMerkle = 0;

            $t0      = microtime(true);
            $merkle  = merkleRootWithStats($txPayloads, $hashCountMerkle);
            $nonce   = 0;
            $diff    = 0;
            $miner   = 'baseline';
            $height  = $b;

            $headerStr = $height . "|" . $prevHash . "|" . $merkle . "|" . $nonce . "|" . $diff . "|" . $miner;

            $hashHeader = sha256_hex($headerStr);
            $t1         = microtime(true);

            // hash header อีก 1 ครั้ง
            $hashCountTotal = $hashCountMerkle + 1;
            $timeMs         = ($t1 - $t0) * 1000.0;

            $allHashCounts[] = $hashCountTotal;
            $allTimesMs[]    = $timeMs;

            $prevHash = $hashHeader;
        }
    }

    return [
        'scheme'       => 'Hash+Merkle',
        'param'        => "N_tx={$txCount}",
        'avg_hash'     => avg($allHashCounts),
        'min_hash'     => min($allHashCounts),
        'max_hash'     => max($allHashCounts),
        'avg_time_ms'  => avg($allTimesMs),
    ];
}

// =================== MAIN: RUN BENCHMARK & PRINT TABLE =============

function print_table(array $rows): void
{
    // กำหนดความกว้างคอลัมน์
    $wScheme = 14;
    $wParam  = 12;
    $wAvgH   = 16;
    $wMinH   = 10;
    $wMaxH   = 10;
    $wAvgT   = 16;

    $line = str_repeat('-', $wScheme + $wParam + $wAvgH + $wMinH + $wMaxH + $wAvgT + 7);

    printf("%s\n", $line);
    printf(
        "| %-{$wScheme}s | %-{$wParam}s | %-{$wAvgH}s | %-{$wMinH}s | %-{$wMaxH}s | %-{$wAvgT}s |\n",
        'Scheme',
        'Param',
        'AvgHash/block',
        'MinHash',
        'MaxHash',
        'AvgTime(ms)'
    );
    printf("%s\n", $line);

    foreach ($rows as $r) {
        printf(
            "| %-{$wScheme}s | %-{$wParam}s | %-{$wAvgH}.2f | %-{$wMinH}d | %-{$wMaxH}d | %-{$wAvgT}.4f |\n",
            $r['scheme'],
            $r['param'],
            $r['avg_hash'],
            $r['min_hash'],
            $r['max_hash'],
            $r['avg_time_ms']
        );
    }

    printf("%s\n", $line);
}

// =================== RUN ==========================

echo "=== FP-HC vs Hash+Merkle Benchmark ===\n";
echo "Runs per scheme: " . NUM_RUNS . ", Blocks per run: " . NUM_BLOCKS_PER_RUN . "\n";
echo "FP-HC: K_BITS=" . FPHC_K_BITS . ", MAX_ITERS_PER_NONCE=" . FPHC_MAX_ITERS_PER_NONCE .
     ", MAX_NONCE_TRIALS=" . FPHC_MAX_NONCE_TRIALS . "\n\n";

$rows = [];

// 1) FP-HC
$rows[] = benchmark_fphc();

// 2) Baseline: หลายค่า N_tx
foreach (BASELINE_TX_COUNTS as $txCount) {
    $rows[] = benchmark_baseline_for_tx_count($txCount);
}

// print ตาราง
print_table($rows);
