<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $idItem = $_GET['id'];

    $queryItem = $conn->prepare("SELECT * FROM tb_itens WHERE id = :id");
    $queryItem->bindParam(':id', $idItem);
    $queryItem->execute();

    $item = $queryItem->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "Item não encontrado.";
        exit();
    }
} else {
    echo "ID do item não informado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantidade = $_POST['quantidade'];
    $idUsuario = $_SESSION['usuario'];
    $preco = $item['preco'] * $quantidade;

    $queryPedido = $conn->prepare("INSERT INTO tb_itens_pedido (idUsuario, idItem, quantidade, preco) 
                                   VALUES (:idUsuario, :idItem, :quantidade, :preco)");
    $queryPedido->bindParam(':idUsuario', $idUsuario);
    $queryPedido->bindParam(':idItem', $idItem);
    $queryPedido->bindParam(':quantidade', $quantidade);
    $queryPedido->bindParam(':preco', $preco);

    if ($queryPedido->execute()) {
        header("Location: resumo.php");
        exit();
    } else {
        $erro = "Erro ao adicionar item ao pedido.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Item</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="detalhes-container">
        <h1><?= htmlspecialchars($item['nome']) ?></h1>
        <p><?= htmlspecialchars($item['descricao']) ?></p>
        <p>Preço: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
        <form method="POST" action="">
            <label>Quantidade:</label>
            <input type="number" name="quantidade" value="1" min="1" required>
            <button type="submit">Adicionar ao Pedido</button>
        </form>
        <a href="cardapio.php">Voltar ao Cardápio</a>
        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
    </div>
</body>
</html>

