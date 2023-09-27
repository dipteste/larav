<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';
$db = 'produtos_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão com o banco de dados falhou: " . $conn->connect_error);
}

// Consulta SQL para recuperar os dados da tabela de produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

// Inicializa um array para armazenar os dados dos produtos
$produtos = array();

if ($result->num_rows > 0) {
    // Loop através dos resultados e adiciona cada produto ao array
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    echo "Nenhum produto encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();

// Retorna os dados como JSON
echo json_encode($produtos);
?>
