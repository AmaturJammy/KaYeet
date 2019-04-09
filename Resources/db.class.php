<?php
class DB {
    protected static $instance;
    protected $pdo;
    public function __construct(){
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "kayeet";
        $charset = "utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES      => false,
        ];
        $dsn = "mysql:host=$host;dbname=$database;charset=$charset";
        $this->pdo = new PDO($dsn, $username, $password, $options);
    }
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->pdo, $method), $args);
    }
    public function run($sql, $args = [])
    {
        if (!$args)
        {
            return $this->query($sql);
        }
        try {
            $stmt = $this->pdo->prepare($sql);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
        $stmt->execute($args);
        return $stmt;
    }
}
?>