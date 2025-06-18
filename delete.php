<?php
session_start();

include_once("conector.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query_usuario = "SELECT  id FROM contatos WHERE id = $id LIMIT 1";
$result_usuario = $pdo->prepare($query_usuario);
$result_usuario->execute();

if (($result_usuario) AND ($result_usuario->rowCount() !=0)) {
    $query_del_usuario = "DELETE FROM contatos WHERE id = $id";
    $result_del_usuario = $pdo->prepare($query_del_usuario);
    $result_del_usuario->execute();
    header("Location: index.php");
} else {
     echo "erro";
}