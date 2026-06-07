<?php

class Field extends Model
{
    public function all(): array
    {
        return $this->db
            ->query("SELECT * FROM Field ORDER BY name")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $name): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO Field(name) VALUES(?)"
        );

        $stmt->execute([$name]);
    }
}