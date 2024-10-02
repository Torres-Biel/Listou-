<?php
// Inicia o buffer de saída para evitar problemas de redirecionamento
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas listas</title>
    <link rel="shortcut icon" href="img/Listou!2.png" type="image/x-icon">
    <link rel="stylesheet" href="css/produtos.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4533a4cadf.js" crossorigin="anonymous"></script>

    <style>
        /* Estilos para as linhas da tabela */
        tbody tr:nth-child(odd) {
            background-color: #644989; /* Cor roxa */
            color: white; /* Texto em branco para contraste */
        }

        tbody tr:nth-child(even) {
            background-color: white; /* Cor branca */
            color: black; /* Texto em preto */
        }

        tbody tr:hover {
            background-color: #c6c6c6; /* Cor de destaque ao passar o mouse */
        }

        .edit-container {
            display: none; /* Esconde o container de edição inicialmente */
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#exampleModal">
                    <span class="navbar-toggler-icon fa-lg"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-between">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="minhaslistas.php">Minhas listas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contatos</a></li>
                    </ul>
                    <ul class="navbar-nav d-none d-lg-block">
                        <li class="nav-item"><img src="img/Listou___1_-removebg-preview.png" width="60" alt="Logo"></li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="btn btn-outline-dark" href="minhaconta.php"><i class="fa-regular fa-circle-user fa-lg mr-2"></i>Minha conta</a></li>
                        <li class="nav-item"><a class="btn btn-outline-dark" href="sair.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Modal Mobile -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog w-100" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="btn btn-outline-dark" href="minhaconta.php"><i class="fa-regular fa-circle-user fa-lg mr-2"></i>Minha conta</a>
                </div>
                <div class="modal-body">
                    <a class="nav-link" href="minhaslistas.php">Minhas listas</a>
                    <a class="nav-link" href="#">Contatos</a>
                    <a class="nav-link" href="sair.php">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <div class="add text-center">
        <h2 style="margin-top: 2rem;" >Adicionar Produto</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline justify-content-center">
            <div class="form-group mr-2">
                <label for="nome" class="sr-only">Nome do item:</label>
                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Digite o nome do item...">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Adicionar Item</button>
        </form>
    </div>

    <!-- Nome da Lista -->

        <div class="lista" style="margin-top: 2rem;"    >
            <h1 style="color: white;">Lista 1</h1>
        </div>

    <div class="container mt-5">
    <?php
    require_once 'config.php';

    // Verifica se o formulário de atualização de checkbox foi enviado
    if (isset($_POST['update_comprado'])) {
        $id = $_POST['item_id'];
        $comprado = isset($_POST['comprado']) ? 1 : 0; // Se marcado, valor 1, senão 0

        // Atualiza o status de "comprado" no banco de dados
        $update_query = "UPDATE itens SET comprado = '$comprado' WHERE id = $id";
        mysqli_query($conn, $update_query);
    }

    // Verifica se o formulário de edição foi enviado
    if (isset($_POST['update_nome'])) {
        $id = $_POST['item_id'];
        $novo_nome = $_POST['novo_nome'];

        // Atualiza o nome do item no banco de dados
        $update_query = "UPDATE itens SET nome = '$novo_nome' WHERE id = $id";
        mysqli_query($conn, $update_query);
    }

    // Consulta para selecionar todos os itens da tabela 'itens'
    $query = "SELECT * FROM itens";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered'>
                <thead>
                  <tr>
                    <th style='width: 40px;'>ID</th> <!-- Largura reduzida para a coluna 'ID' -->
                    <th>Nome</th>
                    <th style='width: 80px;'>Check</th> <!-- Largura reduzida para a coluna 'Comprado' -->
                    <th style='width: 100px;'>Ações</th> <!-- Largura reduzida para a coluna 'Ações' -->
                  </tr>
                </thead>
                <tbody>";

        // Loop através dos resultados e exibir os itens em uma tabela
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>
                        <span class='item-nome'>" . $row['nome'] . "</span>
                        <div class='edit-container' id='edit-container-" . $row['id'] . "'>
                            <form action='' method='post'>
                                <input type='hidden' name='item_id' value='" . $row['id'] . "'>
                                <input type='text' class='form-control' name='novo_nome' value='" . $row['nome'] . "' required>
                                <input type='hidden' name='update_nome' value='1'>
                                <button type='submit' class='btn btn-success btn-sm mt-1'>Salvar</button>
                            </form>
                        </div>
                    </td>
                    <td class='text-center'>
                      <form action='' method='post' class='d-flex justify-content-center align-items-center'>
                        <input type='hidden' name='item_id' value='" . $row['id'] . "'>
                        <input type='checkbox' name='comprado' value='1' onchange='this.form.submit()' " . ($row['comprado'] ? "checked" : "") . ">
                        <input type='hidden' name='update_comprado' value='1'>
                      </form>
                    </td>
                    <td>
                      <div class='d-flex'>
                          <button class='btn btn-warning btn-sm mr-2' onclick='toggleEdit(" . $row['id'] . ")'>Editar</button>
                          <a href='excluir.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este item?\")'>Excluir</a>
                      </div>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-center'>Nenhum item encontrado.</p>";
    }

    // Verifica se o formulário de adição foi enviado
    if (isset($_POST['submit'])) {
        $nome = $_POST['nome'];
        $comprado = 0; // Define como não comprado inicialmente

        // Insere o novo item no banco de dados
        $query = "INSERT INTO itens (nome, comprado) VALUES ('$nome', '$comprado')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Atualiza os IDs dos itens após a inserção
            $update_query = "SET @new_id = 0; 
                             UPDATE itens SET id = (@new_id := @new_id + 1) ORDER BY id;";

            mysqli_multi_query($conn, $update_query);

            // Redireciona para a mesma página após adicionar o item
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Erro ao adicionar item: " . mysqli_error($conn);
        }
    }

    // Fecha a conexão
    mysqli_close($conn);
    ?>

    <script>
        // Função para alternar a exibição do formulário de edição
        function toggleEdit(itemId) {
            const editContainer = document.getElementById('edit-container-' + itemId);
            if (editContainer.style.display === "none" || editContainer.style.display === "") {
                editContainer.style.display = "block"; // Exibe o formulário de edição
            } else {
                editContainer.style.display = "none"; // Esconde o formulário de edição
            }
        }
    </script>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT+guI0cKz7L6U9EImIuWjZV1cH6atBwxg58O4C6Uek56vYgjhP" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-JZ8pYFf7uD4zp0fQ1XgpHnGn4wfsSBM3dL8NxdWkN18i7xLZ/0D4DA/5F9P7yM6p" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZ8AMtC0YUtG1AlGg8U6t/5uC9uDrU1dDrYkl50G3mfc2P3kW92Wqsl2R" crossorigin="anonymous"></script>

</body>
</html>
