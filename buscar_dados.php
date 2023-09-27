<?php
// Configurações de conexão com o banco de dados
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

$sql = "SELECT
    'Produto' AS Origem,
    id,
    nome,
    modelo,
    tipo,
    gbs,
    foto,
    valor,
    data_modificacao,
    reservado,
    NULL AS nome_cliente,
    NULL AS data_reserva
FROM
    produtos
UNION ALL
SELECT
    'Reserva' AS Origem,
    id,
    NULL AS nome,
    NULL AS modelo,
    NULL AS tipo,
    NULL AS gbs,
    NULL AS foto,
    NULL AS valor,
    NULL AS data_modificacao,
    NULL AS reservado,
    nome_cliente,
    data_reserva
FROM
    reservas
ORDER BY
    Origem, id";
	
// Consulta SQL para selecionar todos os produtos
$consulta = $pdo->query("SELECT * FROM produtos");
$dados = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($dados);
?>
