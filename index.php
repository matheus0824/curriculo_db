<?php
require_once __DIR__ . '/partials/crud.php';

$id_curriculo = $_GET['id'] ?? null;

if (!$id_curriculo) {
    $stmt = $pdo->query("SELECT id FROM dados_pessoais ORDER BY id DESC LIMIT 1");
    $ultimo = $stmt->fetch();
    $id_curriculo = $ultimo['id'] ?? null;
}

if ($id_curriculo) {
    $dadosPessoais = readWhere($pdo, 'dados_pessoais', 'id = ?', [$id_curriculo])[0] ?? null;
    $contatos = readWhere($pdo, 'contatos', 'dados_pessoais_id = ?', [$id_curriculo])[0] ?? null;
    $experiencias = readWhere($pdo, 'experiencias', 'dados_pessoais_id = ?', [$id_curriculo]);
    $formacoes = readWhere($pdo, 'formacao', 'dados_pessoais_id = ?', [$id_curriculo]);
}
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

    <main class= "container-principal">
        <div id="perfil" class="card">

            <div class="foto_capa">
                 <img src="img/fotoCapa.jpg" alt="Foto da capa">
            </div>

            <div class="header=perfil">
              <div class="foto_perfil">
                <img src="img/fotoPerfil.png" alt="Foto de perfil">
            </div>
        </div>


    <div class="info_perfil">

        <h1><?=htmlspecialchars($dadosPessoais['nome']) ?? 'Nome não informado' ?></h1>
        <h2><?=htmlspecialchars($dadosPessoais['cargo'] ?? 'Cargo não informado')?></h2>
        <p class="resumo"><?=nl2br(htmlspecialchars($dadosPessoais['resumo'] ??''))?></p>
        <?php if (!empty($dadosPessoais['info_pessoais'])): ?>
            <p class="info_adicional"><small><?=htmlspecialchars($dadosPessoais['info_pessoais'])?></small></p>
        <?php endif; 
        ?>

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
        <h1>isso é um teste</h1>
    </div>

    </div>
    

    </main>

</body>
</html>