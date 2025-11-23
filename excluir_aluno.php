<?php
include('conexao.php');

// Verifica se a matrícula foi informada
if (!isset($_GET['matricula'])) {
    die("Matrícula não informada.");
}

$matricula = $conn->real_escape_string($_GET['matricula']);

// Primeiro apaga os registros relacionados
$conn->query("DELETE FROM agendamento WHERE matricula = '$matricula'");

// Agora apaga o aluno
$sql = "DELETE FROM aluno WHERE matricula = '$matricula'";

if ($conn->query($sql)) {
    echo "<script>alert('Aluno excluído com sucesso!'); window.location.href='PainelAdmin.php';</script>";
} else {
    echo "Erro ao excluir: " . $conn->error;
}
?>
