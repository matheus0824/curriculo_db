<?php
$host = "localhost";
$port = 3306;
$dbname = "curriculo_db";
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

    // Função para inserir um novo registro
    function create($pdo, $table, array $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $pdo->lastInsertId();
    }

    // Função para ler registros
    function readAll($pdo, $table, $where = null) {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function read($pdo, $table, $where = null) {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $sql .= ' LIMIT 1';
        $stmt = $pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function readWhere($pdo, $table, string $whereSql, array $params = []) {
        $sql = "SELECT * FROM $table WHERE $whereSql LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function tabelaPermitida(string $table): bool
    {
        static $permitidas = [
            'usuarios',
            'clientes',
            'equipamentos',
            'profissionais',
            'servicos',
            'contatos',
        ];
        return in_array($table, $permitidas, true);
    }

    // Função para atualizar um registro
    function update($pdo, $table, array $data, $where) {
        if (!tabelaPermitida($table)) {
            throw new InvalidArgumentException('Tabela não permitida.');
        }
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $set = implode(', ', $set);

        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }

    function updateById($pdo, string $table, array $data, int $id): int
    {
        return updateWhere($pdo, $table, $data, 'id = ?', [$id]);
    }

    function updateWhere($pdo, string $table, array $data, string $whereSql, array $whereParams): int
    {
        if (!tabelaPermitida($table)) {
            throw new InvalidArgumentException('Tabela não permitida.');
        }
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "$column = ?";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $set) . ' WHERE ' . $whereSql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), $whereParams));
        return $stmt->rowCount();
    }

    // Função para excluir um registro
    function delete($pdo, $table, $where) {
        if (!tabelaPermitida($table)) {
            throw new InvalidArgumentException('Tabela não permitida.');
        }
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute();
    }

    function deleteById($pdo, string $table, int $id): bool
    {
        return deleteWhere($pdo, $table, 'id = ?', [$id]);
    }

    function deleteWhere($pdo, string $table, string $whereSql, array $whereParams): bool
    {
        if (!tabelaPermitida($table)) {
            throw new InvalidArgumentException('Tabela não permitida.');
        }
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $whereSql;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($whereParams);
    }

} catch (PDOException $e) {
    $msg = $e->getMessage();
    if (stripos($msg, 'Unknown database') !== false) {
        die(
            'Banco de dados não encontrado. '
            . 'Ligue o MySQL no XAMPP e acesse <a href="../instalar_banco.php">instalar_banco.php</a> '
            . 'para criar o banco <strong>devon_monitoramento</strong>.'
        );
    }
    die('Erro de conexão: ' . htmlspecialchars($msg));
}