<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="password.css">
    <title>Şifre Yenileme</title>
</head>
<body>
    <h2>Şifre Yenileme</h2>
    <form action="update_passaword.php" method="POST">
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
        <label for="new_password">Yeni Şifre:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_password">Yeni Şifre (Tekrar):</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <button type="submit">Şifreyi Güncelle</button>
    </form>
</body>
</html>
