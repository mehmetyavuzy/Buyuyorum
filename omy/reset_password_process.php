<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer'ın bulunduğu dosyayı dahil etme
require '../vendor/autoload.php';

// POST isteğini işleme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // E-posta adresini alma
    $email = $_POST["email"];

    // Veritabanı bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = ";
    $dbname = "hamileliktakibi";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol etme
    if ($conn->connect_error) {
        die("Veritabanına bağlanılamadı: " . $conn->connect_error);
    }

    // Kullanıcıyı veritabanında kontrol etme
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    // Eğer kullanıcı bulunduysa
    if ($result->num_rows > 0) {
        // Token oluşturma
        $token = bin2hex(random_bytes(16));

        // Token'i veritabanına ekleme
        $sql = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";
        if ($conn->query($sql) === TRUE) {
            // Şifre sıfırlama bağlantısının oluşturulması
            $resetLink = 'http://localhost/omy/password_reset.php?email=' . $email . '&token=' . $token;

            // E-posta gönderme işlemi
            $mail = new PHPMailer(true);
            try {
                // Sunucu ayarları
                $mail->isSMTP();
                $mail->Host = 'smtp.mailgun.org';            // Mailgun SMTP sunucusu
                $mail->SMTPAuth = true;
                $mail->Username =  // Mailgun SMTP kullanıcı adı
                $mail->Password =             // Mailgun SMTP parolası
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Güvenli bağlantı türü: tls
                $mail->Port = 587;                         // TCP bağlantı portu

                // Alıcı bilgileri
                $mail->setFrom('postmaster@sandboxdd999c03ee3947a49e2effda8ff8acb6.mailgun.org', 'Your Name');
                $mail->addAddress($email);                 // Alıcı e-posta

                // E-posta içeriği
                $mail->isHTML(true);
                $mail->Subject = 'Şifre Sıfırlama Bağlantısı';
                $mail->Body = 'Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayınız: <a href="' . $resetLink . '">Şifre Sıfırlama Bağlantısı</a>';

                $mail->send();
                echo 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
            } catch (Exception $e) {
                echo "E-posta gönderimi başarısız: " . $e->getMessage();
            }
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Bu e-posta adresiyle kayıtlı bir kullanıcı bulunamadı.";
    }

    $conn->close();
}

?>
