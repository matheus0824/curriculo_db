<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido ao formulário.");
}

require_once __DIR__ . '/crud.php'; 

$id = $_POST['id'] ?? null;

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

function processarUpload($keyName, $prefix, $uploadDir) {
    if (isset($_FILES[$keyName]) && $_FILES[$keyName]['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$keyName]['name'], PATHINFO_EXTENSION);
        $novoNome = $prefix . '_' . uniqid() . '.' . $ext;
        $destino = $uploadDir . $novoNome;
        if (move_uploaded_file($_FILES[$keyName]['tmp_name'], $destino)) {
            return 'uploads/' . $novoNome;
        }
    }
    return null;
}

try {
    $pdo->beginTransaction();

    $fotoPerfilPath = processarUpload('foto_perfil', 'perfil', $uploadDir);
    $fotoCapaPath   = processarUpload('foto_capa', 'capa', $uploadDir);

    if ($id) {
        $dadosUpdate = [
            'nome'          => $_POST['nome'] ?? null,
            'cargo'         => $_POST['cargo'] ?? null,
            'resumo'        => $_POST['resumo'] ?? null,
            'info_pessoais' => $_POST['info_pessoais'] ?? null
        ];

        if ($fotoPerfilPath) {
            $dadosUpdate['foto_perfil'] = $fotoPerfilPath;
        }
        if ($fotoCapaPath) {
            $dadosUpdate['foto_capa'] = $fotoCapaPath;
        }

        updateWhere($pdo, 'dados_pessoais', $dadosUpdate, 'id = ?', [$id]);

        updateWhere($pdo, 'contatos', [
            'email'                => $_POST['email'] ?? null,
            'telefone'             => $_POST['telefone'] ?? null,
            'perfis_profissionais' => $_POST['perfis_profissionais'] ?? null
        ], 'dados_pessoais_id = ?', [$id]);

        updateWhere($pdo, 'experiencias', [
            'empresa'   => $_POST['empresa'] ?? null,
            'funcao'    => $_POST['funcao'] ?? null,
            'periodo'   => $_POST['periodo_exp'] ?? null,
            'descricao' => $_POST['descricao_exp'] ?? null
        ], 'dados_pessoais_id = ?', [$id]);

        updateWhere($pdo, 'formacao', [
            'instituicao' => $_POST['instituicao'] ?? null,
            'curso'       => $_POST['curso'] ?? null,
            'periodo'     => $_POST['periodo_formacao'] ?? null
        ], 'dados_pessoais_id = ?', [$id]);

        $idPessoais = $id;
    } else {
        $idPessoais = create($pdo, 'dados_pessoais', [
            'nome'          => $_POST['nome'] ?? null,
            'cargo'         => $_POST['cargo'] ?? null,
            'resumo'        => $_POST['resumo'] ?? null,
            'info_pessoais' => $_POST['info_pessoais'] ?? null,
            'foto_perfil'   => $fotoPerfilPath,
            'foto_capa'     => $fotoCapaPath
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
    }

    $pdo->commit();

    header('Location: ../index.php?id=' . $idPessoais);
    exit();

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Erro ao processar currículo: " . $e->getMessage();
}