<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\UserResource;
use App\Libs\Helpers\SystemHelper;
use App\Libs\Traits\SentOtpTrait;
use App\Mail\WelcomeUserMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

/**
 *  VerifyAccountAction
 */
readonly class VerifyAccountAction
{
    use SentOtpTrait;

    /**
     * @param User $userModel
     * @param SystemHelper $systemHelper
     * @param Otp $otpModel
     */
    public function __construct(private User $userModel, private SystemHelper $systemHelper, private  Otp $otpModel )
    {}

    /**
     * verify user account
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function verifyAccountAction($request): JsonResponse
    {
        $now = Carbon::now();
        $otpCode = $this->otpModel->where('otp', '=', $request->otpCode)->first();
        if (!$otpCode) {
            return response()->json([
                'message' => 'Incorrect otp code provided',
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }elseif ($now->isAfter($otpCode->expires_at)){
            return response()->json([
                'message' => 'Otp code expired',
                'success' => false
            ], Response::HTTP_REQUEST_TIMEOUT);
        } else {
            $user = $this->userModel->findOrFail($otpCode->user_id);
                try {
                    $user->update([
                        'email_verified_at' => now(),
                    ]);
                    $otpCode->delete();
                    $this->welcomeMailWalker($user->email, $user->company->name);
                    return response()->json([
                        'message' => 'Account verified successfully',
                        'data' => new UserResource($user),
                        'success' => true
                    ], Response::HTTP_OK);
                } catch (\Exception $e) {
                    throw new DatabaseException("Sorry unable to verify user account",  $e->getMessage());
                }
        }
    }

    /**
     * @param $email
     * @param $name
     * @return void
     */
    public function welcomeMailWalker($email, $name): void
    {
        $email_user = new WelcomeUserMail([
            'name' => $name
        ]);
        Mail::to($email)->send($email_user);
    }

    /**
     * resend email otp action
     * @param $request
     * @return JsonResponse
     */
    public  function  reSendOtpAction($request): JsonResponse
    {
        $user = $this->userModel->where('email', '=', $request->email)->firstOrFail();
        $code = $this->systemHelper->generateRandomCode(6);
        $this->sendOtp($user->id, $code, $user->company->name, $request->email, 'verification');
        return response()->json([
            'message' => 'Email otp successfully sent',
            'data' => new UserResource($user),
            'success' => true
        ], Response::HTTP_OK);
    }

}
