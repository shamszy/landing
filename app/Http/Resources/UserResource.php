<?php

namespace App\Http\Resources;

use App\Libs\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $email
 * @property mixed $email_verified_at
 * @property mixed $account_status
 * @property mixed $role
 * @property mixed $company
 * @property mixed $admin
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $helper = new SystemHelper();
        $arrayData = [
            'id'  => $this->id,
            'email' => $helper->cleanStringHelper($this->email),
            'email_verified_at' => $this->email_verified_at,
            'active_status' => $this->account_status,
            'role' => $this->role
        ];
        if ($this->role == 'company' || $this->role === RoleEnum::COMPANY) {
            $arrayData['details'] = new CompanyResource($this->company);
        } elseif ($this->role == 'admin' || $this->role === RoleEnum::ADMIN) {
            $arrayData['details'] = new AdminResource($this->admin);
        }
        return  $arrayData;
    }

}
