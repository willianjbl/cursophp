<?php 
//iniciando a classe Usuario
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
	//function para inserir os dados nas colunas, nas demais functions
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
		/*Criando condição "Se INDEX for MAIOR que '0', exibir '$results' no INDEX 0", como o a function está pesquisando por ID,
		ela só irá carregar uma linha da table, já que a coluna é uma PRIMARY_KEY.*/
		if (count($results) > 0) {
			$this->setData($results[0]);
		}
	}
	//Function para carregar uma lista ordenada por Login, de dados do banco
	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}
	//Function para carregar uma lista de usuarios, buscando no banco por Login.
	public static function search($login){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}
	//Function para acessar os dados do usuario, autenticando o mesmo por Login e Senha.
	public function login($login, $password){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(":LOGIN"=>$login, ":PASSWORD"=>$password));

		if (count($results) > 0) {
			$this->setData($results[0]);
		} else {
			throw new Exception("Login e/ou senha inválidos.");
		}
	}
	//Inserir dados na tabela com stored procedure
	public function insert() {
		$sql = new Sql();
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),':PASSWORD'=>$this->getDessenha()
		));
		
		if (count($results) > 0) {
			$this->setData($results[0]);
		}
	}
	//incluindo usuario e senha para a function 'insert', como parametros da classe 'Usuario'
	public function __construct($login = "" ,$password = "") {
		$this->setDeslogin($login);
		$this->setDessenha($password);
	}
	//Function para alterar dados na tabela
	public function update($login, $password){
		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdUsuario()
		));
	}
	//Criando function passar dados da function para uma String por JSON
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