<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$queryCategorias = $conn->query("SELECT * FROM tb_categoria");
$categorias = $queryCategorias->fetchAll(PDO::FETCH_ASSOC);

$queryItens = $conn->query("SELECT i.*, c.nome AS categoria 
                            FROM tb_itens i
                            JOIN tb_categoria c ON i.idCategoria = c.id");
$itens = $queryItens->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="cardapio-container">
        <h1>Cardápio</h1>
        <div class="categorias">
            <?php foreach ($categorias as $categoria): ?>
                <h2><?= htmlspecialchars($categoria['nome']) ?></h2>
                <div class="itens">
                    <?php foreach ($itens as $item): ?>
                        <?php if ($item['idCategoria'] == $categoria['id']): ?>
                            <div class="item">
                                <h3><?= htmlspecialchars($item['nome']) ?></h3>
                                <p><?= htmlspecialchars($item['descricao']) ?></p>
                                <p>Preço: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                                <a href="detalhes.php?id=<?= $item['id'] ?>">Ver Detalhes</a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="logout.php">Sair</a>
    </div>
</body>
</html>

