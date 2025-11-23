<?php
include_once("config.php");

if(!isset($_POST['token']) || !isset($_POST['senha'])){
    exit("Erro ao enviar dados.");
}

$token = mysqli_real_escape_string($conexao, $_POST['token']);
$senha = $_POST['senha'];
$confirmar = $_POST['confirmar'];

if($senha !== $confirmar){
    exit("As senhas não conferem!");
}

$sql = "SELECT * FROM aluno WHERE reset_token='$token' AND reset_expires >= NOW()";
$result = mysqli_query($conexao, $sql);

if(mysqli_num_rows($result) == 0){
    exit("Token inválido ou expirado.");
}

$dados = mysqli_fetch_assoc($result);

// Gerar hash seguro
$hash = password_hash($senha, PASSWORD_DEFAULT);

// Atualizar senha e limpar token
$sql = "UPDATE aluno 
        SET senha_hash='$hash', reset_token=NULL, reset_expires=NULL
        WHERE matricula=".$dados['matricula'];

mysqli_query($conexao, $sql);

echo "Senha atualizada com sucesso! <a href='Login.php'>Entrar</a>";
