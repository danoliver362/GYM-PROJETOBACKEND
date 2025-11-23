<?php
session_start();

// Se estiver logado, pega o nome
$nome_logado = $_SESSION['nome'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GYM</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Barra de Acessibilidade -->
<div class="acessibilidade-bar" role="region" aria-label="Barra de acessibilidade">
  <button id="btn-contraste" aria-label="Ativar ou desativar alto contraste">
    <i class="fa-solid fa-adjust"></i> Contraste
  </button>

  <button id="btn-aumentar-fonte" aria-label="Aumentar tamanho da fonte">
    <i class="fa-solid fa-plus"></i> A+
  </button>

  <button id="btn-diminuir-fonte" aria-label="Diminuir tamanho da fonte">
    <i class="fa-solid fa-minus"></i> A-
  </button>
</div>

<header>
  <div class="logo"><span>GYM</span></div>

  <!-- NAVBAR DINÂMICA -->
  <nav>
    <a href="TelaPrincipal.php" class="active">INÍCIO</a>

    <?php if (!isset($_SESSION['logado'])): ?>
      <a href="Login.php"><i class="bi bi-person-circle"></i> LOGIN</a>
      <a href="cadastroacademia.php"><i class="bi bi-person-plus"></i> CADASTRE-SE</a>
    <?php else: ?>
      <span class="user-name">
        <i class="bi bi-person-circle"></i> Olá, <?= htmlspecialchars($nome_logado) ?>!
      </span>
      <a href="logout.php"><i class="bi bi-box-arrow-right"></i> SAIR</a>
    <?php endif; ?>
  </nav>

  <!-- BLOCO DE USUÁRIO -->
  <?php if (isset($_SESSION['logado'])): ?>
    <div id="userInfo" class="user-info">
      <i class="bi bi-person-circle"></i>
      <span id="userName"><?= $nome_logado ?></span>
    </div>
  <?php endif; ?>

</header>

<!-- Banner -->
<section class="banner">
  <div class="banner-box">
    <img src="WhatsApp Image 2025-10-25 at 21.29.04.jpeg" alt="banner">
  </div>
</section>

<!-- Planos -->
<section class="planos">
  <h1>NOSSOS PLANOS</h1><br>
  <div class="planos-container">
    <div class="plano">
      <h3>Plano Mensal</h3>
      <p>Acesso total à academia e aulas coletivas.</p>
      <span>R$ 99,90 / mês</span>
    </div>
    <div class="plano">
      <h3>Plano Trimestral</h3>
      <p>Treino personalizado e acompanhamento.</p>
      <span>R$ 249,90 / trimestre</span>
    </div>
    <div class="plano">
      <h3>Plano Anual</h3>
      <p>Descontos exclusivos e consultoria completa.</p>
      <span>R$ 799,90 / ano</span>
    </div>
  </div>
</section>

<!-- Serviços -->
<section class="servicos">
  <h1>NOSSOS SERVIÇOS</h1><br>
  <div class="servicos-container">
    <div class="servico">
      <img src="aula-de-danca-3-1.jpg" alt="Dança">
      <p>Dança</p>
    </div>
    <div class="servico">
      <img src="Cia-Athletica-Nacional-Academia-com-natacao-10-motivos-para-combinar-os-treinos-Autores-Grupo-S2-Marketing-Divulgacao.webp" alt="Natação">
      <p>Natação</p>
    </div>
    <div class="servico">
      <img src="istockphoto-2075354173-612x612.jpg" alt="Musculação">
      <p>Musculação</p>
    </div>
  </div>
</section>

<!-- Rodapé -->
<footer class="footer">
  <a href="LoginAdm.html">Painel Administrador</a>

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