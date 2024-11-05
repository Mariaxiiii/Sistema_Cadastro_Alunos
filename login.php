<?php
// Inicia uma sessão para armazenar informações do usuario durante a navegação.
session_star();

// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Verifica se a requisição foi feita atraves do metodo POST (envio do formulário).
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados enviados pelo formulário (usuario e senha).
    $usuario = $_POST['usuario'];
    // Aplica o algoritmo MD5 para criptografar a senha antes de verificar no banco de dados.
    $senha = md5($_POST['senha']);

    // Monta a consulta SQL para verificar se o usuario e a senha existem no banco
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    // Executa a consulta e armazena o resultado.
    $result = $conn->query($sql);

    // Verifica se a consulta retornou algum registro
    if ($result->num_rows > 0) {
        // Se o usuario for encontrado, armazena seu nome na sessão.
        $_SESSION['usuario'] = $usuario;
        // Redireciona o usuario para a pagina inicial.
        header('Location: index.php');
    } else {
        // Se o login falhar, define uma mensagem de erro.
        $error = "Usuario ou senha invalidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="width: 400px;">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit" style="margin-bottom: 30px;">Entrar</button>
            <!-- Exibe a mensagem de erro, se houver. -->
            <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>
        </form>
    </div>    
</body>
</html>