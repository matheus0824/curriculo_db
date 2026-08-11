<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido ao formulário.");
}

require_once __DIR__ . '/crud.php'; 

try {
    $pdo->beginTransaction();

    $idPessoais = create($pdo, 'dados_pessoais', [
        'nome'          => $_POST['nome'] ?? null,
        'cargo'         => $_POST['cargo'] ?? null,
        'resumo'        => $_POST['resumo'] ?? null,
        'info_pessoais' => $_POST['info_pessoais'] ?? null
    ]);

    create($pdo, 'contatos', [
        'dados_pessoais_id'    => $idPessoais,
        'email'                => $_POST['email'] ?? null,
        'telefone'             => $_POST['telefone'] ?? null,
        'perfis_profissionais' => $_POST['perfis_profissionais'] ?? null
    ]);

    create($pdo, 'experiencias', [
        'dados_pessoais_id' => $idPessoais,
        'empresa'           => $_POST['empresa'] ?? null,
        'funcao'            => $_POST['funcao'] ?? null,
        'periodo'           => $_POST['periodo_exp'] ?? null,
        'descricao'         => $_POST['descricao_exp'] ?? null
    ]);

    create($pdo, 'formacao', [
        'dados_pessoais_id' => $idPessoais,
        'instituicao'       => $_POST['instituicao'] ?? null,
        'curso'             => $_POST['curso'] ?? null,
        'periodo'           => $_POST['periodo_formacao'] ?? null
    ]);

    $pdo->commit();

    header('Location: ../index.php?sucesso=1');
    exit();

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Erro ao cadastrar currículo: " . $e->getMessage();
}
?>
