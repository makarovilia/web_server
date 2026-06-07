<?php

class TagField extends Model
{
    public function attach(int $tagId, int $fieldId): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO Hash_Field(hash_id, field_id)
             VALUES (?, ?)"
        );

        $stmt->execute([$tagId, $fieldId]);
    }
}