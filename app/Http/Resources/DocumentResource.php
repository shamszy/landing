<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $document_link
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 * @property mixed $slug
 * @property mixed $document_type
 */
class DocumentResource extends JsonResource
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
            'title' => $helper->cleanStringHelper($this->document_type),
            'document_link' => json_decode($this->document_link),
            'slug' => $helper->cleanStringHelper($this->slug),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
