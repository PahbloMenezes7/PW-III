    <?php

class Database {
    
    private static $host = 'localhost';
    private static $db_name = 'usuariosPWIII';
    private static $username = 'root';
    private static $password = '';
    // ------------------------------------

    private static $conn;

    public static function getConnection() {
        self::$conn = null;

        try {
            self::$conn = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$db_name . ';charset=utf8',
                self::$username,
                self::$password
            );
            
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo 'Erro de conexão: ' . $exception->getMessage();
        }

        return self::$conn;
    }
}