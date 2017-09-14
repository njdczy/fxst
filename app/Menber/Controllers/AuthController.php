<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 19:09
 */

namespace App\Menber\Controllers;

use App\Models\Menber as MenberModel;
use App\Menber\Form;
use App\Menber\Layout\Content;
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
        if (!Auth::guard('menber')->guest()) {
            return redirect(config('menber.prefix'));
        }
        return view('menber.login');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only(['menber_account', 'password','captcha']);

        $validator = Validator::make($credentials, [
            'menber_account' => 'required', 'password' => 'required','captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $credentials = $request->only(['menber_account', 'password']);

        if (Auth::guard('menber')->attempt($credentials)) {
            menber_toastr(trans('menber::lang.login_successful'));

            return redirect()->intended(config('menber.prefix'));
        }

        return Redirect::back()->withInput()->withErrors(['menber_account' => $this->getFailedLoginMessage()]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::guard('menber')->logout();

        session()->forget('url.intented');

        return redirect(config('menber.prefix'));
    }

    /**
     * User setting page.
     *
     * @return mixed
     */
    public function getSetting()
    {
        return \Menber::content(function (Content $content) {
            $content->header(trans('menber::lang.user_setting'));
            $content->body($this->settingForm()->edit(\Menber::user()->id));
        });
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(\Menber::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        return MenberModel::form(function (Form $form) {
            $form->display('username', trans('menber::lang.username'));
            $form->text('name', trans('menber::lang.name'))->rules('required');
            $form->image('avatar', trans('menber::lang.avatar'));
            $form->password('password', trans('menber::lang.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('menber::lang.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->setAction(menber_url('setting'));

            $form->ignore(['password_confirmation']);

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });

            $form->saved(function () {
                menber_toastr(trans('menber::lang.update_succeeded'));

                return redirect(menber_url('setting'));
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