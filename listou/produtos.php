<?php

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas listas</title>
    <link rel="shortcut icon" href="img/Listou!2.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/produtos.css">
    <!-- Bootstrap CSS  dentro do head-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->

    <script src="https://kit.fontawesome.com/4533a4cadf.js" crossorigin="anonymous"></script>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bd-light shadow p-3">
            <div class="container-fluid ">

                <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#exampleModal">
                    <span class="navbar-toggler-icon fa-lg"></span>
                </button>

                <div class="mobile-hide collapse navbar-collapse justify-content-between">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="">Minhas listas</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Contatos</a></li>

                    </ul>
                    <ul class="navbar-nav nav-img d-none d-lg-block  "> 
                        <li class="nav-item d-none d-lg-block "><img src="img/Listou___1_-removebg-preview.png" width="60" alt=""></li>
                    </ul>
                    <ul class="navbar-nav  ">
                        <li class="nav-item "><a class="btn btn-outline-light" href="minhaconta.php"><i class="fa-regular fa-circle-user fa-lg mr-2"></i>Minha conta</a></li>
                        <li class="nav-item"><a class="btn btn-outline-light" href="sair.php" >Sair</a></li>

                    </ul>


                </div>
            </div>
        </nav>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog w-100 " role="document">
              <div class="modal-content pt-2 justify-content-between ">
                <div class="modal-header d-flex  ">

                  <div id="conta2" class=" mr-1 row btn btn-light ">
                    <ul class="navbar-nav  ">
                        <li class="nav-item "><a class="btn btn-outline-light" href="minhaconta.php"><i class="fa-regular fa-circle-user fa-lg mr-2"></i>Minha conta</a></li>                 
                    </ul>

                  </div>   
                </div>

                <div class="modal-body">
                    
                    <div class="ho modal-line"><a class="nav-link" href="minhaslistas.php">Minhas listas</a></div>
                     <div class="ho modal-line"><a class="nav-link" href="">Contatos</a></div>
                     <div class="ho modal-line"><a class="nav-link" href="sair.php">Sair</a></div>
                  
                </div>

              </div>
            </div>
        </div>

    </header>

    <div class="container">
      <h2>Compras do Mercado</h2>
      <ul id="grocery-list">

      </ul>
      <div class="add-item">
        <input type="text" id="new-item" placeholder="Digite o nome do produto...">
        <button onclick="addItem()">Adicionar</button>
      </div>
    </div>

    <script>
      function addItem() {
        var newItemInput = document.getElementById("new-item");
        var newItemValue = newItemInput.value.trim();

        if (newItemValue !== "") {
          var groceryList = document.getElementById("grocery-list");
          var newItem = document.createElement("li");
          newItem.classList.add("item");

          newItem.innerHTML = `
            <input type="checkbox" id="${newItemValue.toLowerCase()}">
            <label for="${newItemValue.toLowerCase()}">${newItemValue}</label>
            <button class="edit-button">Editar</button>
            <button class="delete -button">Excluir</button>
          `;

          groceryList.appendChild(newItem);
          newItemInput.value = "";

          // Adicionar evento de clique para o botão de exclusão
          var deleteButtons = document.querySelectorAll(".delete-button");
          deleteButtons.forEach(function(button) {
            button.addEventListener("click", function() {
              var listItem = button.parentNode;
              listItem.remove();
            });
          });

          // Adicionar evento de clique para o botão de edição
          var editButtons = document.querySelectorAll(".edit-button");
          editButtons.forEach(function(button) {
            button.addEventListener("click", function() {
              var listItem = button.parentNode;
              var label = listItem.querySelector("label");
              var input = document.createElement("input");
              input.type = "text";
              input.value = label.textContent;
              label.replaceWith(input);

              button.textContent = "Salvar";
              button.classList.add("save-button");
              button.classList.remove("edit-button");

              button.addEventListener("click", function() {
                var inputValue = input.value;
                var newLabel = document.createElement("label");
                newLabel.textContent = inputValue;
                input.replaceWith(newLabel);

                button.textContent = "Editar";
                button.classList.add("edit-button");
                button.classList.remove("save-button");
              });
            });
          });
        }
      }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

</body>
</html>