<?php
include('conexao.php');


if (!isset($_GET['matricula'])) {
  die("Matrícula não informada.");
}

$matricula = $_GET['matricula'];


$sql = "SELECT * FROM aluno WHERE matricula = '$matricula'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  die("Aluno não encontrado.");
}

$aluno = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $email = $_POST['email'];
  $cep = $_POST['cep'];
  $endereco = $_POST['endereco'];
  $plano = $_POST['plano'];
  $login = $_POST['login'];

  $sqlUpdate = "UPDATE aluno 
                SET nome='$nome', cpf='$cpf', email='$email', cep='$cep', endereco='$endereco', plano='$plano', login='$login' 
                WHERE matricula='$matricula'";

  if ($conn->query($sqlUpdate)) {
    echo "<script>alert('Aluno atualizado com sucesso!'); window.location.href='PainelAdmin.php';</script>";
  } else {
    echo "Erro ao atualizar: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Aluno</title>
  <link rel="stylesheet" href="styleeditar.css">
</head>
<body>
 <header class="menu">
    <h2>GYM SYSTEM - ADMIN</h2>
    <nav>
        <a href="PainelAdmin.php">Painel Administrador</a>
    </nav>
</header>

<main class="container">
  <h1>Editar Aluno</h1>

  <form method="POST" class="formulario">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $aluno['nome'] ?>" required>

    <label>CPF:</label>
    <input type="text" name="cpf" value="<?= $aluno['cpf'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $aluno['email'] ?>" required>

    <label>CEP:</label>
    <input type="text" name="cep" value="<?= $aluno['cep'] ?>">

    <label>Endereço:</label>
    <input type="text" name="endereco" value="<?= $aluno['endereco'] ?>">

    <label>Plano:</label>
    <input type="text" name="plano" value="<?= $aluno['plano'] ?>">

    <label>Login:</label>
    <input type="text" name="login" value="<?= $aluno['login'] ?>">

    <div class="botoes">
        <button type="submit" class="salvar">Salvar alterações</button>
        <a href="PainelAdmin.php" class="cancelar">Cancelar</a>
    </div>
  </form>
</main>

</body>
</html>