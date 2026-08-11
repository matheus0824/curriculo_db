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

    <div id="contatos" class="card">
        <h2>Contatos</h2>

        <div class="conteudo-card">
            <p><strong>E-mail:</strong><?=htmlspecialchars($dadosPessoais['email'] ?? 'Não informado') ?></p>
            <p><strong>telefone:</strong><?=htmlspecialchars($dadosPessoais['telefone'] ?? 'Não informado') ?></p>
            <p><strong>Perfis Profissionais:</strong><?=htmlspecialchars($dadosPessoais['perfis_profissionais'] ?? 'Não informado') ?></p>
        </div>
    </div>

    <div id="experiencias" class="card">
        <h2>Experiências Profissionais</h2>
        <div class="conteudo-card">
            <?php if(!empty($experiencias)): ?>
                <?php foreach($experiencias as $exp): ?>
                    <div class="item=lista">
                        <h3><?=htmlspecialchars($dadosPessoais['funcao'])?></h3>
                        <h4><?=htmlspecialchars($dadosPessoais['empresa'])?> . <span><?=htmlspecialchars($exp['periodo'])?></span></h4>
                        <p><?=nl2br(htmlspecialchars($exp['descricao']))?></p>
                    </div>
                <?php endforeach; 
                ?>
            <?php else: ?>
        </div>
    </div>



     <!--Quarto card(instituicao, curso e periodo)-->
    <div class="terceiro-card-container">
        <h1>isso é um teste</h1>
    </div>

    </div>
    

    </main>

</body>
</html>