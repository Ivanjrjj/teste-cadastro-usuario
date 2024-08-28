<?php
include 'php/config.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        $nome = htmlspecialchars(trim($_POST['nome']));
        $email = htmlspecialchars(trim($_POST['email']));
        $senha = htmlspecialchars(trim($_POST['senha']));

        if (empty($nome) || empty($email) || empty($senha)) {
            $message = "Todos os campos devem ser preenchidos.";
            $messageType = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Digite um e-mail válido.";
            $messageType = 'error';
        } elseif (strlen($senha) < 8) {
            $message = "A senha deve conter pelo menos 8 caracteres.";
            $messageType = 'error';
        } else {
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $emailCount = $stmt->fetchColumn();

            if ($emailCount > 0) {
                $message = "Este e-mail já está cadastrado.";
                $messageType = 'error';
            } else {
                $stmt = $conexao->prepare("INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");

                try {
                    $stmt->execute([
                        ':nome' => $nome,
                        ':email' => $email,
                        ':senha' => sha1($senha)
                    ]);
                    $message = "Cadastro realizado com sucesso!";
                    $messageType = 'success';
                } catch (PDOException $e) {
                    $message = 'Erro na consulta: ' . $e->getMessage();
                    $messageType = 'error';
                }
            }
        }
    } else {
        $message = "Dados ausentes.";
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logovox.svg" type="image/x-icon">
    <title>Case VOX</title>
</head>

<body>
    <form id="registration-form" action="index.php" method="POST">
        <div class="main-cadastro">
            <div class="left-cadastro">
                <h1>Faça o Cadastro <br>E Faça Parte da Vox Tecnologia</h1>
                <img src="img/hand-coding-animate.svg" class="left-cadastro-img" alt="Logo">
            </div>
            <div class="right-cadastro">
                <div class="card-cadastro">
                    <h1>CADASTRO</h1>
                    <div class="textfield">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome"
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                    </div>
                    <div class="textfield">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    <div class="textfield">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha" required>
                    </div>
                    <button type class="btn-cadastro">Cadastro</button>
                    <?php if ($message): ?>
                        <div class="message <?= htmlspecialchars($messageType) ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>
                    <h5>Vox Tecnologia</h5>
                </div>
            </div>
        </div>
    </form>
    <script src="/js/main.js"></script>
</body>

</html>