<?php
// Configurações do Banco de Dados
$host    = 'localhost';
$dbname  = 'curriculo_db';
$user    = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();

    $sqlDadosPessoais = "INSERT INTO dados_pessoais (nome, cargo, resumo, info_pessoais) 
                         VALUES (:nome, :cargo, :resumo, :info_pessoais)";
    
    $stmtDados = $pdo->prepare($sqlDadosPessoais);
    $stmtDados->execute([
        ':nome'          => $_POST['nome'],
        ':cargo'         => $_POST['cargo'] ?? null,
        ':resumo'        => $_POST['resumo'] ?? null,
        ':info_pessoais' => $_POST['info_pessoais'] ?? null
    ]);

    $dados_pessoais_id = $pdo->lastInsertId();

    $sqlContatos = "INSERT INTO contatos (dados_pessoais_id, email, telefone, perfis_profissionais) 
                    VALUES (:dados_pessoais_id, :email, :telefone, :perfis_profissionais)";
    
    $stmtContatos = $pdo->prepare($sqlContatos);
    $stmtContatos->execute([
        ':dados_pessoais_id'     => $dados_pessoais_id,
        ':email'                 => $_POST['email'],
        ':telefone'              => $_POST['telefone'] ?? null,
        ':perfis_profissionais'  => $_POST['perfis_profissionais'] ?? null
    ]);

    $sqlExperiencias = "INSERT INTO experiencias (dados_pessoais_id, empresa, funcao, periodo, descricao) 
                        VALUES (:dados_pessoais_id, :empresa, :funcao, :periodo, :descricao)";
    
    $stmtExp = $pdo->prepare($sqlExperiencias);
    $stmtExp->execute([
        ':dados_pessoais_id' => $dados_pessoais_id,
        ':empresa'           => $_POST['empresa'],
        ':funcao'            => $_POST['funcao'],
        ':periodo'           => $_POST['periodo_exp'] ?? null,
        ':descricao'         => $_POST['descricao_exp'] ?? null
    ]);

    $sqlFormacao = "INSERT INTO formacao (dados_pessoais_id, instituicao, curso, periodo) 
                    VALUES (:dados_pessoais_id, :instituicao, :curso, :periodo)";
    
    $stmtFormacao = $pdo->prepare($sqlFormacao);
    $stmtFormacao->execute([
        ':dados_pessoais_id' => $dados_pessoais_id,
        ':instituicao'       => $_POST['instituicao'],
        ':curso'             => $_POST['curso'],
        ':periodo'           => $_POST['periodo_formacao'] ?? null
    ]);

    $pdo->commit();

    echo "Currículo cadastrado com sucesso! ID do Registro: " . $dados_pessoais_id;

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Erro ao cadastrar currículo: " . $e->getMessage();
}
?>