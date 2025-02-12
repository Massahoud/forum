<?php
require_once 'config.php';
require_once 'controllers/ForumController.php';

use Controllers\ForumController;

$pdo = require 'config.php'; // On s'assure que $pdo est bien retourné
$controller = new ForumController($pdo); // On passe $pdo au contrôleur

$sujets = $controller->afficherSujets();
$mess = $pdo->query("SELECT COUNT(*) AS total_mess FROM forum_reponses");
$resulte = $mess->fetch();
$total_mess = $resulte['total_mess'];
?>
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Forum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.sidebar {
    height: 100vh;
    padding-top: 20px;
}

.sidebar h4 {
    text-align: center;
}

.sidebar .nav-link {
    font-size: 18px;
    padding: 10px;
}

.list-group-item {
    margin-bottom: 10px;
    border-radius: 10px;
    transition: all 0.2s ease-in-out;
}

.list-group-item:hover {
    background-color: #f1f1f1;
}

button.btn-primary {
    border-radius: 10px;
}

</style>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <h4 class="p-3">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="#">📌 Discussions suivies</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">💬 Tous les sujets</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">📢 Annonces</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">⭐ Membre Spotlight</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">💡 Feedback</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3">
                <h2>Discussions récentes</h2>
                <button class="btn btn-primary">+ Nouvelle discussion</button>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Rechercher dans le forum...">
                <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
            </div>

            <div class="list-group">
            <?php foreach ($sujets as $sujet): ?>
                <a href="lire_sujet.php?id_sujet=<?= $sujet['id'] ?>" class="list-group-item list-group-item-action">
                    <h5>📢 <?= htmlentities($sujet['auteur']) ?></h5>
                    <p><?= htmlentities($sujet['titre']) ?></p>
                    <small><?php echo $total_mess; ?> - il y a 5 min <?= date("d-m-Y H:i", strtotime($sujet['date_derniere_reponse'])) ?></small>
                </a>
                <?php endforeach; ?>
               
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
