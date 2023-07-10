<?php
include "conexao.php";

// Obtém os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Insere os dados no banco de dados
$query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
$resultado = mysqli_query($conexao, $query);

// Verifica se o cadastro foi realizado com sucesso
if ($resultado) {
    // Redireciona de volta para index.php com mensagem de sucesso
    header("Location: index.php?mensagem=Cadastro realizado com sucesso!");
} else {
    // Redireciona de volta para index.php com mensagem de erro
    header("Location: index.php?mensagem=Erro ao cadastrar usuário.");
}

header('Location: index.php?mensagem=sucesso');
exit;

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
