<?php
include('conexao.php');
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['data']) || !isset($_GET['hora'])) {
    echo json_encode(['success' => false, 'error' => 'Parâmetros data e hora são obrigatórios', 'data' => []]);
    exit;
}

$data = $_GET['data']; // YYYY-MM-DD
$hora = $_GET['hora']; // HH:MM ou HH:MM:SS

// validações básicas
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
    echo json_encode(['success' => false, 'error' => 'Formato de data inválido', 'data' => []]);
    exit;
}
if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $hora)) {
    echo json_encode(['success' => false, 'error' => 'Formato de hora inválido', 'data' => []]);
    exit;
}

// dia da semana (Dom,Seg,...)
$dias = ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'];
$w = date('w', strtotime($data)); // 0..6
$dia_semana = $dias[$w];

$lista = [];

$sql = "
SELECT DISTINCT p.id_professor, p.nome, p.modalidade
FROM professor p
INNER JOIN professor_horario h ON p.id_professor = h.id_professor
WHERE h.dia_semana = ?
  AND TIME(h.hora_inicio) <= TIME(?)
  AND TIME(h.hora_fim) > TIME(?)
  AND p.id_professor NOT IN (
      SELECT id_professor FROM agendamento WHERE data_aula = ? AND TIME(hora_aula) = TIME(?)
  )
ORDER BY p.nome
";


if ($stmt = $conn->prepare($sql)) {
    // parâmetros: dia_semana, hora, hora, data, hora
    $stmt->bind_param('sssss', $dia_semana, $hora, $hora, $data, $hora);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Erro na execução da consulta: '.$stmt->error, 'data' => []]);
        exit;
    }
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $lista[] = $row;
    }
    $stmt->close();
    echo json_encode(['success' => true, 'data' => $lista]);
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'Erro ao preparar consulta: '.$conn->error, 'data' => []]);
    exit;
}