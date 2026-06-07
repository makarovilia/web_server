<?php

class Tag extends Model
{
    public function getUnsorted(): array
    {
        $sql = "
            SELECT h.*
            FROM HashTag h
            LEFT JOIN Hash_Field hf
                ON hf.hash_id = h.id
            WHERE hf.hash_id IS NULL
        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }
        public function create(string $name)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO HashTag(name) VALUES(?)"
        );

        $stmt->execute([$name]);
    }

    public function getAssigned(): array
    {
        $sql = "
            SELECT
                h.name AS hashtag,
                f.name AS field_name
            FROM HashTag h
            JOIN Hash_Field hf ON hf.hash_id = h.id
            JOIN Field f ON f.id = hf.field_id
            ORDER BY f.name, h.name
        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}