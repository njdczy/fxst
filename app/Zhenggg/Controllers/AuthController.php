<?php

namespace App\Zhenggg\Controllers;

use App\Zhenggg\Facades\Front;
use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Form;
use App\Zhenggg\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
        if (!Auth::guard('front')->guest()) {
            return redirect(config('front.prefix'));
        }

        return view('front::login');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only(['admin_account', 'password','captcha']);

        $validator = Validator::make($credentials, [
            'admin_account' => 'required', 'password' => 'required','captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $credentials = $request->only(['admin_account', 'password']);

        if (Auth::guard('front')->attempt($credentials)) {
            front_toastr(trans('front::lang.login_successful'));

            return redirect()->intended(config('front.prefix'));
        }

        return Redirect::back()->withInput()->withErrors(['admin_account' => $this->getFailedLoginMessage()]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::guard('front')->logout();

        session()->forget('url.intented');

        return redirect(config('front.prefix'));
    }

    /**
     * User setting page.
     *
     * @return mixed
     */
    public function getSetting()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.user_setting'));
            $content->body($this->settingForm()->edit(Front::user()->id));
        });
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(Front::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        return Administrator::form(function (Form $form) {
            $form->display('username', trans('front::lang.username'));
            $form->text('name', trans('front::lang.name'))->rules('required');
            $form->image('avatar', trans('front::lang.avatar'));
            $form->password('password', trans('front::lang.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('front::lang.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->setAction(front_url('auth/setting'));

            $form->ignore(['password_confirmation']);

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });

            $form->saved(function () {
                front_toastr(trans('front::lang.update_succeeded'));

                return redirect(front_url('auth/setting'));
            });
        });
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }
}
