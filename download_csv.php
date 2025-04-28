<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die("Yetkisiz erişim.");
}

$block_file = __DIR__ . '/logs/blokluIp.json';

function read_json_file($file_path) {
    if (!file_exists($file_path)) {
        return [];
    }
    $content = file_get_contents($file_path);
    return json_decode($content, true) ?: [];
}

$blocked_ips = read_json_file($block_file);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="blokluIp.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['IP Adresi', 'Blok Bitiş Zamanı']);

foreach ($blocked_ips as $ip => $end_time) {
    fputcsv($output, [$ip, date('d-m-Y H:i:s', $end_time)]);
}

fclose($output);
exit;
