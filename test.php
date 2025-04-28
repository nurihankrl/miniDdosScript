<?php

$target_url = 'http://localhost/index.php'; // istek atılacak url

$number_of_requests = 50; // toplam istek sayısı
$delay_microseconds = 100000; // istek arası gecikme süresi

echo "başlangıç... $number_of_requests istek gönderilecek.<br>";

for ($i = 0; $i < $number_of_requests; $i++) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "İstek #" . ($i + 1) . " - HTTP durumu: $http_status<br>";
    echo "Cevap: " . htmlspecialchars(substr($response, 0, 100)) . "...<br><br>";

    usleep($delay_microseconds);
}

echo "test tamamlandı.";
?>
