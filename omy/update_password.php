<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer'ın bulunduğu dosyayı dahil etme
require '../vendor/autoload.php';

// POST isteğini işleme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // E-posta adresini alma
    $email = $_POST["email"];
    $token = $_POST["token"]; // Token değerini POST ile al

    // Veritabanı bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "Mehmet69436943";
    $database = "Hamileliktakibi";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol etme
    if ($conn->connect_error) {
        die("Veritabanına bağlanılamadı: " . $conn->connect_error);
    }

    // Yeni şifreyi güncelleme
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password != $confirm_password) {
        die("Hata: Yeni şifreler eşleşmiyor.");
    }

    // Token'i veritabanında kontrol etme
    $sql = "SELECT * FROM password_resets WHERE email='$email' AND token='$token'";
    $result = $conn->query($sql);

    // Eğer token doğruysa
    if ($result->num_rows > 0) {
        // Şifreyi güncelleme
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password_hash='$hashed_password' WHERE email='$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Şifre başarıyla güncellendi, giriş sayfasına yönlendir
            echo "<script>alert('Şifre başarıyla güncellendi. Giriş sayfasına yönlendiriliyorsunuz...');</script>";
            echo "<script>window.location.href = 'login.html';</script>";
        } else {
            echo "Şifre güncelleme hatası: " . $conn->error;
        }
    } else {
        echo "Geçersiz token veya e-posta adresi.";
    }

    $conn->close();
}

?>
