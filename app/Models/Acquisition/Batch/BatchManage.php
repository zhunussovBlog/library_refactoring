<?php


namespace App\Models\Acquisition\Batch;


use App\Common\Helpers\Query\ManageBuilder;

trait BatchManage
{
    public function update(array $attributes = [], array $options = []): bool
    {
        return ManageBuilder::updateBuilder(self::class, $this->getKeyName(), $this->hesab_id, $attributes, $this->fillable);
    }

    public function delete(): ?bool
    {
        return ManageBuilder::deleteBuilder(self::class, $this->getKeyName(), $this->hesab_id);
    }
}
