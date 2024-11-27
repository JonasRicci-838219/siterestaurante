<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario'];

$queryPedido = $conn->prepare("SELECT p.*, i.nome, i.preco AS preco_unitario 
                               FROM tb_itens_pedido p
                               JOIN tb_itens i ON p.idItem = i.id
                               WHERE p.idUsuario = :idUsuario AND p.finalizado = 0");
$queryPedido->bindParam(':idUsuario', $idUsuario);
$queryPedido->execute();

$itensPedido = $queryPedido->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($itensPedido as $item) {
    $total += $item['preco'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $queryFinaliza = $conn->prepare("UPDATE tb_itens_pedido SET finalizado = 1 WHERE idUsuario = :idUsuario");
    $queryFinaliza->bindParam(':idUsuario', $idUsuario);

    if ($queryFinaliza->execute()) {
        header("Location: obrigado.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Pedido</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="resumo-container">
        <h1>Resumo do Pedido</h1>
        <ul>
            <?php foreach ($itensPedido as $item): ?>
                <li>
                    <?= htmlspecialchars($item['nome']) ?> - 
                    Quantidade: <?= $item['quantidade'] ?> - 
                    Total: R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p>Total Geral: R$ <?= number_format($total, 2, ',', '.') ?></p>
        <form method="POST" action="">
            <button type="submit">Confirmar Pedido</button>
        </form>
    </div>
</body>
</html>

