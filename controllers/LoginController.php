<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['mot_de_passe'];

    $query = $pdo->prepare("SELECT id, nom, mot_de_passe FROM users WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        header("Location: ../dashboard.php");
        exit();
    } else {
        $_SESSION['message'] = "Email ou mot de passe incorrect.";
    }
}
?>
