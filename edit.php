<?php
session_start();

include_once("conector.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query_edit_usuario = "SELECT * FROM contatos WHERE id = $id";
$result_edit_usuario = $pdo->prepare($query_edit_usuario);
$result_edit_usuario->execute();

if (($result_edit_usuario) AND ($result_edit_usuario->rowCount() !=0)) {
  $row_edit_usuario = $result_edit_usuario->fetch(PDO::FETCH_ASSOC);
  var_dump($row_edit_usuario);
/*     header("Location: index.php"); */
} else {
  echo "erro";
}
?>