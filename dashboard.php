<?php
require_once 'config.php';
require_once 'controllers/ForumController.php';

use Controllers\ForumController;

$pdo = require 'config.php'; // On s'assure que $pdo est bien retourné
$controller = new ForumController($pdo); // On passe $pdo au contrôleur

$sujets = $controller->afficherSujets();

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer le nombre total d'utilisateurs
$query = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
$result = $query->fetch();
$total_users = $result['total_users'];

// Récupérer le nombre total de sujets
$disc = $pdo->query("SELECT COUNT(*) AS total_disc FROM forum_sujets");
$resultat = $disc->fetch();
$total_disc = $resultat['total_disc'];

// Récupérer le nombre total de messages
$mess = $pdo->query("SELECT COUNT(*) AS total_mess FROM forum_reponses");
$resulte = $mess->fetch();
$total_mess = $resulte['total_mess'];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard du Forum</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
    body {
    background-color: #f8f9fa;
}

.navbar {
    margin-bottom: 20px;
}

.card {
    margin-bottom: 20px;
}

.list-group-item.active {
    background-color: #007bff;
    border-color: #007bff;
}

.table {
    margin-top: 20px;
}
</style>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Forum Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Statistiques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Paramètres</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenu du dashboard -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">Tableau de bord</a>
                    <a href="#" class="list-group-item list-group-item-action">Utilisateurs</a>
                    <a href="lecture.php" class="list-group-item list-group-item-action">Discussions</a>
                    <a href="#" class="list-group-item list-group-item-action">Rapports</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2>Statistiques</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateurs</h5>
                                <p class="card-text"><?php echo $total_users; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Discussions</h5>
                                <p class="card-text"><?php echo $total_disc; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Messages</h5>
                                <p class="card-text"><?php echo $total_mess; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Derniers Messages</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Auteur</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sujets as $sujet): ?>
                        <tr>
                            <th scope="row"> <?= htmlentities($sujet['id']) ?></th>
                            <td><?= htmlentities($sujet['auteur']) ?></td>
                            <td>  <a href="lire_sujet.php?id_sujet=<?= $sujet['id'] ?>">
                            <?= htmlentities($sujet['titre']) ?></td>
                            <td><?= date("d-m-Y H:i", strtotime($sujet['date_derniere_reponse'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>