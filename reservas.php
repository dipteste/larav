<?php
session_start();

// Configurações do banco de dados
$host = 'localhost';
$db = 'produtos_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Buscar reservas no banco de dados
$reservas = $pdo->query("SELECT * FROM produtos WHERE nome_cliente IS NOT NULL AND data_reserva IS NOT NULL")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
</head>
<body>

<h2>Lista de Reservas</h2>

<table border="1">
    <thead>
    <tr>
        <th>ID do Produto</th>
        <th>Nome do Cliente</th>
        <th>Data de Reserva</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reservas as $reserva) : ?>
        <tr>
            <td><?= $reserva['id'] ?></td>
            <td><?= $reserva['nome_cliente'] ?></td>
            <td><?= $reserva['data_reserva'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Lista de Reservas (Resumo)</h2>

<table border="1">
    <thead>
    <tr>
        <th>ID do Produto</th>
        <th>Nome do Cliente</th>
        <th>Data de Reserva</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reservas as $reserva) : ?>
        <tr>
            <td><?= $reserva['id'] ?></td>
            <td><?= $reserva['nome_cliente'] ?></td>
            <td><?= $reserva['data_reserva'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
