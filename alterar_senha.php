<?php
session_start();
include_once("conexao.php"); // Certifique-se de que 'conexao.php' está correto.

// Variáveis de feedback para o usuário
$mensagem = "";
$mensagem_status = ""; // Usado para estilização (ex: 'success' ou 'error')

// 1. Verifica se usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['matricula'])) {
    header("Location: Login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Coleta e sanitiza as entradas
    $senha_atual = $_POST['senha-atual'] ?? '';
    $nova_senha = $_POST['nova-senha'] ?? '';
    $confirmar_senha = $_POST['confirmar-senha'] ?? '';
    
    $usuarioId = $_SESSION['matricula'];

    // 3. Busca a senha hash atual do banco (USANDO PREPARED STATEMENTS)
    $sql = "SELECT senha_hash FROM aluno WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $mensagem = "Usuário não encontrado!";
        $mensagem_status = "error";
    } else {
        // 4. Validações de Segurança
        
        // Verifica se a senha atual está correta
        if (!password_verify($senha_atual, $user['senha_hash'])) {
            $mensagem = "Senha atual incorreta!";
            $mensagem_status = "error";
        }
        // Verifica se a nova senha e confirmação são iguais
        elseif ($nova_senha !== $confirmar_senha) {
            $mensagem = "A nova senha e a confirmação não coincidem!";
            $mensagem_status = "error";
        }
        // Sugestão 1: Valida o tamanho mínimo da nova senha
        elseif (strlen($nova_senha) < 8) {
             $mensagem = "A nova senha deve ter no mínimo 8 caracteres!";
             $mensagem_status = "error";
        }
        // Sugestão 2: Verifica se a nova senha é diferente da senha atual
        elseif (password_verify($nova_senha, $user['senha_hash'])) {
             $mensagem = "A nova senha não pode ser igual à senha atual!";
             $mensagem_status = "error";
        }
        else {
            // 5. Atualiza senha no banco (USANDO PREPARED STATEMENTS)
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sqlUpdate = "UPDATE aluno SET senha_hash = ? WHERE matricula = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("si", $nova_senha_hash, $usuarioId);

            if ($stmtUpdate->execute()) {
                $mensagem = "Senha alterada com sucesso!";
                $mensagem_status = "success";
            } else {
                $mensagem = "Erro ao atualizar a senha. Tente novamente.";
                $mensagem_status = "error";
            }
            $stmtUpdate->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Alterar Senha - GYM</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="alterar_senha.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* Estilos para as mensagens de feedback (Apenas para demonstração, idealmente estaria em 'alterar_senha.css') */
.mensagem-alerta {
    padding: 10px;
    margin: 10px 0;
    text-align: center;
    border-radius: 4px;
    font-weight: bold;
}
.mensagem-alerta.error {
    color: #a94442;
    background-color: #f2dede;
    border: 1px solid #ebccd1;
}
.mensagem-alerta.success {
    color: #3c763d;
    background-color: #dff0d8;
    border: 1px solid #d6e9c6;
}
</style>
</head>
<body>

<?php if(!empty($mensagem)): ?>
    <div class="mensagem-alerta <?= $mensagem_status ?>">
        <?= $mensagem ?>
    </div>
<?php endif; ?>

<header>
    <div class="logo"><span>GYM</span></div>
    <nav>
      <a href="TelaPrincipal.php">INÍCIO</a> 
      <a href="logout.php">LOGOUT</a>
    </nav>
</header>

<main>
<section class="senha-container">
    <h2><i class="bi bi-key-fill"></i> Alterar Senha</h2>
    <form action="" method="POST" class="senha-form">
        <label for="senha-atual">Senha Atual</label>
        <input type="password" id="senha-atual" name="senha-atual" placeholder="Digite sua senha atual" required>

        <label for="nova-senha">Nova Senha</label>
        <input type="password" id="nova-senha" name="nova-senha" placeholder="Digite sua nova senha (Mínimo 8 caracteres)" required minlength="8">

        <label for="confirmar-senha">Confirmar Nova Senha</label>
        <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirme sua nova senha" required>

        <button type="submit" class="btn-salvar">Salvar Alterações</button>
    </form>
</section>
</main>

<footer class="footer">
    <div class="footer-container">
        <h3 class="footer-logo">GYM</h3>
        <ul class="footer-links">
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Termos de Uso</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
        <div class="footer-social">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
        <p class="footer-copy">© 2025 GYM. Todos os direitos reservados.</p>
    </div>
</footer>
<script src="script.js"></script>
</body>
</html>