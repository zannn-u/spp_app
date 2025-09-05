<?php
class Database {
    private mysqli $connection;

    public function __construct(string $host, string $user, string $pass, string $name) {
        $this->connection = new mysqli($host, $user, $pass, $name);
        if ($this->connection->connect_error) {
            throw new RuntimeException('DB connect error: ' . $this->connection->connect_error);
        }
        $this->connection->set_charset('utf8mb4');
    }

    public static function fromEnv(array $fallback = []): self {
        $default = array_merge([
            'DB_HOST' => 'localhost',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => 'db_spp',
        ], $fallback);

        $envPath = __DIR__.'/.env';
        $env = [];
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(ltrim($line), '#') === 0) continue;
                $pos = strpos($line, '=');
                if ($pos === false) continue;
                $key = trim(substr($line, 0, $pos));
                $val = trim(substr($line, $pos + 1));
                $env[$key] = $val;
            }
        }

        $host = $env['DB_HOST'] ?? $default['DB_HOST'];
        $user = $env['DB_USER'] ?? $default['DB_USER'];
        $pass = $env['DB_PASS'] ?? $default['DB_PASS'];
        $name = $env['DB_NAME'] ?? $default['DB_NAME'];
        return new self($host, $user, $pass, $name);
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }

    public function begin(): void { $this->connection->begin_transaction(); }
    public function commit(): void { $this->connection->commit(); }
    public function rollback(): void { $this->connection->rollback(); }

    public function queryOne(string $sql, string $types = '', array $params = []): ?array {
        $stmt = $this->prepareAndExecute($sql, $types, $params);
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        $stmt->close();
        return $row ?: null;
    }

    public function exec(string $sql, string $types = '', array $params = []): bool {
        $stmt = $this->prepareAndExecute($sql, $types, $params);
        $ok = $stmt->affected_rows >= 0;
        $stmt->close();
        return $ok;
    }

    private function prepareAndExecute(string $sql, string $types, array $params): mysqli_stmt {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Prepare failed: ' . $this->connection->error);
        }
        if ($types !== '' && count($params) > 0) {
            $stmt->bind_param($types, ...$params);
        }
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Execute failed: ' . $err);
        }
        return $stmt;
    }
}
?>

