<?php
include_once('conexao.php'); 

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $modalidade = $_POST['especialidade'];

    // CORREÇÃO: usa $conn (e não $conexao)
    $sqlInsert = "INSERT INTO professor (nome, modalidade) VALUES ('$nome', '$modalidade')";
    $result = mysqli_query($conn, $sqlInsert);

    if ($result) {
        echo "<p style='color:green;'>✅ Professor cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>❌ Erro ao cadastrar professor: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Professor</title>

    <style>
       body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #181818;
            color: white;
        }

        .cadastro {
            max-width: 450px;
            margin: 60px auto;
            background: #222;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.4);
        }

        .cadastro h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #f0a500;
        }

        .cadastro form label {
            font-weight: bold;
            font-size: 15px;
        }

        .cadastro form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 6px 0 18px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: #333;
            color: white;
            font-size: 15px;
        }

        .cadastro form input[type="text"]:focus {
            border: 2px solid #f0a500;
            background: #2b2b2b;
        }

        .botao {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            transition: 0.3s;
        }

        .botao:hover {
            background: #218838;
        }
    </style>

</head>
<body>

<div class="cadastro">
    <h1>Cadastrar Professor</h1>

    <form action="cadastro_professor.php" method="post">
        <label for="nome">Nome do Professor:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" required>

        <input class="botao" type="submit" name="submit" value="Cadastrar">
        <br><br>
        <a href="PainelAdmin.php" class="voltar"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
    </form>
</div>

</body>
</html>