<?php
require 'controllers/ForumController.php';
require 'config.php'; // Assurez-vous que ce fichier initialise correctement la connexion PDO

use Controllers\ForumController;

$forumController = new ForumController($pdo);
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erreur = $forumController->handleFormSubmission();
    if ($erreur === true) {
        header("Location: index.php"); // Redirection vers la liste des sujets
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un sujet - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Ajouter un nouveau sujet</h2>

    <?php if (isset($erreur) && $erreur !== true): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form action="" method="post" class="card p-4">
        <div class="mb-3">
            <label class="form-label">Auteur :</label>
            <input type="text" name="auteur" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Titre :</label>
            <input type="text" name="titre" class="form-control" maxlength="100" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message :</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Poster</button>
        <a href="index.php" class="btn btn-secondary">Retour</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
