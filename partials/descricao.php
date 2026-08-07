<?php
require_once 'partials/crud.php';

$id_usuario = 1;

$stmtPessoais = $pdo->prepare("select * from dados_pessoais where id = :id");
$stmtPessoais->execute(['id => $id_usuario']);
$dadosPessoais = $stmtPessoais->fetch(PDO::FETCH_ASSOC);
