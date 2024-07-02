<?php

namespace App\Models;

use App\Core\SQL;
use PDO;

class Article extends SQL
{
    private ?int $id = null;
    protected string $title;
    protected string $content;
    protected string $author;
    protected string $created_at;
    protected string $updated_at;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim($title);
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
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
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
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Obtenir tous les articles
     *
     * @param PDO $pdo
     * @return array
     */
    public function getAllArticles(PDO $pdo): array
    {
        $sql = "SELECT * FROM esgi_article";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtenir un article par ID
     *
     * @param PDO $pdo
     * @param int $id
     * @return array|false
     */
    public function getArticleById(PDO $pdo, int $id)
    {
        $sql = "SELECT * FROM esgi_article WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajouter un nouvel article
     *
     * @param PDO $pdo
     * @return bool
     */
    public function create(PDO $pdo): bool
    {
        $sql = "INSERT INTO esgi_article (title, content, author ) VALUES (:title, :content, :author)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $this->title,
            ':content' => $this->content,
            ':author' => $this->author,
        ]);
    }

    /**
     * Mettre à jour un article
     *
     * @param PDO $pdo
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateArticle(PDO $pdo, int $id): bool
    {
        $sql = "UPDATE esgi_article SET title = :title, content = :content, author = :author WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $this->title,
            ':content' => $this->content,
            ':author' => $this->author,
            ':id' => $id,
        ]);
    }

    /**
     * Supprimer un article par ID
     *
     * @param PDO $pdo
     * @param int $id
     * @return bool
     */
    public function deleteArticle(PDO $pdo, int $id): bool
    {
        $sql = "DELETE FROM esgi_article WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
