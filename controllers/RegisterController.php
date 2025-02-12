<?php
include '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
 
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $password_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Vérifier si l'email existe déjà
    $query = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $query->execute([$email]);

    if ($query->rowCount() > 0) {
        $_SESSION['message'] = "Cet email est déjà utilisé.";
        header("Location: ../login/login.php");
        exit();
    }

    // Insérer l'utilisateur
    $query = $pdo->prepare("INSERT INTO users (nom,email, mot_de_passe) VALUES (?, ?,?)");
    if ($query->execute([$nom, $email, $password_hash])) {
        $_SESSION['message'] = "Inscription réussie ! Connectez-vous.";
        header("Location: ../login/login.php");
    } else {
        $_SESSION['message'] = "Erreur lors de l'inscription.";
    }
    exit();
}
?>