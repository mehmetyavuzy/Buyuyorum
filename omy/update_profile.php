<?php
session_start();

// Kullanıcı girişi yapılmış mı kontrol et
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "Mehmet69436943";
$database = "Hamileliktakibi";

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Kullanıcı verilerini al
$user_id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$birth_date = $_POST['birth_date'];
$pregnancy_weeks = $_POST['pregnancy_weeks'];
$gender = $_POST['gender'];
$baby_name = $_POST['baby_name'];

// Gender değerini doğrulama
if ($gender !== 'Male' && $gender !== 'Female') {
    die("Geçersiz cinsiyet değeri.");
}

// Profil bilgilerini güncelle
$sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number', birth_date='$birth_date', pregnancy_weeks='$pregnancy_weeks', gender='$gender', baby_name='$baby_name' WHERE id='$user_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: profil.php");
} else {
    die("Hata: " . $conn->error);
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
