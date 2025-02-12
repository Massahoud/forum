<?php
require 'controllers/ForumController.php';
require 'config.php'; // Assurez-vous que ce fichier initialise correctement la connexion PDO

use Controllers\ForumController;

$forumController = new ForumController($pdo);
$erreur = null;

// Vérifie si l'identifiant du sujet est bien passé en paramètre
if (!isset($_GET['id_sujet']) || !ctype_digit($_GET['id_sujet'])) {
    die("ID du sujet invalide.");
}

$id_sujet = intval($_GET['id_sujet']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erreur = $forumController->handleReponseSubmission();
    if ($erreur === true) {
        header("Location: view_lire_sujet.php?id_sujet=" . $id_sujet); // Redirection vers le sujet
        exit();
    }
}

// Récupérer les informations du sujet pour l'affichage
$sujet = $forumController->getSujet($id_sujet);
if (!$sujet) {
    die("Sujet introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter une réponse - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Répondre au sujet : <strong><?= htmlspecialchars($sujet['titre']) ?></strong></h2>

    <?php if (isset($erreur) && $erreur !== true): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form action="" method="post" class="card p-4">
        <input type="hidden" name="id_sujet" value="<?= $id_sujet ?>">
        
        <div class="mb-3">
            <label class="form-label">Auteur :</label>
            <input type="text" name="auteur" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message :</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
        <a href="view_lire_sujet.php?id_sujet=<?= $id_sujet ?>" class="btn btn-secondary">Retour</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
