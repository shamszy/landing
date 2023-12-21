<?php

namespace App\Libs\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Libs\Repositories\Contracts\ForgotPasswordRepositoryInterface;

/**
 * ForgotPasswordRepository
 */
readonly class ForgotPasswordRepository implements ForgotPasswordRepositoryInterface
{

    /**
     * @param User $model
     * @param PasswordReset $resetModel
     */
    public  function __construct(private User $model, private PasswordReset $resetModel)
    {}

    /**
     * send password reset link
     * @param $request
     * @return JsonResponse
     */
    public function sendPasswordResetLink($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        }else {
           $email_check = $this->model->where('email', '=', $request->email)->first();
           if ($email_check) {
               try {
                   $token = str()->random(64);
                   $this->resetModel->create([
                       'email' => $request->email,
                       'token' => $token,
                       'created_at' => now()
                   ]);
                   $email_user = new ForgotPasswordMail([
                       'name' =>$email_check->name,
                       'url' => config('meremco.meremco.forget_password_url').$token.'&email='.$request->email
                   ]);
                   Mail::to($request->email)->send($email_user);
                   return response()->json([
                       'message' => 'Email link sent successfully',
                       'data' => $request->email,
                       'success' => true
                   ], 200);
               } catch (\Exception $e) {
                   return response()->json([
                       'message' => 'Sorry unable to create password reset token',
                       'error' => $e->getMessage(),
                       'success' => false
                   ], Response::HTTP_BAD_REQUEST);
               }
           }else {
               return response()->json([
                     'message' => 'Sorry this email do not exist in our system',
                     'success' => false
               ], Response::HTTP_NOT_FOUND);
           }
        }
    }

    /**
     * reset users password
     * @param $request
     * @return JsonResponse
     */
    public function resetPassword($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            $token_check = $this->resetModel->where('email', '=', $request->email)
                ->where('token', '=', $request->token)->exists();
            if ($token_check) {
                $user = $this->model->where('email', '=', $request->email)->first();
                $hashedPassword = $user->password;
                if (!Hash::check($request->password , $hashedPassword)) {
                    try {
                        $user->update([
                            'password' => bcrypt($request->password)
                        ]);
                        DB::table('password_resets')->where('email', '=', $request->email)->delete();
                        return response()->json([
                            'message' => 'Password reset successfully',
                            'success' => true
                        ], Response::HTTP_OK);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'Sorry the password reset process failed',
                            'error' => $e->getMessage(),
                            'success' => false
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'message' => 'Sorry new password can not be the old password!',
                        'success' => false
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'message' => 'Sorry this email and token is invalid try again',
                    'success' => false
                ], Response::HTTP_NOT_FOUND);
            }
        }
    }

}
