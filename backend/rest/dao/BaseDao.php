<?php

require_once __DIR__ . '/../../config/database.php';

class BaseDao
{
    protected PDO $conn;
    protected string $table;

    public function __construct(string $table)
    {
        $this->conn = Database::getConnection();
        $this->table = $table;
    }

    public function get_all(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get_by_id(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    
    public function insert(array $data): array
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ")
                VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

        $id = (int)$this->conn->lastInsertId();
        return $this->get_by_id($id);
    }

    public function update(int $id, array $data): ?array
    {
        $set_parts = [];
        foreach ($data as $column => $value) {
            $set_parts[] = "{$column} = :{$column}";
        }

        $sql = "UPDATE {$this->table} 
                SET " . implode(',', $set_parts) . " 
                WHERE id = :id";

        $data['id'] = $id;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

        return $this->get_by_id($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
