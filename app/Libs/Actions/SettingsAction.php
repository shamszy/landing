<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\UserResource;
use App\Libs\Traits\AuthUserTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Libs\Helpers\ActivityLogHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * Settings action
 */
readonly class SettingsAction
{
    use AuthUserTrait;

    /**
     * @param ActivityLogHelper $activityLogHelper
     * @param User $userModel
     */
    public function __construct(private ActivityLogHelper $activityLogHelper, private  User $userModel)
    {}

    /**
     * change account password
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function changeAccountPasswordAction($request): JsonResponse
    {
        $hashedPassword = $this->getAuthUser()->password;

        if (Hash::check($request->old_password , $hashedPassword)) {

            if (!Hash::check($request->password , $hashedPassword)) {

                try {
                    $this->getAuthUser()->update([
                        'password' => empty($request->password) ? $this->getAuthUser()->password : bcrypt($request->password),
                    ]);
                    $this->activityLogHelper->log($this->getAuthUser()->id, 'Change password', 'Password changed successfully', 'Successful'); //create activity log
                    return response()->json([
                        'message' => 'User password reset successful',
                        'data' => new UserResource($this->getAuthUser()),
                        'success' => true
                    ], Response::HTTP_OK);

                }catch (\Exception $e) {
                    $this->activityLogHelper->log($this->getAuthUser()->id, 'Change password', 'Password changed failed', 'Failed'); //create activity log
                    throw new DatabaseException("Sorry the password reset process failed",  $e->getMessage());
                }

            }else {
                return response()->json([
                    'message' => 'Sorry new password can not be the old password!',
                    'success' => false
                ], Response::HTTP_FORBIDDEN);
            }
        }else {
            return response()->json([
                'message' => 'Sorry old password doesnt matched',
                'success' => false
            ], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * suspend and activate account
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function suspendAndActivateUserAccountAction($request): JsonResponse
    {
        $user = $this->userModel->whereEmail($request->email)->firstOrFail();
        $displayStatusMessage = $request->status == 'active' ? 'activated' : 'suspended';
        try {
            $user->update([
                'account_status' => strtoupper($request->status)
            ]);
            return response()->json([
                'message' => 'User account '. $displayStatusMessage. ' successfully',
                'data' => new UserResource($user),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new DatabaseException('Sorry there was an error trying to '.$displayStatusMessage.' users account',  $e->getMessage());
        }
    }

    /**
     * image upload
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function uploadImageAction($request): JsonResponse
    {
        $userRole = $this->getAuthUser()->role;
        try {
            $userRole == 'company' ?
            $this->getAuthUser()->admin()->update([
                'profile_image' => $this->cloudinaryService->uploadSingleFileService($request, 'image')
            ]) : $this->getAuthUser()->company()->update([
                'logo' => $this->cloudinaryService->uploadSingleFileService($request, 'image')
            ]);
            $this->activityLogHelper->log($this->getAuthUser()->id, 'User Image Upload', 'Image Upload successfully', 'Successful'); //create activity log
            return response()->json([
                'message' => 'Image uploaded successfully',
                'data' => new UserResource($this->getAuthUser()),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            $this->activityLogHelper->log($this->getAuthUser()->id, 'Image Upload', 'Image Upload failed', 'Failed'); //create activity log
            throw new DatabaseException("Sorry unable to upload image",  $e->getMessage());
        }
    }

}
