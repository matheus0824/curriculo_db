<?php
require_once __DIR__ . '/partials/crud.php';

$id_curriculo = $_GET['id'] ?? null;

$dadosPessoais = null;
$contatos = null;
$experiencia = null;
$formacao = null;

if ($id_curriculo) {
    $dadosPessoais = readWhere($pdo, 'dados_pessoais', 'id = ?', [$id_curriculo])[0] ?? null;
    $contatos = readWhere($pdo, 'contatos', 'dados_pessoais_id = ?', [$id_curriculo])[0] ?? null;
    $experiencia = readWhere($pdo, 'experiencias', 'dados_pessoais_id = ?', [$id_curriculo])[0] ?? null;
    $formacao = readWhere($pdo, 'formacao', 'dados_pessoais_id = ?', [$id_curriculo])[0] ?? null;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id_curriculo ? 'Editar Currículo' : 'Página de Cadastro - Currículo' ?></title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>

    <div class="pagina-cadastro">
        <main>
            <div class="caixa-cadastro">
                <h1 class="titulo-pagina"><?= $id_curriculo ? 'EDITAR CURRÍCULO' : 'PREENCHA O FORMULÁRIO' ?></h1>
       
                <form method="POST" action="partials/form.php" enctype="multipart/form-data">
                    <?php if ($id_curriculo): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id_curriculo) ?>">
                    <?php endif; ?>

                    <h2>Fotos</h2>
                    <label for="foto_perfil">Foto de Perfil:</label>
                    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

                    <label for="foto_capa">Foto de Capa:</label>
                    <input type="file" id="foto_capa" name="foto_capa" accept="image/*">

                    <h2>Dados pessoais</h2>
                    <input type="text" id="nome" name="nome" placeholder="Nome" value="<?= htmlspecialchars($dadosPessoais['nome'] ?? '') ?>" required>
                    <input type="text" id="cargo" name="cargo" placeholder="Cargo" value="<?= htmlspecialchars($dadosPessoais['cargo'] ?? '') ?>" required>
                    <input type="text" name="resumo" placeholder="Resumo Profissional" value="<?= htmlspecialchars($dadosPessoais['resumo'] ?? '') ?>" required>
                    <textarea name="info_pessoais" placeholder="Informações Pessoais / Adicionais"><?= htmlspecialchars($dadosPessoais['info_pessoais'] ?? '') ?></textarea>

                    <h2>Contatos</h2>
                    <input type="email" name="email" placeholder="E-mail" value="<?= htmlspecialchars($contatos['email'] ?? '') ?>" required>
                    <input type="text" name="telefone" placeholder="Telefone" value="<?= htmlspecialchars($contatos['telefone'] ?? '') ?>" required>
                    <textarea name="perfis_profissionais" placeholder="Perfis Profissionais"><?= htmlspecialchars($contatos['perfis_profissionais'] ?? '') ?></textarea>

                    <h2>Experiências</h2>
                    <input type="text" id="empresa" name="empresa" placeholder="Empresa" value="<?= htmlspecialchars($experiencia['empresa'] ?? '') ?>" required>
                    <input type="text" id="funcao" name="funcao" placeholder="Função" value="<?= htmlspecialchars($experiencia['funcao'] ?? '') ?>" required>
                    <input type="text" name="periodo_exp" placeholder="Período de Experiência" value="<?= htmlspecialchars($experiencia['periodo'] ?? '') ?>" required>
                    <textarea name="descricao_exp" placeholder="Descrição da Experiência"><?= htmlspecialchars($experiencia['descricao'] ?? '') ?></textarea>

                    <h2>Formação</h2>
                    <input type="text" id="instituicao" name="instituicao" placeholder="Instituição" value="<?= htmlspecialchars($formacao['instituicao'] ?? '') ?>" required>
                    <input type="text" id="curso" name="curso" placeholder="Curso" value="<?= htmlspecialchars($formacao['curso'] ?? '') ?>" required>
                    <input type="text" id="periodo" name="periodo_formacao" placeholder="Período da Formação" value="<?= htmlspecialchars($formacao['periodo'] ?? '') ?>" required>

                    <div class="btn">
                        <button type="submit"><?= $id_curriculo ? 'Atualizar' : 'Cadastrar' ?></button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>