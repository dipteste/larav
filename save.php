<?php
$host = 'localhost';
$dbname = 'my_database';
$user = 'username';
$password = 'password';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $model = $_POST["model"];
        $type = $_POST["type"];
        $gbs = $_POST["gbs"];
        $value = $_POST["value"];

        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photo);

        $stmt = $conn->prepare("INSERT INTO products (name, model, type, gbs, photo, value) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $model, $type, $gbs, $photo, $value]);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro Efetuado</title>
</head>
<body>
    <p>Produto registrado com sucesso!</p>
</body>
</html>
