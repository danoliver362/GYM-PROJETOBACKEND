<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("config.php");

if(!isset($_POST['login'])){
    exit("Acesso inválido!");
}

$login = mysqli_real_escape_string($conexao, $_POST['login']);

// Buscar aluno
$sql = "SELECT * FROM aluno WHERE login='$login'";
$result = mysqli_query($conexao, $sql);

if(!$result){
    die("Erro SQL: " . mysqli_error($conexao));
}

if(mysqli_num_rows($result) == 0){
    echo "Se o usuário existir, enviaremos um e-mail.";
    exit();
}

$usuario = mysqli_fetch_assoc($result);

// Criar token seguro
$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Atualizar banco
$sql = "UPDATE aluno SET reset_token='$token', reset_expires='$expira' WHERE login='$login'";
if(!mysqli_query($conexao, $sql)){
    die("Erro ao salvar token: " . mysqli_error($conexao));
}

// Link de redefinição
$link = "http://localhost/academia/redefinir.php?token=$token";

echo "<h3>Link de redefinição:</h3>";
echo "<a href='$link'>$link</a>";
