<?php

namespace App\Models;

use App\Core\SQL;
use PDO;

class Page extends SQL
{
    private ?int $id = null;
    protected string $title;
    protected string $content;
    protected string $html;
    protected string $css ; 
    protected string $custom_css;
    protected string $type;

    const PAGE_TYPES = [
        'home' => 'Accueil',
        'about' => 'À propos',
        'actu' => 'Actualités',
        'galerie' => 'Galerie',
        'contact' => 'Contact',
        'forum' => 'Forum'
    ];

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
    public function gettitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function settitle(string $title): void
    {
        $this->title = trim($title);
    }

    /**
     * @return string
     */
    public function getcontent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setcontent(string $content): void
    {
        $this->content = trim($content);
    }

    /**
     * @return string
     */
    public function gethtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function sethtml(string $html): void
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getcss(): string
    {
        return $this->css;
    }

    /**
     * @param string $css
     */
    public function setcss(string $css): void
    {
        $this->css = $css;
    }

    /**
     * @return string
     */
    public function getcustom_css(): string
    {
        return $this->custom_css;
    }

    /**
     * @param string $custom_css
     */
    public function setcustom_css(string $custom_css): void
    {
        $this->custom_css = $custom_css;
    }

    /**
     * @return string
     */
    public function gettype(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function settype(string $type): void
    {
        if (!array_key_exists($type, self::PAGE_TYPES)) {
            throw new \InvalidArgumentException("Type de page invalide");
        }
        $this->type = $type;
    }

    /**
     * Vérifie si un type de page existe déjà dans la base de données
     *
     * @param PDO $pdo
     * @param string $type
     * @return bool
     */
    public static function istypeExists(PDO $pdo, string $type): bool
    {
        $sql = "SELECT COUNT(*) FROM esgi_page WHERE type = :type";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':type' => $type]);
        $count = $stmt->fetchColumn();
        return ($count > 0);
    }

    public function getAllPages($pdo)
    {
        $this->pdo = $pdo;
        $sql = "SELECT * FROM esgi_page";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageById($pdo, $id)
    {
        $this->pdo = $pdo;
        $sql = "SELECT * FROM esgi_page WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetch(PDO::FETCH_ASSOC);
    }

    public function getPageContentByType($pdo, $type)
    {
        $this->pdo = $pdo;
        $sql = "SELECT content FROM esgi_page WHERE type = :type";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':type', $type, PDO::PARAM_STR);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['content'] : null; // Retourne le contenu ou null si aucune page trouvée
    }

    public function updatePageContent($pdo, $id, $newContent)
    {
        $this->pdo = $pdo;
        $sql = "UPDATE esgi_page SET content = :content WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':content', $newContent, PDO::PARAM_STR);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        return $queryPrepared->execute();
    }

    public function deletePageById($pdo, $id)
    {
        $this->pdo = $pdo;
        $sql = "DELETE FROM esgi_page WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        $queryPrepared->execute();

        // Vérifier si la suppression a réussi
        if ($queryPrepared->rowCount() > 0) {
            return true; // La suppression a réussi
        } else {
            return false; // Aucun enregistrement n'a été supprimé
        }
    }


}
