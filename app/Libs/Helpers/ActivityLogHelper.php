<?php

namespace App\Libs\Helpers;

use App\Http\Resources\LogResource;
use App\Models\ActivityLog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * ActivityLogHelper
 */
readonly class ActivityLogHelper
{
    /**
     * @param ActivityLog $logModel
     */
    public function __construct(private ActivityLog $logModel)
    {}

    /**
     * create system activity log
     * @param $user_id
     * @param $action
     * @param $message
     * @param $status
     * @return mixed
     */
    public function log($user_id, $action, $message, $status): mixed
    {
        return $this->logModel->create([
            'user_id' => $user_id,
            'action' => $action,
            'message' => $message,
            'status' => $status,
        ]);
    }

    /**
     * get activity log for single user
     * @param $userId
     * @return AnonymousResourceCollection
     */
    public function getUserData($userId): AnonymousResourceCollection
    {
        $logs = $this->logModel->whereUserId($userId)->orderBy('created_at', 'DESC')->paginate(10);
        return  LogResource::collection($logs)->additional([
            'message' => "All logs fetch successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * get all system activity logs
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        $logs =  $this->logModel->orderBy('created_at', 'DESC')->paginate(10);
        return  LogResource::collection($logs)->additional([
            'message' => "All logs fetch successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

}
