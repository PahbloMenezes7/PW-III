<?php

require_once 'Database.php';

class Usuario {

    // Atributos
    private $conn;
    private ?int $id;
    private ?string $email;
    private ?string $senha;

    
    public function __construct() {
        $this->conn = Database::getConnection();
        $this->id = null;
        $this->email = null;
        $this->senha = null;
    }
    
    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }


    public function setSenha(string $senha): void {
        $this->senha = password_hash($senha, PASSWORD_ARGON2ID);
    }
    
    
    public function findById(int $id): ?self {
        $query = "SELECT id, email, senha FROM usuarios WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = (int)$row['id'];
            $this->email = $row['email'];
            $this->senha = $row['senha'];
            return $this;
        }

        return null;
    }

    
    public function save(): bool {
        if (is_null($this->id)) { 
            $query = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
            $stmt = $this->conn->prepare($query);
            
            $this->email = htmlspecialchars(strip_tags($this->email));
            
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':senha', $this->senha);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
        }
        return false;
    }
    
    
    public static function checkUser(string $email): bool {
        $conn = Database::getConnection();
        $query = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    
    
    public static function checkPass(string $email, string $pass): ?Usuario {
        $conn = Database::getConnection();
        $query = "SELECT id, email, senha FROM usuarios WHERE email = :email LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash_senha_banco = $row['senha'];
            
            
            if (password_verify($pass, $hash_senha_banco)) {
                $usuario = new Usuario();
                $usuario->id = (int)$row['id'];
                $usuario->email = $row['email'];
                $usuario->senha = $row['senha'];
                return $usuario;
            }
        }
        
        return null;
    }
}