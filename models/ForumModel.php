<?php
namespace Models;

class ForumModel {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insertSujet(string $auteur, string $titre, string $message): bool|string {
        $date = date("Y-m-d H:i:s");
        try {
            // Insérer un sujet dans forum_sujets
            $stmt = $this->pdo->prepare("INSERT INTO forum_sujets (auteur, titre, date_creation, date_derniere_reponse) 
                                         VALUES (:auteur, :titre, :date, :date)");
            $stmt->execute([':auteur' => $auteur, ':titre' => $titre, ':date' => $date]);
            $id_sujet = $this->pdo->lastInsertId();

            // Ajouter le premier message en tant que réponse dans forum_reponses
            $stmt = $this->pdo->prepare("INSERT INTO forum_reponses (sujet_id, auteur, message, date_reponse) 
                                         VALUES (:id_sujet, :auteur, :message, :date)");
            $stmt->execute([':id_sujet' => $id_sujet, ':auteur' => $auteur, ':message' => $message, ':date' => $date]);

            return true;
        } catch (\PDOException $e) {
            return "Erreur SQL : " . $e->getMessage();
        }
    }

    public function insertReponse(string $auteur, string $message, int $id_sujet): bool|string {
        $date = date("Y-m-d H:i:s");
        try {
            // Insérer la réponse dans forum_reponses
            $stmt = $this->pdo->prepare("INSERT INTO forum_reponses (sujet_id, auteur, message, date_reponse) 
                                         VALUES (:id_sujet, :auteur, :message, :date)");
            $stmt->execute([':id_sujet' => $id_sujet, ':auteur' => $auteur, ':message' => $message, ':date' => $date]);

            // Mettre à jour la date de la dernière réponse dans forum_sujets
            $stmt = $this->pdo->prepare("UPDATE forum_sujets SET date_derniere_reponse = :date WHERE id = :id_sujet");
            $stmt->execute([':date' => $date, ':id_sujet' => $id_sujet]);

            return true;
        } catch (\PDOException $e) {
            return "Erreur SQL : " . $e->getMessage();
        }
    }

    public function getAllSujets(): array {
        // Récupérer tous les sujets triés par la dernière réponse
        $stmt = $this->pdo->query("SELECT id, auteur, titre, date_creation, date_derniere_reponse 
                                   FROM forum_sujets 
                                   ORDER BY date_derniere_reponse DESC");
        return $stmt->fetchAll();
    }

    public function getSujet(int $id_sujet): ?array {
        // Récupérer un sujet spécifique
        $stmt = $this->pdo->prepare("SELECT * FROM forum_sujets WHERE id = ?");
        $stmt->execute([$id_sujet]);
        return $stmt->fetch() ?: null;
    }

    public function getReponses(int $id_sujet): array {
        // Récupérer toutes les réponses d'un sujet
        $stmt = $this->pdo->prepare("SELECT id, auteur, message, date_reponse 
                                     FROM forum_reponses 
                                     WHERE sujet_id = ? 
                                     ORDER BY date_reponse ASC");
        $stmt->execute([$id_sujet]);
        return $stmt->fetchAll();
    }
}
