<?php
namespace App\Models;
use App\Core\SQL;
use PDO;

class User extends SQL
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    private ?int $id = null;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected int $status = 0;
    protected ?int $first_login = 0;
    protected ?string $token_validation = null;
    protected ?string $token_reset_pwd = null;
    protected string $role = self::ROLE_ADMIN;


    /**
     * @return int
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
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

        /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        if (in_array($role, [self::ROLE_USER, self::ROLE_ADMIN])) {
            $this->role = $role;
        }
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @return int
     */
    public function getFirst_login(): int
    {
        return $this->first_login;
    }

    /**
     * @param int $first_login
     */
    public function setFirst_login(int $first_login): void
    {
        $this->first_login = $first_login;
    }

    /**
     * @return string|null
     */
    public function getToken_validation(): ?string
    {
        return $this->token_validation;
    }

    /**
     * @param string|null $token_validation
     */
    public function setToken_validation(?string $token_validation): void
    {
        $this->token_validation = $token_validation;
    }

    /**
     * @return string|null
     */
    public function getToken_reset_pwd(): ?string
    {
        return $this->token_reset_pwd;
    }

    /**
     * @param string|null $token_reset_pwd
     */
    public function setToken_reset_pwd(?string $token_reset_pwd): void
    {
        $this->token_reset_pwd = $token_reset_pwd;
    }

    public function getAllUsers($pdo)
    {
        $this->pdo = $pdo;
        $sql = "SELECT * FROM esgi_user";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    }


}