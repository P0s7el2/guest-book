<?php

namespace app\lib;

use PDO;

class Db {

	protected $db;
	
	public function __construct() {
		$config = require 'app/config/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['pass']);
	}

	public function query($sql, $params = []){
	    // защита от sql инъекций
	    // подготавливает запрос к запуску в бд для замены :name на реальное значение
	    $stmt = $this->db->prepare($sql);
	    // проверяем на наличие параметров
        if(!empty($params)){
            // проходимся циклом по параметрам
            foreach ($params as $key => $val){
                //связываем значение в запросе и в параметрах
                $stmt->bindValue(':'.$key, $val);
            }
        }
        //запускаем подготовленный запрос
        $stmt->execute();

        return $stmt;
    }

    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function lastInsertId(){
	    return $this->db->lastInsertId();
    }
}