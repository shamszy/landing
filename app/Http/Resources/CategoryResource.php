<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $annual_payment
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $helper = new SystemHelper();
        return [
            'id' => $this->id,
            'name'  => $helper->cleanStringHelper($this->name),
            'description'  => $helper->cleanStringHelper($this->description),
            'annual_payment'  => $helper->convertKoboToNaira($this->annual_payment),
            'slug' => $helper->cleanStringHelper($this->slug),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
