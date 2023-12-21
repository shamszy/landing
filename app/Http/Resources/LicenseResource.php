<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $license_link
 * @property mixed $issued_date
 * @property mixed $expiry_date
 * @property mixed $previous_payment_prove
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 * @property mixed $is_active
 */
class LicenseResource extends JsonResource
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
            'title' => $helper->cleanStringHelper($this->title),
            'license_link' => $helper->cleanStringHelper($this->license_link),
            'issued_date' => $this->issued_date,
            'expiry_date' => $this->expiry_date,
            'previous_payment_prove' => $helper->cleanStringHelper($this->previous_payment_prove),
            'slug' => $helper->cleanStringHelper($this->slug),
            'is_active' => $this->is_active,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
