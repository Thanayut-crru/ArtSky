<?php
declare(strict_types=1);

/**
 * FP-HC vs Hash+Merkle baseline
 * รันด้วย: php benchmark_fp_hc_vs_baseline.php
 *
 * FP-HC จะรัน 3 ค่า:
 *   - K_BITS = 8
 *   - K_BITS = 16
 *   - K_BITS = 32
 *
 * จะพิมพ์ตารางสรุปเปรียบเทียบ performance ทั้งหมด
 */

// ======================= CONFIG =========================

// FP-HC parameters (global)
const FPHC_MAX_ITERS_PER_NONCE = 5000;
const FPHC_MAX_NONCE_TRIALS    = 5000;

// จะรัน FP-HC 3 ค่า
const FPHC_K_BITS_LIST = [8, 16, 32];

// จำนวนบล็อกและรอบการทดสอบ
const NUM_BLOCKS_PER_RUN = 10;
const NUM_RUNS           = 3;

// baseline params (จำนวน tx ต่อ block)
const BASELINE_TX_COUNTS = [1, 10];

// เปิด error
error_reporting(E_ALL);
ini_set('display_errors', '1');

// =================== UTILITIES ==========================

function truncate_hash(string $data, int $kBytes): string {
    return substr(hash('sha256', $data, true), 0, $kBytes);
}
function state_hex_to_bin(string $hex, int $kBytes): string {
    $bin = hex2bin($hex);
    if ($bin === false) throw new RuntimeException("Invalid hex: $hex");
    if (strlen($bin) !== $kBytes) throw new RuntimeException("Bad state length");
    return $bin;
}
function F_mapping(string $prev_state_bin, string $msg_bytes, int $nonce, string $x_bin, int $kBytes): string {
    $nonce_hex   = str_pad(dechex($nonce), 16, '0', STR_PAD_LEFT);
    $nonce_bytes = hex2bin($nonce_hex);
    return truncate_hash($prev_state_bin . $msg_bytes . $nonce_bytes . $x_bin, $kBytes);
}
function create_genesis_state(int $kBytes): string {
    return bin2hex(random_bytes($kBytes));
}
function sha256_hex(string $s): string {
    return hash('sha256', $s);
}
function merkleRootWithStats(array $txs, int &$hashCount): string {
    $hashCount = 0;
    if (empty($txs)) {
        $hashCount++;
        return sha256_hex('');
    }
    $hashes = [];
    foreach ($txs as $t) {
        $hashes[] = sha256_hex(json_encode($t, JSON_UNESCAPED_UNICODE));
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
function avg(array $arr): float {
    return count($arr) ? array_sum($arr) / count($arr) : 0;
}

// =================== FP-HC BENCHMARK ==========================

function mine_block_fphc(string $prev_state_hex, string $msg, int $kBits): ?array {
    $kBytes = $kBits / 8;
    $prev_bin = state_hex_to_bin($prev_state_hex, $kBytes);

    $total_iters = 0;
    $t0 = microtime(true);

    for ($nonce = 0; $nonce < FPHC_MAX_NONCE_TRIALS; $nonce++) {
        $x = random_bytes($kBytes);
        for ($i = 0; $i < FPHC_MAX_ITERS_PER_NONCE; $i++) {
            $total_iters++;
            $y = F_mapping($prev_bin, $msg, $nonce, $x, $kBytes);

            if ($y === $x) {
                $t1 = microtime(true);
                return [
                    'iterations' => $total_iters,
                    'time_ms' => ($t1 - $t0) * 1000.0,
                    'nonce' => $nonce
                ];
            }
            $x = $y;
        }
    }
    return null;
}

function benchmark_fphc(int $kBits): array {
    $kBytes = $kBits / 8;

    $hashes = [];
    $times  = [];

    for ($run = 0; $run < NUM_RUNS; $run++) {
        $prev_state = create_genesis_state($kBytes);

        for ($b = 0; $b < NUM_BLOCKS_PER_RUN; $b++) {
            $msg = "CarbonRecord run=$run block=$b K=$kBits";

            $res = mine_block_fphc($prev_state, $msg, $kBits);
            if (!$res) break;

            $hashes[] = $res['iterations'];
            $times[]  = $res['time_ms'];

            $prev_state = substr(sha256_hex($prev_state . $msg . $res['nonce']), 0, $kBytes * 2);
        }
    }

    return [
        'scheme' => 'FP-HC',
        'param'  => "K_BITS=$kBits",
        'avg_hash' => avg($hashes),
        'min_hash' => $hashes ? min($hashes) : 0,
        'max_hash' => $hashes ? max($hashes) : 0,
        'avg_time_ms' => avg($times)
    ];
}

// =================== BASELINE BENCHMARK ==========================

function benchmark_baseline(int $txCount): array {
    $hashes = [];
    $times  = [];

    for ($run = 0; $run < NUM_RUNS; $run++) {
        $prevHash = str_repeat('0', 64);

        for ($b = 0; $b < NUM_BLOCKS_PER_RUN; $b++) {

            $txs = [];
            for ($t = 0; $t < $txCount; $t++) {
                $txs[] = ['msg' => "tx $t of block $b"];
            }

            $hashCountMerkle = 0;
            $t0 = microtime(true);

            $merkle = merkleRootWithStats($txs, $hashCountMerkle);
            $header = sha256_hex("{$b}|{$prevHash}|{$merkle}|0|0|baseline");

            $t1 = microtime(true);

            $hashes[] = $hashCountMerkle + 1;
            $times[]  = ($t1 - $t0) * 1000.0;

            $prevHash = $header;
        }
    }

    return [
        'scheme' => 'Hash+Merkle',
        'param'  => "N_tx=$txCount",
        'avg_hash' => avg($hashes),
        'min_hash' => min($hashes),
        'max_hash' => max($hashes),
        'avg_time_ms' => avg($times)
    ];
}

// =================== PRINT TABLE ==========================
function print_table(array $rows): void {

    $w1 = 14; $w2 = 14; $w3 = 16; $w4 = 10; $w5 = 10; $w6 = 16;
    $line = str_repeat('-', $w1 + $w2 + $w3 + $w4 + $w5 + $w6 + 7);

    echo $line . "\n";
    printf("| %-{$w1}s | %-{$w2}s | %-{$w3}s | %-{$w4}s | %-{$w5}s | %-{$w6}s |\n",
        "Scheme", "Param", "AvgHash/block", "MinHash", "MaxHash", "AvgTime(ms)");
    echo $line . "\n";

    foreach ($rows as $r) {
        printf(
            "| %-{$w1}s | %-{$w2}s | %-{$w3}.2f | %-{$w4}d | %-{$w5}d | %-{$w6}.4f |\n",
            $r['scheme'], $r['param'],
            $r['avg_hash'], $r['min_hash'], $r['max_hash'], $r['avg_time_ms']
        );
    }

    echo $line . "\n";
}

// =================== RUN BENCHMARK ==========================

echo "=== FP-HC vs Hash+Merkle Benchmark ===\n";
echo "Runs: " . NUM_RUNS . "  Blocks/run: " . NUM_BLOCKS_PER_RUN . "\n";
echo "FP-HC K_BITS tested = {8, 16, 32}\n\n";

$rows = [];

// FP-HC (3 ค่า)
foreach (FPHC_K_BITS_LIST as $k) {
    $rows[] = benchmark_fphc($k);
}

// baseline
foreach (BASELINE_TX_COUNTS as $txCount) {
    $rows[] = benchmark_baseline($txCount);
}

// print table
print_table($rows);

