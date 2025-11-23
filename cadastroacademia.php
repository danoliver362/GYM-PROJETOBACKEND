<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once('conexao.php');

if (isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $nomematerno = $_POST['nomematerno'];
    $datanascimento = $_POST['datanascimento'];
    $sexo = $_POST['sexo'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'] . ", " . $_POST['Rua'] . ", " . $_POST['numero'] . ", " . $_POST['bairro'] . ", " . $_POST['Municipio'] . " - " . $_POST['UF'];
    $plano = $_POST['plano'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $confirmarsenha = $_POST['confirmarsenha'];

    
    if ($senha !== $confirmarsenha) {
        echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
        exit;
    }

    
    $checkLogin = mysqli_query($conn, "SELECT * FROM aluno WHERE login = '$login'");
    if (mysqli_num_rows($checkLogin) > 0) {
        echo "<script>alert('Este login já está em uso! Escolha outro.'); window.history.back();</script>";
        exit;
    }

    
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    
   $sql = "INSERT INTO aluno 
( nome, nomematerno, datanascimento, sexo, cpf, email, telefone, cep, endereco, plano, login, senha_hash )
VALUES 
('$nome', '$nomematerno', '$datanascimento', '$sexo', '$cpf', '$email', '$telefone', '$cep', '$endereco', '$plano', '$login', '$senha_hash')";


    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'Login.php';
              </script>";
        exit;

    } else {
        echo "Erro ao cadastrar: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GYM Cadastro</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="stylecadastro.css">
  

 
  <script>

   
    function mascaraCPF(campo) {
        let cpf = campo.value.replace(/\D/g, "");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        campo.value = cpf;
    }

    
    function mascaraTelefone(campo) {
        let tel = campo.value.replace(/\D/g, "");
        tel = tel.replace(/^(\d{2})(\d)/, "($1) $2");
        tel = tel.replace(/(\d{5})(\d)/, "$1-$2");
        campo.value = tel;
    }

    
    function mascaraCEP(campo) {
        let cep = campo.value.replace(/\D/g, "");
        if (cep.length > 5) {
            cep = cep.replace(/^(\d{5})(\d)/, "$1-$2");
        }
        campo.value = cep;
    }

    
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, "");

        if (cpf.length !== 11) return false;
        if (/^(\d)\1{10}$/.test(cpf)) return false;

        let soma = 0;
        for (let i = 0; i < 9; i++) soma += cpf[i] * (10 - i);
        let dig1 = 11 - (soma % 11);
        dig1 = dig1 > 9 ? 0 : dig1;
        if (dig1 != cpf[9]) return false;

        soma = 0;
        for (let i = 0; i < 10; i++) soma += cpf[i] * (11 - i);
        let dig2 = 11 - (soma % 11);
        dig2 = dig2 > 9 ? 0 : dig2;
        if (dig2 != cpf[10]) return false;

        return true;
    }

    function conferirCPF() {
        const campo = document.getElementById("cpf");
        let cpf = campo.value;

        if (!validarCPF(cpf)) {
            alert("CPF inválido! Verifique e tente novamente.");
            campo.value = "";
            campo.focus();
        }
    }

   
    function limparEndereco() {
        document.getElementById("UF").value = "";
        document.getElementById("Municipio").value = "";
        document.getElementById("Rua").value = "";
        document.getElementById("bairro").value = "";
        document.getElementById("numero").value = "";
    }

   
    async function buscarCEP() {
        const cepCampo = document.getElementById("cep");
        const cep = cepCampo.value.replace(/\D/g, "");

        if (cep.length !== 8) {
            alert("CEP inválido! Digite 8 números.");
            limparEndereco();
            return;
        }

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const dados = await response.json();

            if (dados.erro) {
                alert("CEP não encontrado! Preencha o endereço manualmente.");
                limparEndereco();
                return;
            }

            document.getElementById("UF").value = dados.uf;
            document.getElementById("Municipio").value = dados.localidade;
            document.getElementById("Rua").value = dados.logradouro;
            document.getElementById("bairro").value = dados.bairro;

        } catch {
            alert("Erro ao consultar CEP!");
            limparEndereco();
        }
    }

  </script>

</head>

<body>

<header>
    <div class="logo">
      <i class="bi bi-lightning-charge-fill"></i> GYM 
    </div>
    <nav>
      <a href="agendamento.php">Agendar aula</a>
      <a href="TelaPrincipal.php">Início</a>
      <a href="Login.php"><i class="bi bi-person-circle"></i>LOGIN</a>
      <a href="cadastramento.php" class="active">Cadastro</a>
      <a href="LoginAdm.html">Painel Administrador</a>
    </nav>
</header>

<main>
    <section class="container">
      <h1 id="titulo">Cadastro de Aluno</h1>

      <div class="conteúdo">
        <div class="img">
          <img src="https://cdn-icons-png.flaticon.com/512/2966/2966481.png" alt="Imagem de cadastro">
        </div>

        <form class="formulario" action="cadastroacademia.php" method="post">

          <fieldset>

            <div class="campo">
              <label for="nome">Nome completo</label>
              <input type="text" id="nome" name="nome" minlength="15" maxlength="80" required>
            </div>

            <div class="campo">
              <label for="nomematerno">Nome materno</label>
              <input type="text" id="nomematerno" name="nomematerno" required>
            </div>

            <div class="campo">
              <label for="datanascimento">Data de nascimento</label>
              <input type="date" id="datanascimento" name="datanascimento" required>
            </div>

            <div class="campo">
              <label for="cpf">CPF</label>
              <input type="text" id="cpf" name="cpf" maxlength="14" 
                     onblur="conferirCPF()" oninput="mascaraCPF(this)" required>
            </div>

            <div class="campo">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" required>
            </div>

            <div class="campo">
              <label for="telefone">Telefone</label>
              <input type="tel" id="telefone" name="telefone" maxlength="15"
                     oninput="mascaraTelefone(this)" required>
            </div>

            <div class="campo">
              <label for="sexo">Gênero</label>
              <select id="sexo" name="sexo" required>
                <option value="">Selecione...</option>
                <option value="feminino">Feminino</option>
                <option value="masculino">Masculino</option>
                <option value="outro">Outro</option>
                <option value="Prefiro não informar">Prefiro não informar</option>
              </select>
            </div>

            <div class="campo">
              <label for="cep">CEP</label>
              <input type="text" id="cep" name="cep" maxlength="9"
                     oninput="mascaraCEP(this)" onblur="buscarCEP()" required>
            </div>

            <div class="campo">
              <label for="endereco">Endereço</label>
              <input type="text" id="endereco" name="endereco">
            </div>

            <div class="campo">
              <label for="UF">UF</label>
              <input type="text" id="UF" name="UF">
            </div>

            <div class="campo">
              <label for="Municipio">Município</label>
              <input type="text" id="Municipio" name="Municipio">
            </div>

            <div class="campo">
              <label for="Rua">Rua</label>
              <input type="text" id="Rua" name="Rua">
            </div>

            <div class="campo">
              <label for="bairro">Bairro</label>
              <input type="text" id="bairro" name="bairro">
            </div>

            <div class="campo">
              <label for="numero">Número</label>
              <input type="text" id="numero" name="numero">
            </div>

            <div class="campo">
              <label for="plano">Plano</label>
              <select name="plano" required>
                <option value="">Selecione...</option>
                <option value="mensal">Mensal</option>
                <option value="trimestral">Trimestral</option>
                <option value="anual">Anual</option>
              </select>
            </div>

         <div class="campo">
   <label for="login">Login</label>
   <input type="text" name="login" id="login" maxlength="6" required>
</div>

<div class="campo">
   <label for="senha">Senha</label>
   <input type="password" name="senha" id="senha" maxlength="8" required>
</div>

<div class="campo">
   <label for="confirmarsenha">Confirmar senha</label>
   <input type="password" name="confirmarsenha" id="confirmarsenha" required>
</div>


          </fieldset>

          <div class="botoes">
            <input class="botao" type="submit" name="submit" id="submit" value="Cadastrar">
            <button type="reset" class="botao">Limpar</button>
          </div>

        </form>
      </div>
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


</body>
</html>
