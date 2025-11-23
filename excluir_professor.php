<?php
session_start();
include_once("conexao.php");

// Somente master pode excluir
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'master') {
    echo "Acesso negado!";
    exit;
}

// Recebe id do professor
if (!isset($_GET['id_professor'])) {
    echo "ID do professor não informado.";
    exit;
}

$id_professor = intval($_GET['id_professor']);

// Exclui horários do professor
mysqli_query($conn, "DELETE FROM professor_horario WHERE id_professor = $id_professor");

// Exclui professor
$sql = "DELETE FROM professor WHERE id_professor = $id_professor";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Professor excluído com sucesso!');
            window.location.href='PainelAdmin.php';
          </script>";
} else {
    echo "Erro ao excluir: " . mysqli_error($conn);
}
?>