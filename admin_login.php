<?php
session_start();

$admin_password = '11asd'; // admin şifresi

// kontrol
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if ($password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.php');
        exit;
    } else {
        $error = "hatalı şifre!";
    }
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_panel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Admin Girişi</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin-top: 100px;
    }

    input {
        padding: 10px;
        margin: 10px;
    }
    </style>
</head>

<body>

    <h1>Admin Girişi</h1>

    <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="password" placeholder="Şifre" required>
        <br>
        <input type="submit" value="Giriş Yap">
    </form>

</body>

</html>