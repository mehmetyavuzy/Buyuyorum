<?php
session_start();

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "Mehmet69436943"; // MySQL şifrenizi buraya girin
$dbname = "Hamileliktakibi"; // Veritabanı adını buraya girin
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Formdan gelen verileri al
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Boş alan kontrolü
if (empty($email) || empty($password)) {
    echo "Email and password cannot be empty";
    exit;
}

// Kullanıcının e-posta adresine göre sorgu yap
$sql = "SELECT id, password_hash FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("MySQL prepare statement error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password_hash'])) {
        // Oturum bilgilerini ayarla
        $_SESSION['user_id'] = $row['id'];
        header("Location: profil.php"); // Profil sayfasına yönlendir
        exit;
    } else {
        echo "Invalid email or password";
    }
} else {
    echo "Invalid email or password";
}

// Veritabanı bağlantısını kapat
$stmt->close();
$conn->close();
?>
