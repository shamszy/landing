<?php

namespace App\Libs\Traits;

/**
 *  UsesUuidTrait
 */
trait UsesUuidTrait
{
    /**
     * @return void
     */
    protected static function bootUsesUuidTrait(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) str()->uuid();
            }
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
    
}
