<!DOCTYPE html>
<html>
<head>
  <title>Exemplo de Modal com Tabela de iPhones Registrados</title>
  <!-- Inclua os links para as bibliotecas jQuery e Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    /* Estilos para o modal */
    .modal-content {
      padding: 20px;
    }
  </style>
</head>
<body>

<!-- Botão para abrir o modal -->
<button onclick="abrirModal()" class="btn btn-primary">Abrir Modal</button>

<!-- Estrutura do modal -->
<div class="modal" id="meuModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Botão para fechar o modal -->
      <span class="fechar" onclick="fecharModal()">&times;</span>
      <!-- Conteúdo do modal -->
      <div id="dadosRelatorio"></div>
      <!-- Botão para copiar os dados -->
      <button onclick="copiarDados()">Copiar</button>
    </div>
  </div>
</div>

<script>
  // Função para abrir o modal
  function abrirModal() {
    // Abre o modal usando jQuery
    $('#meuModal').modal('show');

    // Após abrir o modal, carregar os dados da tabela
    carregarTabelaIphones();
  }

  // Função para fechar o modal
  function fecharModal() {
    // Fecha o modal usando jQuery
    $('#meuModal').modal('hide');
  }

  // Função para carregar a tabela de iPhones Registrados
  function carregarTabelaIphones() {
    // Fazer uma solicitação AJAX para buscar os dados da tabela
    // e preencher o conteúdo de #dadosRelatorio com os dados retornados
    // Exemplo de solicitação AJAX usando jQuery:
    $.ajax({
      url: 'gerar_relatorio.php',
      method: 'GET',
      dataType: 'json', // Especifica que os dados retornados são JSON
      success: function (data) {
        // Inicializa uma variável para armazenar o texto formatado
        var textoFormatado = '';

        // Loop através dos dados e exibe as informações formatadas
        data.forEach(function (iphone) {
          textoFormatado += 'ID: ' + iphone.id + '\n';
          textoFormatado += 'Nome: ' + iphone.nome + '\n';
          textoFormatado += 'Modelo: ' + iphone.modelo + '\n';
          textoFormatado += 'Bateria: ' + iphone.bateria + '% 🔋\n';
          textoFormatado += 'Gbs: ' + iphone.gbs + '\n';
          textoFormatado += 'Valor: ' + iphone.valor + '\n\n';
        });

        // Preencher o conteúdo do modal com os dados formatados usando a tag <pre>
        $('#dadosRelatorio').html('<pre>' + textoFormatado + '</pre>');
      },
      error: function () {
        alert('Erro ao carregar os dados da tabela.');
      }
    });
  }

  // Função para copiar os dados para a área de transferência
  function copiarDados() {
    var dados = $('#dadosRelatorio').text();
    navigator.clipboard.writeText(dados).then(function () {
      alert('Dados copiados para a área de transferência.');
    }).catch(function (err) {
      console.error('Erro ao copiar dados: ' + err);
    });
  }
</script>

</body>
</html>
