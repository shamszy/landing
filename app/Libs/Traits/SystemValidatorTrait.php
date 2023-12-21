<?php

namespace App\Libs\Traits;

use Illuminate\Support\Collection;

/**
 * SystemValidatorTrait
 */
trait SystemValidatorTrait
{
    /**
     * @param array $data
     * @return Collection
     */
    public function validatorInArray(array $data): Collection
    {
        $json = json_encode($data);
        return collect(json_decode($json, true));
    }

}
