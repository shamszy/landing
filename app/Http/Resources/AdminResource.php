<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $full_name
 * @property mixed $phone_number
 * @property mixed $address
 * @property mixed $type
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $helper = new SystemHelper();
        return [
            'id'          => $this->id,
            'full_name'  => $helper->cleanStringHelper($this->full_name),
            'phone_number'  => $helper->cleanStringHelper($this->phone_number),
            'address'  => $helper->cleanStringHelper($this->address),
            'type'  => $helper->cleanStringHelper($this->type),
            'slug' => $helper->cleanStringHelper($this->slug),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
