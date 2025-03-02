<?php
session_start();

// Database configuration
$host = "localhost";
$dbname = "ghrcem_learning";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $course = htmlspecialchars($_POST['course']);

    if (!empty($name) && !empty($email) && !empty($course)) {
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone, course) VALUES (:name, :email, :phone, :course)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":course", $course);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful!";
        } else {
            $_SESSION['error'] = "Registration failed!";
        }
    } else {
        $_SESSION['error'] = "All fields are required!";
    }
    header("Location: register.php");
    exit();
}
