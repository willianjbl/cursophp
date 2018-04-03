<?php 
//inicia uma classe extendida de PDO
class Sql extends PDO {
	//Inicia a Conexão MySQL
	private $conn;

	public function __construct(){
		$this->conn = new PDO("mysql:host=localhost;port=3306;dbname=dbphp7", "maxi", "aradois");
	}
	//Aplica os parametros aplicados pela function setParam
	private function setParams($statement, $parameters = array()){
		foreach ($parameters as $key => $value) {
			$this->setParam($statement, $key, $value);
		}
	}
	//Aplica os parametros individuais
	private function setParam($statement, $key, $value){
		
		$statement->bindParam($key, $value);
	}
	//function de preparar/modificar os dados no banco
	public function query($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt;
	}
	//function para puxar/buscar os dados do banco
	public function select($rawQuery, $params = array()):array {
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>