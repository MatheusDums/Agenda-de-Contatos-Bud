<?php

require("conector.php");

if (isset($_GET)) {

    $id = $_GET['id'];
    $nome = $_GET['nome'];
    $telefone = $_GET['telefone'];
    $email = $_GET['email'];
    $nascimento = $_GET['nascimento'];
    $observacoes = $_GET['observacoes'];


    $query = "INSERT INTO contatos (id, nome, telefone, email, nascimento, observacoes) 
    VALUES ('$id', '$nome', '$telefone', '$email', '$nascimento', '$observacoes')";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    header("Location: index.php");
}
