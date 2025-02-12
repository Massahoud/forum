<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        /* Fond d'écran avec image */
.background-container {
    background-image: url('https://media.istockphoto.com/id/1357658852/photo/crowd-of-around-speech-bubble-chat-message-symbol.jpg?s=612x612&w=0&k=20&c=ENFIGR5fqGPjUpW4Bv0QIIT9X6KZiMWikTQnTakQBUo='); /* Remplacez par le chemin de votre image */
    background-size: cover;
    background-position: center;
    height: 100vh;
    position: relative;
}

/* Overlay sombre pour améliorer la lisibilité */
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Opacité de l'overlay */
}

/* Centrer le formulaire */
.container {
    position: relative;
    z-index: 1;
}

/* Style des cartes de formulaire */
.form-card {
    background-color: rgba(255, 255, 255, 0.9); /* Fond semi-transparent */
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 20px;
}

/* Titre des formulaires */
.card-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Liens pour basculer entre les formulaires */
a {
    color: #007bff;
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}
    </style>

    <!-- Conteneur principal avec fond d'écran -->
    <div class="background-container">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-6 col-lg-4">
                    <!-- Formulaire de Login -->
                    <div id="login-form" class="card form-card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Connexion</h2>
                            <form action="../controllers/LoginController.php" method="POST" >
                                <div class="form-group">
                                    <label for="login-email">Email</label>
                                    <input type="email" class="form-control" name="email" id="login-email" placeholder="Entrez votre email" required>
                                </div>
                                <div class="form-group">
                                    <label for="login-password">Mot de passe</label>
                                    <input type="password" class="form-control" id="login-password" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            </form>
                            <p class="text-center mt-3">
                                Pas encore de compte ? <a href="#" id="show-signup">S'inscrire</a>
                            </p>
                        </div>
                    </div>

                    <!-- Formulaire de Signup -->
                    <div id="signup-form" class="card form-card" style="display: none;">
                        <div class="card-body">
                            <h2 class="card-title text-center">Inscription</h2>
                            <form action="../controllers/RegisterController.php" method="POST" >
                                <div class="form-group">
                                    <label for="signup-username">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="nom" id="signup-username" placeholder="Entrez votre nom d'utilisateur" required>
                                </div>
                                <div class="form-group">
                                    <label for="signup-email">Email</label>
                                    <input type="email" class="form-control" name="email" id="signup-email" placeholder="Entrez votre email" required>
                                </div>
                                <div class="form-group">
                                    <label for="signup-password">Mot de passe</label>
                                    <input type="password" class="form-control" name="mot_de_passe" id="signup-password" placeholder="Créez un mot de passe" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">S'inscrire</button>
                            </form>
                            <p class="text-center mt-3">
                                Déjà un compte ? <a href="#" id="show-login">Se connecter</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>
</html>