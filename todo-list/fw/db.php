<?php
    require_once __DIR__ . '/../config.php';
    // Create logs with given information
    require_once __ROOT__ . '/log/log.php';

    // stdClass allowes [DynamicProperties]
    class Stmt extends stdClass {
        private $stmt;
        private $conn;

        private $all_binders_types;
        private $all_binders;

        function __construct($statement) {
            $this->conn = getConnection();
            $this->stmt = $this->conn->prepare($statement);
            $this->all_binders = array();
            $this->all_binders_types = "";
            return $this;
        }

        function bindString($binder) {
            array_push($this->all_binders, $binder);
            $this->all_binders_types .= "s";
            return $this;
        }
        function bindFloat($binder) {
            array_push($this->all_binders, $binder);
            $this->all_binders_types .= "d";
            return $this;
        }
        function bindInt($binder) {
            array_push($this->all_binders, $binder);
            $this->all_binders_types .= "i";
            return $this;
        }

        function execute() {
            if (count($this->all_binders) !== 0) {
                $this->stmt->bind_param($this->all_binders_types, ...$this->all_binders);
            }

            $this->stmt->execute();
            $this->stmt->store_result();
            return $this->stmt;
        }
    }

    // Depricated: Use class Stmt instead and chain bindings for parameters
    // This prevents SQL injection
    function executeStatement($statement){
        $conn = getConnection();
        $stmt = $conn->prepare($statement);
        $stmt->execute();
        $stmt->store_result();
        return $stmt;
    }

    function getConnection() {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require_once "$root/config.php";
        //require_once 'config.php';
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if ($conn->connect_error) {
            $log->error("Database connection failed for user '" . $_SESSION['username'] . "': " . $conn->connect_error);
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
?>