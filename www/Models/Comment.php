<?php

namespace App\Models;

use App\Core\SQL;
use PDO;

class Comment extends SQL
{
    private ?int $id = null;
    protected int $article_id;
    protected int $user_id;
    protected string $content;
    protected string $created_at;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }

    /**
     * @param int $article_id
     */
    public function setArticleId(int $article_id): void
    {
        $this->article_id = $article_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = trim($content);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Obtenir tous les commentaires pour un article donné
     *
     * @param PDO $pdo
     * @param int $article_id
     * @return array
     */
    public function getCommentsByArticleId(PDO $pdo, int $article_id): array
    {
        $sql = "SELECT * FROM esgi_comment WHERE article_id = :article_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllComments(PDO $pdo): array
    {
        $sql = "SELECT * FROM esgi_comment";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Ajouter un nouveau commentaire
     *
     * @param PDO $pdo
     * @return bool
     */
    public function create(PDO $pdo): bool
    {
        $sql = "INSERT INTO esgi_comment (article_id, user_id, content) VALUES (:article_id, :user_id, :content)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':article_id' => $this->article_id,
            ':user_id' => $this->user_id,
            ':content' => $this->content,
        ]);
    }

    /**
     * Mettre à jour un commentaire
     *
     * @param PDO $pdo
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateComment(PDO $pdo, int $id, array $data): bool
    {
        $sql = "UPDATE esgi_comment SET content = :content, created_at = :created_at WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':content' => $data['content'],
            ':created_at' => $data['created_at'],
            ':id' => $id,
        ]);
    }

    /**
     * Supprimer un commentaire par ID
     *
     * @param PDO $pdo
     * @param int $id
     * @return bool
     */
    public function deleteComment(PDO $pdo, int $id): bool
    {
        $sql = "DELETE FROM esgi_comment WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
