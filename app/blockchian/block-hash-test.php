<?php

declare(strict_types=1);

// ==========================================
//  Fixed-Point Hash Chain (FP-HC) Demo in PHP
//  - ใช้ SHA-256 + truncation
//  - มี nonce เพื่อให้ขุดบล็อกได้ง่ายขึ้น
//  - สร้างตัวอย่าง 3 blocks สำหรับทดลอง
//  - คืนค่าออกมาเป็น JSON
// ==========================================

// -------- CONFIG --------
const K_BITS              = 8;       // ลอง 24 หรือ 32 บิต (32 จะช้ากว่า)
const K_BYTES             = K_BITS / 8;
const MAX_ITERS_PER_NONCE = 50000;   // ลิมิตวน F(x) ต่อ nonce
const MAX_NONCE_TRIALS    = 50000;   // ลิมิตจำนวน nonce ที่ลอง

// เปิด error เพื่อ debug ได้ง่าย
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ถ้าเรียกผ่านเว็บ ให้ส่ง header เป็น JSON
if (php_sapi_name() !== 'cli') {
    header('Content-Type: application/json; charset=utf-8');
}

// -------- CORE HASH HELPERS --------

/**
 * SHA-256 แล้วตัดให้เหลือ K_BITS
 * คืนค่าเป็น binary string (ไม่ใช่ hex)
 */
function truncate_hash(string $data): string
{
    $full = hash('sha256', $data, true);   // raw binary
    return substr($full, 0, K_BYTES);
}

/**
 * แปลง state จาก hex string → binary
 */
function state_hex_to_bin(string $hex): string
{
    $bin = hex2bin($hex);
    if ($bin === false) {
        throw new RuntimeException("Invalid hex string: $hex");
    }
    if (strlen($bin) !== K_BYTES) {
        throw new RuntimeException("State length must be " . K_BYTES . " bytes, got " . strlen($bin));
    }
    return $bin;
}

/**
 * F_{s_prev, m, nonce}(x) = T_k(SHA-256(prev_state || msg || nonce || x))
 */
function F_mapping(string $prev_state_bin, string $msg_bytes, int $nonce, string $x_bin): string
{
    // แปลง nonce เป็น 8 ไบต์ big-endian (ใช้ hex เป็นตัวกลาง)
    $nonce_hex   = str_pad(dechex($nonce), 16, '0', STR_PAD_LEFT); // 16 hex chars = 8 bytes
    $nonce_bytes = hex2bin($nonce_hex);
    if ($nonce_bytes === false) {
        throw new RuntimeException("Failed to encode nonce");
    }

    $data = $prev_state_bin . $msg_bytes . $nonce_bytes . $x_bin;
    return truncate_hash($data);
}

/**
 * สร้าง genesis state แบบสุ่ม (hex)
 */
function create_genesis_state(): string
{
    return bin2hex(random_bytes(K_BYTES));
}

// -------- FP-HC MINING WITH NONCE --------

/**
 * โครงสร้างบล็อก: ใช้ array แทน class เพื่อความง่าย
 *
 * [
 *   'index'      => int,
 *   'prev_state' => string(hex),
 *   'state'      => string(hex),
 *   'nonce'      => int,
 *   'message'    => string,
 *   'iterations' => int
 * ]
 */

/**
 * ขุดบล็อกแบบมี nonce:
 * หาคู่ (state, nonce) ที่ทำให้ state = F(prev_state, message, nonce, state)
 */
function mine_block_with_nonce(string $prev_state_hex, string $message, int $index): ?array
{
    $prev_state_bin = state_hex_to_bin($prev_state_hex);
    $msg_bytes      = $message; // UTF-8 โดยตรงก็ได้

    $total_iters = 0;

    for ($nonce = 0; $nonce < MAX_NONCE_TRIALS; $nonce++) {

        // seed x เริ่มต้นแบบสุ่มสำหรับ nonce นี้
        $x = random_bytes(K_BYTES);

        for ($i = 0; $i < MAX_ITERS_PER_NONCE; $i++) {
            $total_iters++;
            $y = F_mapping($prev_state_bin, $msg_bytes, $nonce, $x);
            if ($y === $x) {
                // เจอ fixed point แล้ว
                return [
                    'index'      => $index,
                    'prev_state' => $prev_state_hex,
                    'state'      => bin2hex($x),
                    'nonce'      => $nonce,
                    'message'    => $message,
                    'iterations' => $total_iters,
                ];
            }
            $x = $y;
        }
        // ถ้ายังไม่เจอ fixed point ภายใน MAX_ITERS_PER_NONCE ก็ลอง nonce ถัดไป
    }

    // ถ้าไม่พบเลยในทุก nonce ที่ลอง
    return null;
}

/**
 * ตรวจสอบว่าบล็อก valid ไหม:
 *  state == F(prev_state, message, nonce, state)
 */
function verify_block(array $block): bool
{
    $prev_state_bin = state_hex_to_bin($block['prev_state']);
    $state_bin      = state_hex_to_bin($block['state']);
    $msg_bytes      = $block['message'];
    $nonce          = (int)$block['nonce'];

    $y = F_mapping($prev_state_bin, $msg_bytes, $nonce, $state_bin);
    return ($y === $state_bin);
}

/**
 * ตรวจสอบทั้ง chain
 */
function verify_chain(array $blocks): bool
{
    $n = count($blocks);
    for ($i = 0; $i < $n; $i++) {
        $blk = $blocks[$i];

        if (!verify_block($blk)) {
            return false;
        }

        if ($i > 0) {
            $prev = $blocks[$i - 1];
            if ($blk['prev_state'] !== $prev['state']) {
                return false;
            }
        }
    }
    return true;
}

// -------- DEMO: CREATE 3 BLOCKS (RETURN JSON) --------

function demo_three_blocks_as_json(): void
{
    // เตรียมโครง result
    $result = [
        'k_bits'   => K_BITS,
        'k_bytes'  => K_BYTES,
        'genesis'  => null,
        'blocks'   => [],
        'chain_ok' => null,
        'error'    => null,
    ];

    try {
        // 1) สร้าง genesis state
        $genesis       = create_genesis_state();
        $result['genesis'] = $genesis;

        // 2) กำหนดข้อความของทั้ง 3 block (ตัวอย่างระบบ carbon)
        // $messages = [
        //     1 => "CarbonRecord: project=CR2025, farm=A, carbon=100kg",
        //     2 => "CarbonRecord: project=CR2025, farm=B, carbon=120kg",
        //     3 => "CarbonRecord: project=CR2025, farm=C, carbon=140kg",
        //     3 => "CarbonRecord: project=CR2025, farm=C, carbon=140kg",
        // ];

        $messages = [];

        for ($i = 1; $i <= 30; $i++) {

            // สุ่มชื่อฟาร์ม: A–Z + เลข 1–10
            $farmLetter = chr(rand(65, 90));  // A-Z
            $farmNumber = rand(1, 10);

            // สุ่มคาร์บอน 50–200 kg
            $carbon = rand(50, 200);

            // สร้างข้อความ
            $messages[$i] = sprintf(
                "CarbonRecord: project=CR2025, farm=%s%d, carbon=%dkg",
                $farmLetter,
                $farmNumber,
                $carbon
            );
        }

        $blocks     = [];
        $prev_state = $genesis;

        // 3) สร้าง 3 blocks ต่อกัน
        foreach ($messages as $index => $msg) {
            $block = mine_block_with_nonce($prev_state, $msg, $index);

            if ($block === null) {
                $result['error'] = "Failed to find fixed point for block {$index} within limits.";
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                return;
            }

            $blocks[]   = $block;
            $prev_state = $block['state'];
        }

        // 4) ตรวจสอบทั้ง chain
        $chain_ok = verify_chain($blocks);

        $result['blocks']   = $blocks;
        $result['chain_ok'] = $chain_ok;
    } catch (Throwable $e) {
        $result['error'] = $e->getMessage();
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

// เรียก demo
demo_three_blocks_as_json();
