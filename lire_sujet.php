<?php
require 'config.php'; // Assurez-vous que ce fichier initialise correctement la connexion PDO
require 'controllers/ForumController.php';

use Controllers\ForumController;

$controller = new ForumController($pdo);

// Vérification et récupération de l'ID du sujet
$id_sujet = $_GET['id_sujet'] ?? null;
if (!$id_sujet || !ctype_digit($id_sujet)) {
    die("ID du sujet invalide.");
}
$id_sujet = intval($id_sujet);

// Récupération des données du sujet et des réponses
$sujet = $controller->getSujet($id_sujet);
$reponses = $controller->getReponses($id_sujet);

if (!$sujet) {
    die("Sujet introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lecture d'un sujet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Discussion : <?= htmlentities($sujet['titre']) ?></h2>

    <div class="card p-4 mb-4">
        <p><strong>Auteur :</strong> <?= htmlentities($sujet['auteur']) ?></p>
        <p><strong>Date de création :</strong> <?= date("d-m-Y H:i", strtotime($sujet['date_creation'])) ?></p>
        <hr>
        <p><?= nl2br(htmlentities($sujet['titre'])) ?></p>
    </div>

    <h4>Réponses :</h4>
    <?php if (empty($reponses)): ?>
        <div class="alert alert-warning">Aucune réponse pour le moment.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($reponses as $reponse): ?>
                <li class="list-group-item">
                    <strong><?= htmlentities($reponse['auteur']) ?></strong> - 
                    <small><?= date("d-m-Y H:i", strtotime($reponse['date_reponse'])) ?></small>
                    <p><?= nl2br(htmlentities($reponse['message'])) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="mt-4">
        <a href="insert_reponse.php?id_sujet=<?= $id_sujet ?>" class="btn btn-primary">Répondre</a>
        <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
