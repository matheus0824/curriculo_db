<?php
require_once __DIR__ . '/partials/crud.php';

$id_curriculo = $_GET['id'] ?? null;

if (!$id_curriculo) {
    $stmt = $pdo->query("SELECT id FROM dados_pessoais ORDER BY id DESC LIMIT 1");
    $ultimo = $stmt->fetch();
    $id_curriculo = $ultimo['id'] ?? null;
}

$dadosPessoais = null;
$contatos = null;
$experiencias = [];
$formacoes = [];

if ($id_curriculo) {
    $dadosPessoais = readWhere($pdo, 'dados_pessoais', 'id = ?', [$id_curriculo])[0] ?? null;
    $contatos = readWhere($pdo, 'contatos', 'dados_pessoais_id = ?', [$id_curriculo])[0] ?? null;
    $experiencias = readWhere($pdo, 'experiencias', 'dados_pessoais_id = ?', [$id_curriculo]);
    $formacoes = readWhere($pdo, 'formacao', 'dados_pessoais_id = ?', [$id_curriculo]);
}

$fotoPerfil = (!empty($dadosPessoais['foto_perfil']) && file_exists(__DIR__ . '/' . $dadosPessoais['foto_perfil'])) 
    ? $dadosPessoais['foto_perfil'] 
    : 'img/fotoPerfil.png';

$fotoCapa = (!empty($dadosPessoais['foto_capa']) && file_exists(__DIR__ . '/' . $dadosPessoais['foto_capa'])) 
    ? $dadosPessoais['foto_capa'] 
    : 'img/fotoCapa.jpg';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>HOME | CURRÍCULO</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#perfil">DADOS PESSOAIS</a></li>
                <li><a href="#contatos">CONTATOS</a></li>
                <li><a href="#experiencias">EXPERIÊNCIAS</a></li>
                <li><a href="#formacao">FORMAÇÃO</a></li>
                <?php if ($id_curriculo): ?>
                    <li><a href="formulario.php?id=<?= $id_curriculo ?>" class="btn-editar-nav">EDITAR CURRÍCULO</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container-principal">
        
        <div id="perfil" class="card">
            <div class="foto_capa">
                 <img src="<?= htmlspecialchars($fotoCapa) ?>" alt="Foto da capa">
            </div>

            <div class="header-perfil">
                <div class="foto_perfil">
                    <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="Foto de perfil">
                </div>
            </div>

            <div class="info_perfil">
                <h1><?= htmlspecialchars($dadosPessoais['nome'] ?? 'Nome não informado') ?></h1>
                <h2><?= htmlspecialchars($dadosPessoais['cargo'] ?? 'Cargo não informado') ?></h2>
                <p class="resumo"><?= nl2br(htmlspecialchars($dadosPessoais['resumo'] ?? '')) ?></p>
                <?php if (!empty($dadosPessoais['info_pessoais'])): ?>
                    <p class="info_adicional"><small><?= htmlspecialchars($dadosPessoais['info_pessoais']) ?></small></p>
                <?php endif; ?>
            </div>
        </div>

        <div id="contatos" class="card">
            <h2>Contatos</h2>
            <div class="conteudo-card">
                <p><strong>E-mail:</strong> <?= htmlspecialchars($contatos['email'] ?? 'Não informado') ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($contatos['telefone'] ?? 'Não informado') ?></p>
                <p><strong>Perfis Profissionais:</strong> <?= htmlspecialchars($contatos['perfis_profissionais'] ?? 'Não informado') ?></p>
            </div>
        </div>

        <div id="experiencias" class="card">
            <h2>Experiências Profissionais</h2>
            <div class="conteudo-card">
                <?php if (!empty($experiencias)): ?>
                    <?php foreach ($experiencias as $exp): ?>
                        <div class="item-lista">
                            <h3><?= htmlspecialchars($exp['funcao']) ?></h3>
                            <h4><?= htmlspecialchars($exp['empresa']) ?> • <span><?= htmlspecialchars($exp['periodo']) ?></span></h4>
                            <p><?= nl2br(htmlspecialchars($exp['descricao'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma experiência registrada.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div id="formacao" class="card">
            <h2>Formação Acadêmica</h2>
            <div class="conteudo-card">
                <?php if (!empty($formacoes)): ?>
                    <?php foreach ($formacoes as $form): ?>
                        <div class="item-lista">
                            <h3><?= htmlspecialchars($form['instituicao']) ?></h3>
                            <h4><?= htmlspecialchars($form['curso']) ?> • <span><?= htmlspecialchars($form['periodo']) ?></span></h4>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma formação registrada.</p>
                <?php endif; ?>
            </div>
        </div>

    </main>

</body>
</html>