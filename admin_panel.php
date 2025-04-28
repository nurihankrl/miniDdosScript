<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

$block_file = __DIR__ . '/logs/blokluIp.json';

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

if (isset($_GET['unblock'])) {
    $ip_to_unblock = $_GET['unblock'];
    $blocked_ips = read_json_file($block_file);

    if (isset($blocked_ips[$ip_to_unblock])) {
        unset($blocked_ips[$ip_to_unblock]);
        write_json_file($block_file, $blocked_ips);
        header("Location: admin_panel.php?success=1");
        exit;
    } else {
        header("Location: admin_panel.php?error=1");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual_ip']) && isset($_POST['block_duration'])) {
    $manual_ip = trim($_POST['manual_ip']);
    $duration_minutes = intval($_POST['block_duration']);

    if (filter_var($manual_ip, FILTER_VALIDATE_IP) && $duration_minutes > 0) {
        $blocked_ips = read_json_file($block_file);
        $blocked_ips[$manual_ip] = time() + ($duration_minutes * 60); // dakiye - saniye
        write_json_file($block_file, $blocked_ips);
        header("Location: admin_panel.php?manual_block_success=1");
        exit;
    } else {
        header("Location: admin_panel.php?manual_block_error=1");
        exit;
    }
}

// ip okuma fonksiyonu
$blocked_ips = read_json_file($block_file);

function write_log($message) {
    $log_file = __DIR__ . '/logs/activity_log.txt';
    $entry = "[" . date('d-m-Y H:i:s') . "] " . $message . PHP_EOL;
    file_put_contents($log_file, $entry, FILE_APPEND);
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }

    a.button {
        background-color: #ff4d4d;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    a.button:hover {
        background-color: #ff1a1a;
    }

    form {
        margin: 20px;
    }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    a.button {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
    }

    a.button:hover {
        background-color: #218838;
    }

    form {
        margin: 20px;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
    </style>
</head>

<body>

    <h1>Admin Panel</h1>

    <p><a href="admin_logout.php">Çıkış Yap</a></p>

    <?php if (isset($_GET['success'])): ?>
    <p class="success">IP başarıyla kaldırıldı!</p>
    <?php elseif (isset($_GET['error'])): ?>
    <p class="error">Hata: IP bulunamadı.</p>
    <?php elseif (isset($_GET['manual_block_success'])): ?>
    <p class="success">IP başarıyla manuel olarak bloklandı!</p>
    <?php elseif (isset($_GET['manual_block_error'])): ?>
    <p class="error">Hatalı IP adresi veya blok süresi!</p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="manual_ip" placeholder="ip adresi" required>
        <select name="block_duration" required>
            <option value="5">5 Dakika</option>
            <option value="10">10 Dakika</option>
            <option value="30">30 Dakika</option>
            <option value="60">1 Saat</option>
            <option value="360">6 Saat</option>
            <option value="720">12 Saat</option>
            <option value="1440">1 Gün</option>
        </select>
        <input type="submit" value="Blokla">
    </form>

    <h2>Bloklanan IP Listesi</h2>
    <p><a class="button" href="download_csv.php">IP Listesini İndir (CSV)</a></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>IP Adresi</th>
                <th>Blok Bitiş Zamanı</th>
                <th>Kalan Süre</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($blocked_ips)): ?>
            <tr>
                <td colspan="5">Şu anda bloklu IP bulunmuyor.</td>
            </tr>
            <?php else: ?>
            <?php
            $index = 1;
            foreach ($blocked_ips as $ip => $end_time):
                $remaining = $end_time - time();
                ?>
            <tr>
                <td><?php echo $index++; ?></td>
                <td><?php echo htmlspecialchars($ip); ?></td>
                <td><?php echo date('d-m-Y H:i:s', $end_time); ?></td>
                <td data-remaining="<?php echo $remaining; ?>">
                    <?php
                        if ($remaining > 0) {
                            echo gmdate('H:i:s', $remaining);
                        } else {
                            echo 'Blok süresi doldu';
                        }
                        ?>
                </td>
                <td>
                    <a class="button" style="background-color: red;"
                        href="admin_panel.php?unblock=<?php echo urlencode($ip); ?>"
                        onclick="return confirm('Bu IP\'nin blokunu kaldırmak istediğinize emin misiniz');">Blok
                        Kaldır</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
    function updateRemainingTime() {
        const cells = document.querySelectorAll("td[data-remaining]");

        cells.forEach(cell => {
            const remainingTime = parseInt(cell.getAttribute("data-remaining"));

            if (remainingTime > 0) {
                const newRemaining = remainingTime - 1;
                cell.setAttribute("data-remaining", newRemaining);

                const hours = Math.floor(newRemaining / 3600);
                const minutes = Math.floor((newRemaining % 3600) / 60);
                const seconds = newRemaining % 60;

                cell.textContent =
                    `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                cell.textContent = 'Blok süresi doldu';
            }
        });
    }

    setInterval(updateRemainingTime, 1000);
    </script>

</body>
</html>