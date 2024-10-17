<?php
include('../includes/connection.php');
include('../includes/protect.php');

// Inicialize um array para armazenar os resultados
$data = array();

// Obtenha a contagem de questões
$sql = "SELECT COUNT(*) as total FROM questions WHERE status = 1";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalQuestions'] = $row['total'];
} else {
    $data['totalQuestions'] = 'ERRO';
}

// Obtenha a contagem de questões desativas
$sql = "SELECT COUNT(*) as total FROM questions WHERE status = 0";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalDesaQuestions'] = $row['total'];
} else {
    $data['totalDesaQuestions'] = 'ERRO';
}


// Obtenha a contagem de usuários
$sql = "SELECT COUNT(*) as total FROM users";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalUsers'] = $row['total'];
} else {
    $data['totalUsers'] = 'ERRO';
}

// Obtenha a contagem de usuários ativos
$sql = "SELECT COUNT(*) as total FROM users WHERE status = 1;";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalUsersAct'] = $row['total'];
} else {
    $data['totalUsersAct'] = 'ERRO';
}

// Obtenha a contagem de usuários desativos
$sql = "SELECT COUNT(*) as total FROM users WHERE status = 0;";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalUsersDesac'] = $row['total'];
} else {
    $data['totalUsersDesac'] = 'ERRO';
}

// Obtenha a contagem de adm ativos
$sql = "SELECT COUNT(*) as total FROM adms WHERE status = 1;";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalAdmAct'] = $row['total'];
} else {
    $data['totalAdmAct'] = 'ERRO';
}

// Obtenha a contagem de adm desativos
$sql = "SELECT COUNT(*) as total FROM adms WHERE status = 0;";
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $data['totalAdmDes'] = $row['total'];
} else {
    $data['totalAdmDes'] = 'ERRO';
}

// Codifique o array como JSON e envie a resposta
echo json_encode($data);
?>