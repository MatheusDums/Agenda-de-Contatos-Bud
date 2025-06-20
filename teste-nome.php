 <?php
/* conectando ao banco de dados (igual ao conector.php)*/

$servidor = "localhost";
$banco = "agenda-contatos";
$usuario = "root";
$senha = "";

$pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

// salvar contato
if (isset($_GET["acao"]) && $_GET["acao"] == 'salvar') {

  if (isset($_GET['id']) && $_GET['id'] != "") {
    $id = $_GET['id'];
  };

  $nome = $_GET["nome"];
  $telefone = $_GET["telefone"];
  $email = $_GET["email"];
  $nascimento = $_GET["nascimento"];
  $observacoes = $_GET["observacoes"];

  if ($id > 0) {
    $existe = $pdo->query("SELECT 1 FROM tb_contatos WHERE con_id = $id")->fetch();
  } else {
    $existe = false;
  }

  if ($existe) {
    $pdo->query("UPDATE tb_contatos SET con_nome='$nome', con_telefone='$telefone', con_email='$email',
          con_nascimento='$nascimento', con_observacoes='$observacoes' WHERE con_id=$id");
  } else {
    $pdo->query("INSERT INTO tb_contatos( con_nome, con_telefone, con_email, con_nascimento, con_observacoes)
          VALUES( '$nome', '$telefone', '$email', '$nascimento', '$observacoes')");
  }
  header("Location: teste-nome.php");
}

//exluir
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
  $id = $_GET['id'];
  $pdo->query("DELETE FROM tb_contatos WHERE con_id = $id");
  header("Location: teste-nome.php");
}

$contato = [
  "con_id" => "",
  "con_nome" => "",
  "con_telefone" => "",
  "con_email" => "",
  "con_nascimento" => "",
  "con_observacoes" => ""
];

//editar
if (isset($_GET["acao"]) && $_GET["acao"] == "editar") {
  $id = $_GET['id'];
  $resultado = $pdo->query("SELECT * FROM tb_contatos WHERE con_id = $id");
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
          <input type="hidden" name="id" id="id" value="<?php echo $contato['con_id']; ?>">
        </div>

        <div class="input_box">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" value="<?php echo $contato['con_nome']; ?>" required>
        </div>

        <div class="input_box">
          <label for="telefone">Telefone:</label>
          <input type="tel" id="telefone" name="telefone" value="<?php echo $contato['con_telefone']; ?>" required>
        </div>

        <div class="input_box">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo $contato['con_email']; ?>" required>
        </div>

        <div class="input_box">
          <label for="nascimento">Data de Nascimento:</label>
          <input type="date" id="nascimento" name="nascimento" value="<?php echo $contato['con_nascimento']; ?>" required>
        </div>

        <div class="input_box">
          <label for="observacoes">Observações:</label>
          <input type="text" name="observacoes" id="observacoes" value="<?php echo $contato['con_observacoes']; ?>">
        </div>

        <input type="submit" value="Salvar" />
        <a href="teste-nome.php">Cancelar</a>
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
            $todos = $pdo->query("SELECT con_id, con_nome, con_telefone, con_email, con_nascimento, con_observacoes FROM `tb_contatos`");
            foreach ($todos as $linha) {
              echo "<tr>";
/*               echo "<td>{$linha['id']}</td>"; */
              echo "<td>{$linha['con_nome']}</td>";
              echo "<td>{$linha['con_telefone']}</td>";
              echo "<td>{$linha['con_email']}</td>";
              echo "<td>{$linha['con_nascimento']}</td>";
              echo "<td>{$linha['con_observacoes']}</td>";
              echo "<td><a href='teste-nome.php?acao=editar&id={$linha['con_id']}'>Editar</a> |
                  <a href='teste-nome.php?acao=excluir&id={$linha['con_id']}' onclick=\"return confirm('Deseja excluir?')\">Excluir</a></td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

  </body>
</body>

</html>