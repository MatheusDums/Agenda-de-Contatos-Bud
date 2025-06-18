<?php
include_once('conector.php');
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda de Contatos</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
  <header>
    <h1>Agenda de Contatos</h1>
  </header>

  <body>
    <div class="botao_adc_numero">
      <button class="contact_btn">Novo Contato</button>
    </div>

    <section id="form_container">
      <form action="cria_contato.php" method="GET" class="formulario">
        <div class="input_box">
          <label for="id">ID:</label>
          <input type="text" id="id" name="id"/>
        </div>

        <div class="input_box">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" />
        </div>

        <div class="input_box">
          <label for="telefone">Telefone:</label>
          <input type="tel" id="telefone" name="telefone" />
        </div>

        <div class="input_box">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" />
        </div>

        <div class="input_box">
          <label for="nascimento">Data de Nascimento:</label>
          <input type="date" id="nascimento" name="nascimento" />
        </div>

        <div class="input_box">
          <label for="observacoes">Observações:</label>
          <input type="text" name="observacoes" id="observacoes"></input>
        </div>

        <input type="submit" value="Adicionar Contato" />
      </form>
    </section>

    <section id="table_container">
      <div class="table_content">
        <table class="table">
          <thead class="table_head">
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Telefone</th>
              <th>Email</th>
              <th>Data de Nascimento</th>
              <th>Observações</th>
              <th colspan="2">Ações</th>
            </tr>
          </thead>

          <tbody class="table_body">
            <?php
            $stm = $pdo->query("SELECT * FROM `contatos`");
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . $row["nome"] . "</td>";
              echo "<td>" . $row["telefone"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["nascimento"] . "</td>";
              echo "<td>" . $row["observacoes"] . "</td>";
              echo "<td><a href='edit.php?id=". $row['id'] ."'><button>Editar Contato</button></a></td>";
              echo "<td><a href='delete.php?id=". $row['id'] ."'><button>Excluir Contato</button></a></td>";
              echo "</tr>";
            }

            ?>
          </tbody>
        </table>
      </div>
    </section>

    <script src="./assets/js/main.js"></script>
  </body>
</body>

</html>
