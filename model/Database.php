<?php
class Database {
    private PDO $connection;

	function __construct(){
		if (!defined('DSN')) define('DSN','mysql:host=localhost;dbname=sistema_tarefas');
		if (!defined('USERNAME')) define('USERNAME','root');
		if (!defined('PASSWORD')) define('PASSWORD','');
	}

	function getConnection(){
		try {
            $this->connection = new PDO(DSN, USERNAME, PASSWORD);
		}catch (Exception $e){
			echo 'ERROR CODE: ' .$e->getCode() .' MESSAGE:: ' .$e->getMessage();
			die();
		}
		return $this->connection;
	}

}