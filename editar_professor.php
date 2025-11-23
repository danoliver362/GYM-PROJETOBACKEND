<?php
include('conexao.php');

// Verifica se o ID foi informado
if (!isset($_GET['id_professor'])) {
    die("ID do professor não informado.");
}

$id_professor = $_GET['id_professor'];

// Busca dados do professor
$sql = "SELECT * FROM professor WHERE id_professor = '$id_professor'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Professor não encontrado.");
}

$professor = $result->fetch_assoc();

// Buscar horários cadastrados para o professor
$sqlHorarios = "
    SELECT * FROM professor_horario 
    WHERE id_professor = '$id_professor'
    ORDER BY FIELD(dia_semana, 'Seg','Ter','Qua','Qui','Sex','Sab','Dom'), hora_inicio
";

$resultHorarios = $conn->query($sqlHorarios);

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_professor = $_POST['id_professor'];
    $nome = $_POST['nome'];
    $modalidade = $_POST['modalidade'];

    // Atualizar dados do professor
    $sqlUpdate = "
        UPDATE professor 
        SET nome='$nome', modalidade='$modalidade'
        WHERE id_professor='$id_professor'
    ";
    $conn->query($sqlUpdate);

    // --- Atualizar horários ---

    // 1. Remover horários antigos selecionados
    if (!empty($_POST['remover'])) {
        foreach ($_POST['remover'] as $idHorarioRemove) {
            $conn->query("DELETE FROM professor_horario WHERE id_horario = '$idHorarioRemove'");
        }
    }

    // 2. Atualizar horários existentes
    if (!empty($_POST['id_horario'])) {
        foreach ($_POST['id_horario'] as $i => $idHorario) {

            $dia = $_POST['dia_semana'][$i];
            $hora_inicio = $_POST['hora_inicio'][$i];
            $hora_fim = $_POST['hora_fim'][$i];

            $conn->query("
                UPDATE professor_horario
                SET dia_semana = '$dia', hora_inicio = '$hora_inicio', hora_fim = '$hora_fim'
                WHERE id_horario = '$idHorario'
            ");
        }
    }

    // 3. Inserir novos horários
    if (!empty($_POST['novo_dia_semana'])) {
        foreach ($_POST['novo_dia_semana'] as $i => $dia) {

            if ($dia == "") continue; // ignora linha vazia

            $h_inicio = $_POST['novo_hora_inicio'][$i];
            $h_fim = $_POST['novo_hora_fim'][$i];

            $conn->query("
                INSERT INTO professor_horario (id_professor, dia_semana, hora_inicio, hora_fim)
                VALUES ('$id_professor', '$dia', '$h_inicio', '$h_fim')
            ");
        }
    }

    echo "<script>alert('Professor e horários atualizados com sucesso!'); window.location.href='PainelAdmin.php#professor';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Professor</title>
    <link rel="stylesheet" href="styleAdmin.css">
    <link rel="stylesheet" href="styleeditarpro.css">

    <style>
        .horario-box {
            background: #333;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .horario-box label {
            display: block;
            font-size: 14px;
            margin-top: 6px;
        }
        .flex {
            display: flex;
            gap: 12px;
        }
        .add-btn {
            margin-top: 10px;
            padding: 8px;
            background: #28a745;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
        }
        .remove-btn {
            color: red;
            font-size: 14px;
            cursor: pointer;
        }
    </style>

</head>
<body>

<header class="menu">
    <h2>GYM SYSTEM - ADMIN</h2>
    <nav>
        <a href="PainelAdmin.php#professor">Voltar</a>
    </nav>
</header>

<main class="container">
    <h1>Editar Professor</h1>

    <form method="POST" class="formulario">

        <input type="hidden" name="id_professor" value="<?= $professor['id_professor'] ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?= $professor['nome'] ?>" required>

        <label>Modalidade:</label>
        <input type="text" name="modalidade" value="<?= $professor['modalidade'] ?>" required>

        <h2>Horários do Professor</h2>

        <?php while ($h = $resultHorarios->fetch_assoc()): ?>
            <div class="horario-box">

                <input type="hidden" name="id_horario[]" value="<?= $h['id_horario'] ?>">

                <label>Dia da semana:</label>
                <select name="dia_semana[]">
                    <?php
                    $dias = ['Seg','Ter','Qua','Qui','Sex','Sab','Dom'];
                    foreach ($dias as $dia) {
                        $sel = ($dia == $h['dia_semana']) ? "selected" : "";
                        echo "<option value='$dia' $sel>$dia</option>";
                    }
                    ?>
                </select>

                <label>Hora início:</label>
                <input type="time" name="hora_inicio[]" value="<?= $h['hora_inicio'] ?>">

                <label>Hora fim:</label>
                <input type="time" name="hora_fim[]" value="<?= $h['hora_fim'] ?>">

                <label class="remove-btn">
                    <input type="checkbox" name="remover[]" value="<?= $h['id_horario'] ?>"> Remover horário
                </label>

            </div>
        <?php endwhile; ?>

        <h3>📌 Adicionar novos horários</h3>

        <div id="novos-horarios"></div>

        <button type="button" class="add-btn" onclick="addHorario()">+ Adicionar horário</button>

        <div class="botoes">
            <button type="submit" class="salvar">Salvar alterações</button>
            <a href="PainelAdmin.php#professor" class="cancelar">Cancelar</a>
        </div>

    </form>
</main>

<script>
function addHorario() {
    let div = document.createElement("div");
    div.classList.add("horario-box");
    div.innerHTML = `
        <label>Dia da semana:</label>
        <select name="novo_dia_semana[]">
            <option value="">Selecione</option>
            <option value="Seg">Seg</option>
            <option value="Ter">Ter</option>
            <option value="Qua">Qua</option>
            <option value="Qui">Qui</option>
            <option value="Sex">Sex</option>
            <option value="Sab">Sab</option>
            <option value="Dom">Dom</option>
        </select>

        <label>Hora início:</label>
        <input type="time" name="novo_hora_inicio[]">

        <label>Hora fim:</label>
        <input type="time" name="novo_hora_fim[]">
    `;
    document.getElementById("novos-horarios").appendChild(div);
}
</script>

</body>
</html>