<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $address
 * @property mixed $phone_number
 * @property mixed $cac_number
 * @property mixed $logo
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 * @property mixed $board_members
 * @property mixed $category
 */
class CompanyResource extends JsonResource
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
            'id'  => $this->id,
            'name'  => $helper->cleanStringHelper($this->name),
            'address'  => $helper->cleanStringHelper($this->address),
            'phone_number'  => $helper->cleanStringHelper($this->phone_number),
            'cac_number'  => $helper->cleanStringHelper($this->cac_number),
            'logo'  => $helper->cleanStringHelper($this->logo),
            'slug' => $helper->cleanStringHelper($this->slug),
            'board_members' => json_decode($this->board_members),
            'relationship' => [
                'user' => new UserResource($this->whenLoaded('user')),
                'category' => new CategoryResource($this->category)
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
