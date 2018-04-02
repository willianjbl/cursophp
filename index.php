<?php 

require_once("config.php");

/*
$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
echo json_encode($usuarios);
*/

//---Carrega um usuário baseado em seu ID.
//$buscaId = new Usuario();
//$buscaId->loadById(2);
//echo $buscaId;

//---Carrega uma Lista de usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

//---Carrega uma Lista de usuários, buscando pelo login
//$search = Usuario::search("e");
//echo json_encode($search);

//---Carrega os dados de um usuário, usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("maxi", "123456");
//echo $usuario;

//--
$aluno = new Usuario("nova", "654321");
$aluno->insert();
echo $aluno;

?>