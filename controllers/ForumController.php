<?php
namespace Controllers;

require_once __DIR__ . '/../models/ForumModel.php';

use Models\ForumModel;

class ForumController {
    private $model;

    public function __construct(\PDO $pdo) {
        $this->model = new ForumModel($pdo);
    }

    public function handleFormSubmission(): ?string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auteur = trim($_POST['auteur'] ?? '');
            $titre = trim($_POST['titre'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($auteur === '' || $titre === '' || $message === '') {
                return 'Tous les champs doivent être remplis.';
            }

            return $this->model->insertSujet($auteur, $titre, $message);
        }
        return null;
    }

    public function handleReponseSubmission(): ?string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auteur = trim($_POST['auteur'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $id_sujet = $_POST['id_sujet'] ?? '';
    
            if ($auteur === '' || $message === '' || !ctype_digit($id_sujet)) {
                return 'Tous les champs doivent être remplis et l’identifiant du sujet doit être valide.';
            }
    
            $id_sujet = intval($id_sujet);
            $result = $this->model->insertReponse($auteur, $message, $id_sujet);
    
            return $result === true ? true : $result;
        }
        return null;
    }
    

    public function getSujet(int $id_sujet): ?array {
        return $this->model->getSujet($id_sujet);
    }

    public function getReponses(int $id_sujet): array {
        return $this->model->getReponses($id_sujet);
    }

    public function afficherSujets(): array {
        return $this->model->getAllSujets();
    }
    
}
