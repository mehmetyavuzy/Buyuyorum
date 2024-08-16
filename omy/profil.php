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
$password = "Mehmet69436943"; // MySQL şifrenizi buraya girin
$database = "Hamileliktakibi"; // Veritabanı adını buraya girin
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

$user_id = $conn->real_escape_string($_SESSION['user_id']);
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = htmlspecialchars($row['first_name']);
    $last_name = htmlspecialchars($row['last_name']);
    $email = htmlspecialchars($row['email']);
    $phone_number = htmlspecialchars($row['phone_number']);
    $birth_date = htmlspecialchars($row['birth_date']);
    $pregnancy_weeks = htmlspecialchars($row['pregnancy_weeks']);
    $gender = htmlspecialchars($row['gender']);
    $baby_name = htmlspecialchars($row['baby_name']);
} else {
    echo "Kullanıcı bilgisi bulunamadı.";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <header>
        <h2>Profil</h2>
    </header>
    <nav>
        <ul>
        <li><a href="/omy/kullanici/index.html">Anasayfa</a></li>
            <li><a href="./kullanici/gebelik.html">Gebelik Takibi</a></li>
            <li><a href="./kullanici/spin.html">İsim Çarkı</a></li>
            <li><a href="./kullanici/bebek.html">Bebeğin Resimleri</a></li>
            <li><a href="profil.php">Profilim</a></li>
            <li><a href="logout.php">Çıkış </a></li>
        </ul>
    </nav>
    <main>
        <h3>Profil Bilgileriniz</h3>
        <p>Ad: <?php echo $first_name; ?></p>
        <p>Soyad: <?php echo $last_name; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Telefon Numarası: <?php echo $phone_number; ?></p>
        <p>Doğum Tarihi: <?php echo $birth_date; ?></p>
        <p>Kaç Haftalık Hamile: <?php echo $pregnancy_weeks; ?></p>
        <p>Cinsiyet: <?php echo $gender; ?></p>
        <p>Bebeğin Adı: <?php echo $baby_name; ?></p>
        <a href="edit_profile.php">Bilgilerimi Düzenle</a>
    </main>
</body>
</html>
