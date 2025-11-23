<?php
include_once("conexao.php"); // Sua conexão com o banco
// Para enviar e-mails de forma confiável, é altamente recomendado usar uma biblioteca como PHPMailer.
// Por simplicidade, este exemplo apenas simula o envio de email.

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificador = $_POST['identificador'] ?? ''; // Pode ser matrícula ou email

    if (empty($identificador)) {
        $mensagem = "Por favor, digite sua matrícula ou e-mail.";
    } else {
        // 1. Busca o usuário no banco
        // Vou assumir que o identificador é o email neste exemplo, mas você pode ajustar
        $sql = "SELECT matricula, email FROM aluno WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $identificador);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            // 2. Gera Token Único e Tempo de Expiração
            // Um token de 32 bytes (64 caracteres hexadecimais) é seguro
            $token = bin2hex(random_bytes(32)); 
            
            // Token válido por 30 minutos a partir de agora
            $expiracao = date("Y-m-d H:i:s", time() + (30 * 60)); 
            
            $userId = $user['matricula'];
            $userEmail = $user['email'];

            // 3. Salva o Token no Banco de Dados (USANDO PREPARED STATEMENT)
            $sqlUpdate = "UPDATE aluno SET reset_token = ?, token_expiration = ? WHERE matricula = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ssi", $token, $expiracao, $userId);
            
            if ($stmtUpdate->execute()) {
                // 4. Cria o Link de Redefinição
                // Mude o 'http://localhost/seuprojeto' para a URL real do seu projeto
                $link_redefinicao = "http://localhost/projeto/recuperar_senha.php?token=" . $token;

                // 5. Simula Envio de E-mail (AQUI VOCÊ USARIA PHPMailer)
                /* $assunto = "Recuperação de Senha - GYM";
                $corpo_email = "Clique no link para redefinir sua senha (válido por 30 minutos): " . $link_redefinicao;
                mail($userEmail, $assunto, $corpo_email, "From: suporte@gym.com"); 
                */

                $mensagem = "Um link para redefinição de senha foi enviado para seu e-mail. <br>**Link Teste**";
                // Para testes, mostre o link


            } else {
                $mensagem = "Erro interno ao gerar o link de recuperação. Tente novamente.";
            }
            $stmtUpdate->close();

        } else {
            // É uma boa prática de segurança não dizer se o e-mail existe ou não.
            $mensagem = "Se o e-mail estiver cadastrado, um link será enviado em breve.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - GYM</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleesqueci.css">
    
</head>
<body>

    <header class="header">
    <div class="logo"><span>GYM</span></div>
    <nav class="header-nav">
        <a href="TelaPrincipal.php">INÍCIO</a> 
        <a href="logout.php">LOGOUT</a>
    </nav>
</header>

<main class="content-wrapper">
    <div class="card">
        <div class="card-icon">🔑</div>
        <h2 class="card-title">Recuperar Senha</h2>

        <?php if(!empty($mensagem)): ?>
            <div class="message-box success">
                <p class="message-text"><?= $mensagem ?></p>
                
                <?php if(!empty($link_redefinicao)): ?>
                    <a href="<?= $link_redefinicao ?>"  class="reset-link-display"><?= $link_redefinicao ?></a>
                <?php endif; ?>
                
            </div>
        <?php endif; ?>
        
        <form class="form" action="" method="POST">
            <div class="input-group">
                <label for="identificador">Digite seu E-mail:</label>
                <input type="email" id="identificador" name="identificador" required placeholder="Digite seu E-mail">
            </div>
            
            <button class="submit-button" type="submit">Enviar Link de Redefinição</button>
        </form> 
        
        <a class="back-link" href="Login.php">Voltar para o Login</a>
    </div>
</main>

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