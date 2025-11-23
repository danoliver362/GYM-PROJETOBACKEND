<?php
include('conexao.php');

if (!isset($_GET['id_horario'])) die("ID não informado.");
$id = (int)$_GET['id_horario'];

// Buscar registro
$sql = "SELECT * FROM professor_horario WHERE id_horario = $id LIMIT 1";
$res = $conn->query($sql);
if ($res->num_rows == 0) die("Horário não encontrado.");
$h = $res->fetch_assoc();

// Buscar professores
$sqlp = "SELECT id_professor, nome FROM professor ORDER BY nome";
$profRes = $conn->query($sqlp);

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_professor = $conn->real_escape_string($_POST['id_professor']);
    $dia_semana   = $conn->real_escape_string($_POST['dia_semana']);
    $hora_inicio  = $conn->real_escape_string($_POST['hora_inicio']);
    $hora_fim     = $conn->real_escape_string($_POST['hora_fim']);

    if ($id_professor === '' || $dia_semana === '' || $hora_inicio === '' || $hora_fim === '') {
        $erro = "Preencha todos os campos.";

    } elseif ($hora_inicio >= $hora_fim) {

        $erro = "Hora de início deve ser menor que hora fim.";

    } else {

        // Checar conflito
        $chk = "
            SELECT 1 FROM professor_horario
            WHERE id_professor = '$id_professor'
              AND dia_semana   = '$dia_semana'
              AND id_horario  != $id
              AND NOT (hora_fim <= '$hora_inicio' OR hora_inicio >= '$hora_fim')
        ";

        $rchk = $conn->query($chk);

        if ($rchk->num_rows > 0) {
            $erro = "Este horário conflita com outro horário do professor neste dia.";
        } else {

            $sqlu = "
                UPDATE professor_horario
                SET 
                    id_professor = '$id_professor',
                    dia_semana   = '$dia_semana',
                    hora_inicio  = '$hora_inicio',
                    hora_fim     = '$hora_fim'
                WHERE id_horario = $id
            ";

            if ($conn->query($sqlu)) {
                header('Location: listar_horarios.php');
                exit;
            } else {
                $erro = "Erro ao salvar: " . $conn->error;
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Editar Horário</title>
</head>
<body>
    <h1>Editar Horário</h1>

    <?php if ($erro): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="post">

        <label>Professor:
            <select name="id_professor" required>
                <?php while($p = $profRes->fetch_assoc()): ?>
                    <option 
                        value="<?= $p['id_professor'] ?>"
                        <?= $p['id_professor'] == $h['id_professor'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($p['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Dia da semana:
            <select name="dia_semana" required>
                <?php 
                $dias = ['Seg','Ter','Qua','Qui','Sex','Sab','Dom'];
                foreach($dias as $d):
                ?>
                    <option value="<?= $d ?>" <?= $d == $h['dia_semana'] ? 'selected' : '' ?>>
                        <?= $d ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Hora início:
            <input type="time" name="hora_inicio" value="<?= $h['hora_inicio'] ?>" required>
        </label><br><br>

        <label>Hora fim:
            <input type="time" name="hora_fim" value="<?= $h['hora_fim'] ?>" required>
        </label><br><br>

        <button type="submit">Salvar</button>
        <a href="listar_horarios.php">Cancelar</a>
    </form>

</body>
</html>