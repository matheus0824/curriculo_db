<?php

$host     = "localhost";
$port     = 3306;
$dbname   = "curriculo_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Erro de conexão com o banco de dados: ' . htmlspecialchars($e->getMessage()));
}

function tabelaPermitida(string $table): bool
{
    static $permitidas = [
        'dados_pessoais',
        'contatos',
        'experiencias',
        'formacao'
    ];
    return in_array($table, $permitidas, true);
}

function create($pdo, $table, array $data) {
    if (!tabelaPermitida($table)) {
        throw new InvalidArgumentException("Tabela '$table' não permitida.");
    }
    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_values($data));
    return $pdo->lastInsertId();
}

function readAll($pdo, $table, $where = null) {
    if (!tabelaPermitida($table)) {
        throw new InvalidArgumentException("Tabela '$table' não permitida.");
    }
    $sql = "SELECT * FROM $table";
    if ($where) {
        $sql .= " WHERE $where";
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function readWhere($pdo, string $table, string $whereSql, array $params = []) {
    if (!tabelaPermitida($table)) {
        throw new InvalidArgumentException("Tabela '$table' não permitida.");
    }
    $sql = "SELECT * FROM $table WHERE $whereSql";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function updateWhere($pdo, string $table, array $data, string $whereSql, array $whereParams): int
{
    if (!tabelaPermitida($table)) {
        throw new InvalidArgumentException("Tabela '$table' não permitida.");
    }
    $set = [];
    foreach (array_keys($data) as $column) {
        $set[] = "$column = ?";
    }
    $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE " . $whereSql;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge(array_values($data), $whereParams));
    return $stmt->rowCount();
}

function deleteWhere($pdo, string $table, string $whereSql, array $whereParams): bool
{
    if (!tabelaPermitida($table)) {
        throw new InvalidArgumentException("Tabela '$table' não permitida.");
    }
    $sql = "DELETE FROM $table WHERE " . $whereSql;
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($whereParams);
}
?>