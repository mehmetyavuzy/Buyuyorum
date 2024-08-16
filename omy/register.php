<?php
// Formdan diğer gerekli bilgileri alın
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$birth_date = $_POST['birth_date'];
$pregnancy_weeks = $_POST['pregnancy_weeks'];
$gender = $_POST['gender'];
$baby_name = $_POST['baby_name'];
$password = $_POST['password'];

// Şifreyi hash'le
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Veritabanına bağlanma
$servername = "localhost";
$username = "root";
$db_password = "Mehmet69436943"; // MySQL şifrenizi buraya girin
$dbname = "Hamileliktakibi"; // Veritabanı adını buraya girin

$conn = new mysqli($servername, $username, $db_password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Veritabanına veri ekleme
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, birth_date, pregnancy_weeks, gender, baby_name, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssisss", $first_name, $last_name, $email, $phone_number, $birth_date, $pregnancy_weeks, $gender, $baby_name, $password_hash);

// Sorguyu çalıştır
if ($stmt->execute()) {
    // Kayıt başarıyla eklendi, kullanıcıyı login.html sayfasına yönlendir
    header("Location: login.html");
    exit; // Yönlendirme işleminden sonra kodun devam etmemesi için exit kullanıyoruz
} else {
    echo "Hata: " . $stmt->error;
}

// Bağlantıyı ve ifadeyi kapat
$stmt->close();
$conn->close();
?>
