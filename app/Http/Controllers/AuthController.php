<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FAQRCode\Google2FA;

class AuthController extends Controller
{
    protected $redirectTo = '/backend/dashboard';
    public function login()
    {
        if (!request()->hasValidSignature() || !session()->has("valid-user")) {
            abort(404);
        }
        return view("admin.auth.login");
    }

    public function postLogin(LoginRequest $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->status) {
                if (config("constants.enable_2fa")) {
                    if (!$user->google2fa_secret) {
                        // Setup 2FA
                        return redirect()->route("2fa-enable");
                    } else {
                        // Validate 2FA
                        return redirect()->route("2fa-validate");
                    }
                }

                return redirect()->intended($this->redirectTo);
            } else {
                auth()->logout();
                return back()->withErrors(["email" => "You can't login"]);
            }
        }

        return back()->withErrors(["email" => "Invalid email or password"]);
    }



    protected function enableTwoFactor(Request $request)
    {

        $user = auth()->user();
        if (!$user->google2fa_secret || $request->forgot) {
            $google2fa = new Google2FA();

            $secret = $google2fa->generateSecretKey();
            $user->update(["google2fa_secret" => $secret]);
            $enc = Crypt::encrypt($secret);

            $imageDataUri = $google2fa->getQRCodeInline(
                $request->getHttpHost(),
                $user->email,
                $secret,
                200
            );

            // $user->update(["google2fa_secret" => $enc]);

            return view('admin.auth.2fasetup', [
                'image' => $imageDataUri,
                'secret' => $secret
            ]);
        } else {
            return redirect()->route("validate-2fa");
        }
    }


    public function validate2FA()
    {
        if (auth()->user()->google2fa_secret) {
            return view("admin.auth.2favalidate");
        } else {
            return redirect()->route("2fa-enable");
        }
    }

    public function postValidate2FA(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        // $secret = Crypt::decrypt($user->google2fa_secret);
        $secret = $user->google2fa_secret;
        $valid = $google2fa->verifyKey($secret, $request->otp);
        if ($valid) {
            return redirect()->intended($this->redirectTo)->with("success", "Logged in Successfully.");
        } else {
            return redirect()->route("validate-2fa")->withErrors(["otp" => "Invalid OTP"]);
        }
        return redirect()->route("2fa-enable");
    }



    public function logout()
    {

        Cache::forget('permissions_' . auth()->id());
        auth()->logout();
        session()->flush();
        return redirect()->route("login_url");
    }
}
