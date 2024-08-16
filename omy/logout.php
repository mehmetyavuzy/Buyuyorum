<?php
session_start();

// Tüm oturum değişkenlerini temizleyin
$_SESSION = array();

// Oturum cookie'sini silin
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Oturumu sonlandırın
session_destroy();

// Kullanıcıyı login sayfasına yönlendirin
header("Location: login.html");
exit;
?>
