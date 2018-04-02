<?php 
//inicia uma classe
class Usuario {
	//criando variaveis das colunas do banco
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	//GETTERS and SETTERS
	public function getIdUsuario() {
		return $this->idusuario;
	}

	public function setIdUsuario($value) {
		$this->idusuario = $value;
	}

	public function getDeslogin() {
		return $this->deslogin;
	}

	public function setDeslogin($value) {
		$this->deslogin = $value;
	}

	public function getDessenha() {
		return $this->dessenha;
	}

	public function setDessenha($value) {
		$this->dessenha = $value;
	}

	public function getDtCadastro() {
		return $this->dtcadastro;
	}

	public function setDtCadastro($value) {
		$this->dtcadastro = $value;
	}
	// ------- FIM DE GETTERS AND SETTERS ------
	//function para inserir os dados das tabelas nas demais functions
	public function setData($data) {
		$this->setIdUsuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtCadastro(new DateTime($data['dtcadastro']));
	}
	//Function para carregar dados no banco por um ID específico
	public function loadById($id) {
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));
		/*Criando condição "Se INDEX for MAIOR que '0', exibir '$rows' no INDEX 0",
		como o a function está pesquisando por ID, ela só irá carregar uma linha da table.*/
		if (count($results) > 0) {
			$this->setData($results[0]);
		}
	}
	//Function para carregar uma lista ordenada de dados no banco
	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}
	//Function para carregar uma lista de usuarios, buscando no banco por login.
	public static function search($login){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}
	//Function para acessar os dados do usuario, identificando por Login e Senha.
	public function login($login, $password){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(":LOGIN"=>$login, ":PASSWORD"=>$password));

		if (count($results) > 0) {
			$this->setData($results[0]);
		} else {
			throw new Exception("Login e/ou senha inválidos.");
		}
	}
	//Inserir dados na tabela
	public function insert() {
		$sql = new Sql();
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),':PASSWORD'=>$this->getDessenha()
		));
		
		if (count($results) > 0) {
			$this->setData($results[0]);
		}
	}
	//incluindo usuario e senha para a function insert, como parametros da classe Usuario
	public function __construct($login = "" ,$password = "") {
		$this->setDeslogin($login);
		$this->setDessenha($password);
	}
	//Criando function passar dados para String por JSON
	public function __toString(){
		return json_encode(array(
			"idusuario"=>$this->getIdUsuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}
}

?>