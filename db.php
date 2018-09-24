<?php
    ini_set('error_reporting', E_ALL);

    define("MySQL_USER", getenv('C9_USER'));
    define("MySQL_PASSWORD", "");
    define("MySQL_DB_NAME", "c9");
    define("MySQL_HOST", getenv('IP'));
   
   
    class DB {
        protected $dbh;
        
        function __construct() {
            try {
                $this->dbh = new PDO('mysql:host='.MySQL_HOST.';dbname=' . MySQL_DB_NAME, MySQL_USER, MySQL_PASSWORD);     
            } catch (PDOException $e) {
                print "Error!: Cannot connect to db! Check connection " . $e->getMessage() . "<br/>";
                die();
            }    
        }
        
    }
 ?>