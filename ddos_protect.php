<?php

$ip_address = $_SERVER['REMOTE_ADDR'];

$log_file = __DIR__ . '/logs/ip_logs.json';
$block_file = __DIR__ . '/logs/blokluIp.json';

$request_limit = 20; // maks istek sayısı
$time_window = 5; // zaman aralığı saniye olarak 
$block_duration = 600; // blok süresi saniye olarak

function read_json_file($file_path) {
    if (!file_exists($file_path)) {
        return [];
    }
    $content = file_get_contents($file_path);
    return json_decode($content, true) ?: [];
}

function write_json_file($file_path, $data) {
    file_put_contents($file_path, json_encode($data));
}

$ip_logs = read_json_file($log_file);
$blocked_ips = read_json_file($block_file);

if (isset($blocked_ips[$ip_address])) {
    $blocked_time = $blocked_ips[$ip_address];
    if (time() < $blocked_time) {
        die("Erişiminiz geçici olarak engellenmiştir. Daha sonra tekrar deneyin.");
    } else {
        unset($blocked_ips[$ip_address]);
        write_json_file($block_file, $blocked_ips);
    }
}

if (!isset($ip_logs[$ip_address])) {
    $ip_logs[$ip_address] = [];
}

$ip_logs[$ip_address][] = microtime(true);

$recent_requests = array_filter($ip_logs[$ip_address], function($timestamp) use ($time_window) {
    return $timestamp > microtime(true) - $time_window;
});

$ip_logs[$ip_address] = $recent_requests;

if (count($recent_requests) > $request_limit) {
    $blocked_ips[$ip_address] = time() + $block_duration;
    write_json_file($block_file, $blocked_ips);
    die("Çok fazla istek gönderildi. IP adresiniz geçici olarak engellendi.");
}

write_json_file($log_file, $ip_logs);

?>
