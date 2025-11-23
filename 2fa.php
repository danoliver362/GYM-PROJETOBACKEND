<?php
session_start();

// Iniciar tentativas
if (!isset($_SESSION['tentativas_2fa'])) {
    $_SESSION['tentativas_2fa'] = 0;
}

// Garantir que a pergunta existe
if (!isset($_SESSION['pergunta_2fa'])) {
    header("Location: Login.php");
    exit;
}

$pergunta = $_SESSION['pergunta_2fa'];
$texto = "";

switch ($pergunta) {
    case "mae":
        $texto = "Qual o nome da sua mãe?";
        break;

    case "nasc":
        $texto = "Qual a data do seu nascimento? (AAAA-MM-DD)";
        break;

    case "cep":
        $texto = "Qual o CEP do seu endereço?";
        break;

    default:
        $texto = "Pergunta inválida. Faça login novamente.";
        break;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Autenticação 2FA - Academia</title>

<style>
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .container {
        width: 90%;
        max-width: 400px;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        text-align: center;
    }

    h2 {
        margin-bottom: 10px;
        color: #333;
    }

    p {
        color: #555;
        font-size: 15px;
    }

    form {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    input[type="text"] {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: .2s;
    }

    button {
        padding: 12px;
        background: #4CAF50;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Autenticação de 2 Fatores</h2>
    <p><?php echo $texto; ?></p>

    <form action="validar_2fa.php" method="POST">
        <input type="text" name="resposta" placeholder="Digite sua resposta..." required>
        <button type="submit">Confirmar</button>
    </form>
</div>

</body>
</html>
