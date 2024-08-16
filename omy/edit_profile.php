<?php
session_start();

// Kullanıcı girişi yapılmış mı kontrol et
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "Mehmet69436943"; // MySQL şifrenizi buraya girin
$database = "Hamileliktakibi"; // Veritabanı adını buraya girin

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Kullanıcı verilerini al
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

// Kullanıcı verilerini kontrol et
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $birth_date = $row['birth_date'];
    $pregnancy_weeks = $row['pregnancy_weeks'];
    $gender = $row['gender'];
    $baby_name = $row['baby_name'];
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
    <title>Profil Düzenleme</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <header>
        <h2>Profil Düzenleme</h2>
    </header>
    <nav>
        <ul>
            <li><a href="./kullanici/index.html">Anasayfa</a></li>
            <li><a href="./kullanici/gebelik.html">Gebelik Takibi</a></li>
            <li><a href="./kullanici/spin.html">İsim Çarkı</a></li>
            <li><a href="./kullanici/bebek.html">Bebeğin Resimleri</a></li>
            <li><a href="profil.php">Profilim</a></li>
            <li><a href="logout.php">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main>
        <h3>Profil Bilgilerinizi Düzenleyin</h3>
        <form action="update_profile.php" method="post">
            <label for="first_name">Ad:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required><br>
            
            <label for="last_name">Soyad:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>
            
            <label for="phone_number">Telefon Numarası:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>"><br>
            
            <label for="birth_date">Doğum Tarihi:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $birth_date; ?>"><br>
            
            <label for="pregnancy_weeks">Kaç Haftalık Hamile:</label>
            <input type="number" id="pregnancy_weeks" name="pregnancy_weeks" value="<?php echo $pregnancy_weeks; ?>"><br>
            
            <label for="gender">Cinsiyet:</label>
            <select id="gender" name="gender">
              <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Erkek</option>
              <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Kadın</option>
            </select><br>

            
            <label for="baby_name">Bebeğin Adı:</label>
            <input type="text" id="baby_name" name="baby_name" value="<?php echo $baby_name; ?>"><br>
            
            <button type="submit">Güncelle</button>
        </form>
    </main>
</body>
</html>
