<?php
namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Socialite;
use DB;
use Session;
use Mail;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function adminLogin() {
        $data = [];
        $data['companyData'] = \DB::table('preference')->where(['id'=>9])->first();
        return view('auth.login',$data);
    }

    public function userLogin() {
        $data = [];
        $data['companyData'] = \DB::table('preference')->where(['id'=>9])->first();
        return view('auth.login_form',$data);
    }

    public function adminLoginPost(Request $request)
    {
        $this->validate($request, User::$login_validation_rule);
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user_id = Auth::user()->id;
            $user_type = Auth::user()->user_type;
            if($user_type==0){
                Auth::logout();
                \Session::flush();
                return redirect('/');
            }
            $updatelogin['login_at'] = date("Y-m-d H:i:s");
            DB::table('users')->where('id',$user_id)->update($updatelogin);
            return redirect('dashboard');
        }else{
            return back()->with('loginerror','your username and password are wrong.');
        }
    }

    public function logout()
    {
        Auth::logout();
        \Session::flush();

        return redirect('/');
    }
}