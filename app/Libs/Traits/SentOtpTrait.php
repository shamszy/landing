<?php

namespace App\Libs\Traits;

use App\Mail\AccountVerificationMail;
use App\Mail\TransactionOtpMail;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * SentOtpTrait
 */
trait SentOtpTrait
{
    /**
     * @param $userId
     * @param $otp
     * @param $name
     * @param $email
     * @param $type
     * @return void
     */
    public function sendOtp($userId, $otp, $name, $email, $type): void
    {
        # User Does not Have Any Existing OTP
        $otpCode = Otp::where('user_id', '=', $userId)->latest()->first();
        $now = Carbon::now();
        if($otpCode && $now->isBefore($otpCode->expire_at)) {
            $otpCode->delete();
        }
        (new \App\Models\Otp)->create([
            'user_id' => $userId,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(15)
        ]);
        $mail = new AccountVerificationMail([
            'otp' => $otp,
            'name' => $name
        ]);
        Mail::to($email)->send($mail);
    }

}
