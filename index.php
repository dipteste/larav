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

$sql = "SELECT id, nome, modelo, tipo, gbs, bateria, valor, data_modificacao, reservado, nome_cliente, data_reserva, cod_reserva, reserva_status FROM produtos";

// Consulta SQL para obter a lista combinada de produtos e reservas


// Executar a consulta SQL
$statement = $pdo->query($sql);

 
// Verificar se o formulário de registro de produto foi enviado
if (isset($_POST['registrar_produto'])) {
    $nome = $_POST['nome'];
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $gbs = $_POST['gbs'];
    $bateria = $_POST['bateria'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO produtos (nome, modelo, tipo, gbs, bateria, valor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome, $modelo, $tipo, $gbs, $bateria, $valor])) {
        $_SESSION['mensagemReserva'] = 'Produto registrado com sucesso!';
    } else {
        $_SESSION['mensagemReserva'] = 'Erro ao registrar o produto.';
    }

    // Redirecionar após o registro
    header('Location: index.php');
    exit;
}

// Verificar se o formulário de reserva de produto foi enviado
if (isset($_POST['reservar'])) {
    $produto_id = $_POST['produto_id'];
    $nome_cliente = $_POST['nome_cliente'];
    $data_reserva = $_POST['data_reserva'];

    $sql = "UPDATE produtos SET reservado = 1, nome_cliente = ?, data_reserva = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome_cliente, $data_reserva, $produto_id])) {
        // Reserva confirmada com sucesso
        $_SESSION['mensagemReserva'] = 'Reserva confirmada!';
    } else {
        // Erro ao confirmar a reserva
        $_SESSION['mensagemReserva'] = 'Erro ao confirmar a reserva.';
    }

    // Redirecionar após a reserva
    header('Location: index.php');
    exit;

    if ($stmt->execute([$nome_cliente, $data_reserva, $produto_id])) {
    echo "Reserva inserida com sucesso!";
} else {
    echo "Erro ao inserir a reserva: " . $stmt->errorInfo();
}
}

    if (!empty($produto['nome_cliente']) && !empty($produto['data_reserva'])) {
        echo 'Sim';
    } else {
        echo 'Não';
    }
    ?>
<td>



    <?php


// Verificar se o ID para apagar um produto foi passado na URL
if (isset($_GET['apagar'])) {
    $id = $_GET['apagar'];

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id])) {
        $_SESSION['mensagemReserva'] = 'Produto apagado com sucesso!';
    } else {
        $_SESSION['mensagemReserva'] = 'Erro ao apagar o produto.';
    }

    // Redirecionar de volta à página principal após a exclusão
    header('Location: index.php');
    exit;
}

// Buscar produtos no banco de dados
$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll();

// Buscar reservas no banco de dados
$reservas = $pdo->query("SELECT * FROM reservas")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Produtos</title>

    <style>

  /* Estilizando o botão */
    #abrirModalBtn {
      background-color: #25d366; /* Cor de fundo semelhante ao WhatsApp */
      color: #fff; /* Cor do texto em branco */
      padding: 10px 20px; /* Espaçamento interno do botão */
      border: none; /* Removendo a borda do botão */
      border-radius: 5px; /* Arredondando as bordas */
      font-size: 16px; /* Tamanho da fonte */
      cursor: pointer; /* Alterando o cursor ao passar o mouse sobre o botão */
    }

    /* Estilizando o botão quando o mouse está em cima */
    #abrirModalBtn:hover {
      background-color: #128C7E; /* Alterando a cor de fundo quando o mouse está em cima */
    }

Para criar um pop-up dinâmico que escureça o fundo e exiba os dados em formato de texto, você pode usar JavaScript e CSS para criar um modal. Vou fornecer um exemplo básico de como fazer isso:

Primeiro, adicione o HTML para o modal em seu código:

html
Copy code
<!-- Botão para abrir o modal -->
<button id="abrirModal" onclick="abrirModal()">Abrir Balão</button>

    <!-- O modal -->
    <div id="balao-relatorio" style="display: none;"></div>

// Simulando os dados da tabela de produtos
var produtos = [
    { id: 1, nome: "Produto 1", modelo: "Modelo A", tipo: "Tipo X", gbs: 32, bateria: "produto1.jpg", valor: 100.00 },
    { id: 2, nome: "Produto 2", modelo: "Modelo B", tipo: "Tipo Y", gbs: 64, bateria: "produto2.jpg", valor: 150.00 },
    // Adicione mais produtos aqui
];


<button onclick="abrirModal()">Gerar Relatório para WhatsApp</button>

<!-- O modal -->
 

css
Copy code
/* Estilo do modal */
.modal {
  display: none; /* Oculta o modal por padrão */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7); /* Fundo escuro com transparência */
  z-index: 1;
  overflow: auto;
}

/* Conteúdo do modal */
.modal-content {
  background-color: #fff;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  text-align: center;
}

/* Botão de fechar */
.fechar {
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 24px;
  cursor: pointer;
}


        /* Estilo para o balão de relatório */
.relatorio-balao {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    padding: 20px;
    z-index: 1000;
    overflow: auto;
    max-height: 80vh;
}

/* Estilo para a tabela dentro do balão */
.relatorio-balao table {
    width: 100%;
    border-collapse: collapse;
}

.relatorio-balao th,
.relatorio-balao td {
    border: 1px solid #cccccc;
    padding: 8px;
    text-align: left;
}

.relatorio-balao th {
    background-color: #f2f2f2;
}

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.96), rgba(0, 0, 0, 0.96)),
                url('https://i.ibb.co/1KvJpb4/iphone-13-hd-wallpaper-1920x1080-uhdpaper-com-951-1-b.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #e1e1e1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #333;
            border-radius: 15px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }

        input[type="text"] {
            background-color: #555;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #0078D4;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #005fa3;
        }

        table {
            width: 90%;
            margin: 50px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #444;
        }

        th,
        td {
            padding: 10px 15px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: #ddd;
        }

        tr:hover {
            background-color: #555;
        }

        .btn-apagar {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 25px;
            background: linear-gradient(45deg, #FF5733, #FF8D33);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .btn-apagar:hover {
            background: linear-gradient(45deg, #FF8D33, #FF5733);
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-apagar:before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.15);
            transform: skewX(-45deg);
            transition: transform 0.6s;
        }

        .btn-apagar:hover:before {
            transform: translateX(200%) skewX(-45deg);
        }

        .btn-reservar {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 25px;
            background: linear-gradient(45deg, #0078D4, #33A1FF);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .btn-reservar:hover {
            background: linear-gradient(45deg, #33A1FF, #0078D4);
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-reservar:before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.15);
            transform: skewX(-45deg);
            transition: transform 0.6s;
        }

        .btn-reservar:hover:before {
            transform: translateX(200%) skewX(-45deg);
        }

        /* Estilo para o balão de confirmação */
        .confirmation-balloon {
            display: <?php echo $registroBemSucedido ? 'block' : 'none'; ?>;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #4CAF50;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            z-index: 9999;
            animation: pop-up 0.5s;
        }

        @keyframes pop-up {
            0% {
                transform: translate(-50%, -50%) scale(0);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        /* Estilo para o botão de fechar o balão */
        .close-button {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .close-button:hover {
            color: #333;
        }

        .reservation-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #0078D4;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            z-index: 9999;
            animation: pop-up 0.5s;
        }

        /* Estilo para o botão de fechar o balão de reserva */
        .close-button-popup {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 16px;
            cursor: pointer;
            color: #fff;
        }

        .close-button-popup:hover {
            color: #ccc;
        }
    </style>
</head>
<body>

    <center> <center><button id="abrirModalBtn">Gerar relatório WHATSAPP</button></center></center>

    <script>
        // Função para abrir a janela modal
        function abrirModal() {
            // Abre a página modal.php em uma nova janela ou guia
            window.open('modal.php', '_blank', 'width=400,height=400');
        }

        // Adicione um evento de clique ao botão para chamar a função abrirModal
        document.getElementById('abrirModalBtn').addEventListener('click', abrirModal);
    </script>
<h2>Estoque</h2>

 

<form method="post">
    Nome: <input type="text" name="nome"><br>
    Modelo: <input type="text" name="modelo"><br>
    Cor: <input type="text" name="tipo"><br>
    Gbs: <input type="text" name="gbs"><br>
    Bateria 🔋: <input type="text" name="bateria"><br>
    Valor: <input type="text" name="valor"><br>
    <input type="submit" name="registrar_produto" value="Registrar Iphone 📲">
</form>



<h2>Iphones Reservados</h2>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Modelo</th>
        <th>Tipo</th>
        <th>Gbs</th>
        <th>Bateria 🔋</th>
        <th>Valor</th>
        <th>Data de Modificação</th>
        <th>Reservado</th>
        <th>Nome do Cliente</th>
        <th>Data de Reserva</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $produto) : ?>
        <?php if ($produto['reservado'] == 1) : ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['modelo'] ?></td>
                <td><?= $produto['tipo'] ?></td>
                <td><?= $produto['gbs'] ?></td>
                <td><?= $produto['bateria'] ?></td>
                <td><?= $produto['valor'] ?></td>
                <td><?= isset($produto['data_modificacao']) ? $produto['data_modificacao'] : 'N/A' ?></td>
                <td><?= isset($produto['reservado']) && $produto['reservado'] == 1 ? 'Sim' : 'Não' ?></td>
                <td><?= isset($produto['nome_cliente']) ? $produto['nome_cliente'] : 'N/A' ?></td>
                <td><?= isset($produto['data_reserva']) ? $produto['data_reserva'] : 'N/A' ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Iphones Registrados</h2>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Modelo</th>
        <th>Cor</th>
        <th>Gbs</th>
        <th>bateria 🔋</th>
        <th>Valor</th>
        <th>Data de Modificação</th>
        <th>Ação</th>

        
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $produto) : ?>
        <tr>
            <td><?= $produto['id'] ?></td>
            <td><?= $produto['nome'] ?></td>
            <td><?= $produto['modelo'] ?></td>
            <td><?= $produto['tipo'] ?></td>
            <td><?= $produto['gbs'] ?></td>
            <td><?= $produto['bateria'] ?></td>
            <td><?= $produto['valor'] ?></td>
            <td><?= isset($produto['data_modificacao']) ? $produto['data_modificacao'] : 'N/A' ?>
            
            </td>
            <td>
                <a class="btn-apagar" href="index.php?apagar=<?= $produto['id'] ?>">Apagar</a>
                <?php if ($produto['reservado'] == 0) : ?>
                    <a class="btn-reservar" href="javascript:void(0);" onclick="showReservationPopup(<?= $produto['id'] ?>)">Reservar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>


</table>

<div class="confirmation-balloon" id="confirmation-balloon">
    <?= isset($_SESSION['mensagemReserva']) ? $_SESSION['mensagemReserva'] : '' ?>
    <span class="close-button" onclick="closeConfirmationBalloon()">&#10006;</span>
</div>
<div class="last-modification">
    Última modificação: <?= isset($lastModification) ? $lastModification : 'N/A' ?>
</div>

 
<div class="reservation-popup" id="reservation-popup">
    <span class="close-button-popup" onclick="closeReservationPopup()">&#10006;</span>
    <h2>Reservar Produto</h2>
    <form method="post">
        Nome do Cliente: <input type="text" name="nome_cliente"><br>
        Data de Reserva: <input type="date" name="data_reserva"><br>
        <input type="hidden" name="produto_id" id="produto_id">
        <input type="submit" name="reservar" value="Reservar">
        <a href="reservas.php">Ver Reservas</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    document.getElementById('gerar-relatorio').addEventListener('click', function() {
    var balaoRelatorio = document.getElementById('balao-relatorio');
    balaoRelatorio.style.display = 'block';

    // Resto do seu código AJAX e manipulação do modal aqui
});

    document.getElementById('gerar-relatorio').addEventListener('click', function() {
    var balaoRelatorio = document.getElementById('balao-relatorio');
    balaoRelatorio.style.display = 'block';

    // Resto do seu código AJAX e manipulação do modal aqui
});

    function closeConfirmationBalloon() {
        var balloon = document.getElementById('confirmation-balloon');
        balloon.style.display = 'none';
    }

    function showReservationPopup(id) {
        var popup = document.getElementById('reservation-popup');
        popup.style.display = 'block';
        document.getElementById('produto_id').value = id;
    }

    function closeReservationPopup() {
        var popup = document.getElementById('reservation-popup');
        popup.style.display = 'none';
    }
</script> 
 
<script>    
        document.getElementById('gerar-relatorio').addEventListener('click', function() {
            // Crie um balão/modal para exibir o conteúdo da API
            var balaoRelatorio = document.getElementById('balao-relatorio');
            balaoRelatorio.style.display = 'block';

            // Fazer uma solicitação AJAX para a API
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'gerar_relatorio.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Parse da resposta JSON
                        var dados = JSON.parse(xhr.responseText);

                        // Construa a tabela com base nos dados obtidos
                        var tabela = "<table border='1'><thead><tr><th>ID</th><th>Nome</th><th>Modelo</th><th>Tipo</th><th>GBs</th><th>bateria</th><th>Valor</th><th>Data de Modificação</th><th>Reservado</th></tr></thead><tbody>";

                        for (var i = 0; i < dados.length; i++) {
                            tabela += "<tr>";
                            tabela += "<td>" + dados[i].id + "</td>";
                            tabela += "<td>" + dados[i].nome + "</td>";
                            tabela += "<td>" + dados[i].modelo + "</td>";
                            tabela += "<td>" + dados[i].tipo + "</td>";
                            tabela += "<td>" + dados[i].gbs + "</td>";
                            tabela += "<td>" + dados[i].bateria + "</td>";
                            tabela += "<td>" + dados[i].valor + "</td>";
                            tabela += "<td>" + dados[i].data_modificacao + "</td>";
                            tabela += "<td>" + (dados[i].reservado == 1 ? 'Sim' : 'Não') + "</td>";
                            tabela += "</tr>";
                        }

                        tabela += "</tbody></table>";

                        // Preencha o modal com a tabela
                        balaoRelatorio.innerHTML = tabela;
                    } else {
                        // Em caso de erro na solicitação AJAX
                        balaoRelatorio.innerHTML = "Erro na solicitação: " + xhr.status;
                    }
                }
            };
            xhr.send();
        });
    </script>
    <script>
// Função para exibir os dados em linhas
function exibirDadosEmLinhas() {
    var dadosRelatorio = document.getElementById("dadosRelatorio");

    // Limpa o conteúdo anterior
    dadosRelatorio.innerHTML = "";

    // Itera sobre os produtos e cria uma linha para cada um
    produtos.forEach(function(produto) {
        var linha = document.createElement('div');
        linha.className = 'linha'; // Estilize conforme sua necessidade

        // Constrói a linha com os dados do produto
        linha.innerHTML = `
            <p>ID: ${produto.id}</p>
            <p>Nome: ${produto.nome}</p>
            <p>Modelo: ${produto.modelo}</p>
            <p>Tipo: ${produto.tipo}</p>
            <p>GBs: ${produto.gbs}</p>
            <p>bateria: ${produto.bateria}</p>
            <p>Valor: ${produto.valor.toFixed(2)}</p>
        `;

        // Adiciona a linha ao elemento dadosRelatorio
        dadosRelatorio.appendChild(linha);
    });
}

// Chame a função para exibir os dados em linhas
exibirDadosEmLinhas();
</script>
</body>
</html>
