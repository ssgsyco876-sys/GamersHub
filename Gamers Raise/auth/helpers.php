<?php
// helpers.php

// ✅ Derive 32-byte key from master key
function derive_key($master_key) {
    return hash('sha256', $master_key, true); // raw binary
}

// ✅ Encrypt plain password
function encrypt_secret($plain, $master_key) {
    $key = derive_key($master_key);
    $iv = random_bytes(16); // AES-256-CBC requires 16-byte IV
    $cipher = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return [
        'enc' => base64_encode($cipher),
        'iv'  => base64_encode($iv)
    ];
}

// ✅ Decrypt encrypted password
function decrypt_secret($enc_b64, $iv_b64, $master_key) {
    $key = derive_key($master_key);
    $enc = base64_decode($enc_b64);
    $iv  = base64_decode($iv_b64);
    $plain = openssl_decrypt($enc, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? null : $plain;
}

