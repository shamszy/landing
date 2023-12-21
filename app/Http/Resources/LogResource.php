<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $action
 * @property mixed $message
 * @property mixed $status
 * @property mixed $user
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class LogResource extends JsonResource
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
            'id' =>  $this->id,
            'action'  => $helper->cleanStringHelper($this->action),
            'message'  => $helper->cleanStringHelper($this->message),
            'status'  => $helper->cleanStringHelper($this->status),
            'relationship' => [
                'user' => new UserResource($this->user)
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
