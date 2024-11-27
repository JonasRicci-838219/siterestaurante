<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = $conn->prepare("SELECT * FROM tb_usuario WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();

    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['id'];
        header("Location: cardapio.php");
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="index.php">
            <h1>Login</h1>
            <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Senha</label>
            <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
            <a href="cadastro.php">Cadastrar-se</a>
        </form>
    </div>
</body>
</html>


---

#### **cadastro.php** (Cadastro de Usuário)
php
<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $query = $conn->prepare("INSERT INTO tb_usuario 
        (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado) 
        VALUES (:nome, :email, :data_nascimento, :telefone, :senha, :cep, :rua, :numero, :bairro, :complemento, :cidade, :estado)");

    $query->bindParam(':nome', $nome);
    $query->bindParam(':email', $email);
    $query->bindParam(':data_nascimento', $data_nascimento);
    $query->bindParam(':telefone', $telefone);
    $query->bindParam(':senha', $senha);
    $query->bindParam(':cep', $cep);
    $query->bindParam(':rua', $rua);
    $query->bindParam(':numero', $numero);
    $query->bindParam(':bairro', $bairro);
    $query->bindParam(':complemento', $complemento);
    $query->bindParam(':cidade', $cidade);
    $query->bindParam(':estado', $estado);

    if ($query->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $erro = "Erro ao cadastrar usuário.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="cadastro-container">
        <form method="POST" action="cadastro.php">
            <h1>Cadastro</h1>
            <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
            <label>Nome</label>
            <input type="text" name="nome" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" required>
            <label>Telefone</label>
            <input type="text" name="telefone" required>
            <label>Senha</label>
            <input type="password" name="senha" required>
            <label>Confirmação de Senha</label>
            <input type="password" name="confirmar_senha" required>
            <label>CEP</label>
            <input type="text" name="cep" required>
            <label>Rua</label>
            <input type="text" name="rua" required>
            <label>Número</label>
            <input type="text" name="numero" required>
            <label>Bairro</label>
            <input type="text" name="bairro" required>
            <label>Complemento</label>
            <input type="text" name="complemento">
            <label>Cidade</label>
            <input type="text" name="cidade" required>
            <label>Estado</label>
            <input type="text" name="estado" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>

