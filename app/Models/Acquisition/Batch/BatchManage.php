<?php


namespace App\Models\Acquisition\Batch;


trait BatchManage
{
    public function update(array $attributes = [], array $options = []): bool
    {
        return static::updateBuilder(self::class, $this->getKeyName(), $this->hesab_id, $attributes, $this->fillable);
    }

    public function delete(): ?bool
    {
        return static::deleteBuilder(self::class, $this->getKeyName(), $this->hesab_id);
    }
}
