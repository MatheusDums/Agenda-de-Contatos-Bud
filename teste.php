<?php
/* conectando ao banco de dados */

$servidor = "localhost";
$banco = "agenda-contatos";
$usuario = "root";
$senha = "";

$pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

// salvar contatos
if (isset($_GET["acao"]) && $_GET["acao"] == 'salvar') {
  $id = $_GET["id"];
  $nome = $_GET["nome"];
  $telefone = $_GET["telefone"];
  $email = $_GET["email"];
  $nascimento = $_GET["nascimento"];
  $observacoes = $_GET["observacoes"];

  $existe = $pdo->query("SELECT 1 FROM contatos WHERE id = $id")->fetch();

  if ($existe) {
    //atualizar
    $pdo->query("UPDATE contatos SET nome='$nome', telefone='$telefone', email='$email',
                 nascimento='$nascimento', observacoes='$observacoes' WHERE id=$id");
  } else {
    //inserir
    $pdo->query("INSERT INTO contatos(id, nome, telefone, email, nascimento, observacoes)
          VALUES('$id', '$nome', '$telefone', '$email', '$nascimento', '$observacoes')");
  }
  header("Location: teste.php");
} 

// esvaziar o formulário


//exluir
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
  $id = $_GET['id'];
  $pdo->query("DELETE FROM contatos WHERE id = $id");
  header("Location: teste.php");
}

//editar
$contato = [
  "id" => "",
  "nome" => "",
  "telefone" => "",
  "email" => "",
  "nascimento" => "",
  "observacoes" => ""
];

if (isset($_GET["acao"]) && $_GET["acao"] == "editar") {
  $id = $_GET['id'];
  $resultado = $pdo->query("SELECT * FROM contatos WHERE id = $id");
  $contato = $resultado->fetch();
}
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
    <section id="form_container">
      <form method="GET" class="formulario">

        <input type="hidden" name="acao" value="salvar">

        <div class="input_box">

          <input type="hidden" name="id" id="id" value="<?php echo $contato['id']; ?>">
        </div>

        <div class="input_box">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" value="<?php echo $contato['nome']; ?>" required>
        </div>

        <div class="input_box">
          <label for="telefone">Telefone:</label>
          <input type="tel" id="telefone" name="telefone" value="<?php echo $contato['telefone']; ?>" required>
        </div>

        <div class="input_box">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo $contato['email']; ?>" required>
        </div>

        <div class="input_box">
          <label for="nascimento">Data de Nascimento:</label>
          <input type="date" id="nascimento" name="nascimento" value="<?php echo $contato['nascimento']; ?>" required>
        </div>

        <div class="input_box">
          <label for="observacoes">Observações:</label>
          <input type="text" name="observacoes" id="observacoes" value="<?php echo $contato['observacoes']; ?>">
        </div>

        <input type="submit" value="Salvar" />
        <input type="submit" value="Cancelar">
      </form>
    </section>


    <section id="table_container">
      <div class="table_content">
        <table class="table">
          <thead class="table_head">
            <tr>
<!--               <th>ID</th> -->
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
            $todos = $pdo->query("SELECT * FROM `contatos`");
            foreach ($todos as $linha) {
              echo "<tr>";
/*               echo "<td>{$linha['id']}</td>"; */
              echo "<td>{$linha['nome']}</td>";
              echo "<td>{$linha['telefone']}</td>";
              echo "<td>{$linha['email']}</td>";
              echo "<td>{$linha['nascimento']}</td>";
              echo "<td>{$linha['observacoes']}</td>";
              echo "<td><a href='teste.php?acao=editar&id={$linha['id']}'>Editar</a> |
                  <a href='teste.php?acao=excluir&id={$linha['id']}' onclick=\"return confirm('Deseja excluir?')\">Excluir</a></td>";
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