<!DOCTYPE html>
<html>
<head>
    <title>Área de Administração</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .concluido {
            background-color: green;
        }

        .nao-concluido {
            background-color: red;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px;
            z-index: 9999;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showNotification(mensagem, tipo) {
            var notification = $('<div class="alert alert-dismissible fade show mt-3" role="alert">')
                .addClass('alert-' + tipo)
                .text(mensagem);
            var closeButton = $('<button type="button" class="close" data-dismiss="alert" aria-label="Close">')
                .html('<span aria-hidden="true">&times;</span>');
            notification.append(closeButton);
            $('.notification').append(notification);
            setTimeout(function () {
                notification.alert('close');
            }, 5000);
        }
    </script>
</head>
<body>
<h1>Área de Administração</h1>

<?php
include "conexao.php";

// Atualização do status de conclusão
if (isset($_GET['concluido'])) {
    $idConcluir = $_GET['concluido'];
    $queryConcluir = "UPDATE usuarios SET concluido = 1 WHERE id = '$idConcluir'";
    $resultadoConcluir = mysqli_query($conexao, $queryConcluir);

    if ($resultadoConcluir) {
        $mensagem = "Usuário marcado como concluído!";
        $tipo = 'success';
        echo "<script>showNotification('$mensagem', '$tipo');</script>";
    } else {
        $mensagem = "Erro ao marcar usuário como concluído: " . mysqli_error($conexao);
        $tipo = 'danger';
        echo "<script>showNotification('$mensagem', '$tipo');</script>";
    }
}

// Seleciona todos os usuários cadastrados
$query = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexao, $query);
?>

<?php if (mysqli_num_rows($resultado) > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
            <tr class="<?= $usuario['concluido'] == 1 ? 'concluido' : 'nao-concluido' ?>">
                <td><?= $usuario['id'] ?></td>
                <td><?= $usuario['nome'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td><?= $usuario['concluido'] == 1 ? 'Concluído' : 'Não Concluído' ?></td>
                <td>
                    <?php if ($usuario['concluido'] == 1): ?>
                        Concluído
                    <?php else: ?>
                        <a href='admin.php?concluido=<?= $usuario['id'] ?>'>Marcar como Concluído</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Nenhum usuário cadastrado.</p>
<?php endif; ?>

<div class="notification">
    <?php if (isset($_GET['mensagem'])): ?>
        <div class="alert alert-dismissible fade show <?php echo $_GET['tipo']; ?>" role="alert">
            <?php echo $_GET['mensagem']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
