<?php
require_once 'partials/crud.php'
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>HOME | CÚRRICULO</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>DADOS PESSOAIS</li>
                <li>CONTATOS</li>
                <li>EXPERIÊNCIAS</li>
                <li>FORMAÇÃO</li>
            </ul>
        </nav>
    </header>

    <div class="separando">

    <!--primeiro card(foto de perfil, foto de  capa e pequena
    descriçao do perfil)-->

    <div class="primeiro_card_container">
        
        <div class="foto_capa"> 
            <img src="img/fotoCapa.jpg" alt="Foto da capa">
        <div>

        <div class="foto_perfil">
            <img src="img/fotoPerfil.png" alt="Foto de perfil">
        </div>

        <div class="">
            <h1><?= $dadosPessoais['nome'] ?? 'Nome não informado'?></h1>
        </div>

    </div>

    <!--segundo card(sobre contatos, email, telefone, redes sociais)-->
    <div class="segundo-card-container">
        <h1>oi</h1>
    </div>

    <!--terceiro card(experiencias, funcao, periodo e descicao)-->
    <div class="terceiro-card-container">
        <h1>oi</h1>
    </div>

     <!--Quarto card(instituicao, curso e periodo)-->
    <div class="terceiro-card-container">
        <h1>oi</h1>
    </div>

    </div>
    



</body>
</html>