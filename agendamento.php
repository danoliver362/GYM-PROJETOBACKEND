<?php
session_start();
include_once('conexao.php');


if (!isset($_SESSION['logado'])) {
    header("Location: Login.php");
    exit;
}



// Impede acesso sem login
if(!isset($_SESSION['matricula'])){
    header("Location: login.php");
    exit();
}

// Dados do aluno logado
$matricula = $_SESSION['matricula'];
$nomeAluno = $_SESSION['nome'];


// Buscar lista de professores
$sqlProfessores = "SELECT id_professor, nome, modalidade FROM professor ORDER BY nome ASC";
$resultProfessores = mysqli_query($conn, $sqlProfessores);


// Se enviou o formulário
if (isset($_POST['submit'])) {

    $data_aula = $_POST['data_aula'];
    $hora_aula = $_POST['hora_aula'];
    $tipo_aula = $_POST['tipo_aula'];
    $id_professor = $_POST['id_professor'];

    $sqlInsert = "INSERT INTO agendamento (data_aula, hora_aula, tipo_aula, matricula, id_professor) 
                  VALUES ('$data_aula', '$hora_aula', '$tipo_aula', '$matricula', '$id_professor')";
    
    $result = mysqli_query($conn, $sqlInsert);

    if ($result) {
        echo "<p style='color:green;'>Agendamento salvo com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao agendar: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendar Aula</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleagendamento.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

<header>
    <div class="logo">
      <a>GYM</a>
    </div>
    <nav>
      <a href="TelaPrincipal.php">INICIO</a>
      <a href="Login.php"><i class="bi bi-person-circle"></i>LOGIN</a>
      <a href="#"><i class="bi bi-box-arrow-right"></i>LOGOUT</a>
      <a href="cadastroacademia.php"><i class="bi bi-person-plus"></i>CADASTRE-SE</a>
    </nav>
  </header>

<div class="Agendamento"> 
    <h1>AGENDAR AULA</h1>

    <p><strong>Matrícula:</strong> <?= $matricula ?></p>
    <p><strong>Aluno:</strong> <?= $nomeAluno ?></p>

    <form action="" method="POST">

        <label for="data_aula">Data da aula:</label>
        <input type="date" name="data_aula" id="data_aula" required>

        <label for="hora_aula">Hora da aula:</label>
        <input type="time" name="hora_aula" id="hora_aula" required>

        <label for="tipo_aula">Tipo de aula:</label>
        <input type="text" name="tipo_aula" id="tipo_aula" required>

        <label for="id_professor">Professor:</label>
        <select name="id_professor" id="id_professor" required>
            <option value="">Selecione um professor</option>
            <?php while ($row = mysqli_fetch_assoc($resultProfessores)) { ?>
                <option value="<?= $row['id_professor'] ?>">
                    <?= $row['nome'] ?> — <?= $row['modalidade'] ?>
                </option>
            <?php } ?>
        </select>

        <input class="botao" type="submit" name="submit" value="Agendar">
    </form>
</div>

<footer class="footer">
  <div class="footer-container">
    <h3 class="footer-logo">GYM</h3>

    <ul class="footer-links">
      <li><a href="#">Política de Privacidade</a></li>
      <li><a href="#">Termos de Uso</a></li>
      <li><a href="#">Contato</a></li>
    </ul>
    
    <p class="footer-copy">© 2025 GYM. Todos os direitos reservados.</p>
  </div>
</footer>

  <script src="script.js"></script>
</body>
</html>
