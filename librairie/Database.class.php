<?php 

class Database{

	const DB_NAME = "base_name";
	const DB_USER = "base_user";
	const DB_PASS = "base_pass";
	const DB_HOST = "base_host";

	public function __construct(){
		return $this->getPDO();
	}

	private static function getPDO(){
		$pdo = new PDO('mysql:dbname='.self::DB_NAME.';host='.self::DB_HOST,self::DB_USER,self::DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $pdo;
	}

	public static function selectAll($statement){
		if(isset($statement)) { 
			$req = self::getPDO()->query($statement);
			$datas = $req->fetchAll(PDO::FETCH_OBJ);
			if($datas){
				return $datas;
			} else{
				return false;
			}
		}
	}

	public static function selectOne($statement){
		if(isset($statement)) { 
			$req = self::getPDO()->query($statement);
			$datas = $req->fetch(PDO::FETCH_OBJ);
			if($datas){
				return $datas;
			} else{
				return false;
			}
		}
	}

	public static function update($req){
		$req= self::getPDO()->prepare($req);
		$req->execute();
	}

	public function getCount($table){
		$req = self::getPDO()->query('SELECT count(*) as compteur FROM '.$table);
		$fetch = $req->fetch(PDO::FETCH_OBJ);
		return $fetch;
	}

	private function getSomme(){
		// $result = $this->getPDO()->query("SELECT sum(retrait) somme_retrait, sum(ajout) somme_ajout, count(id)nombre_billet FROM OperationList");
		// $result = $result->fetch()
		// return $result;
	}

}