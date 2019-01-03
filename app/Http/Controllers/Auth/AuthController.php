<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Start\Helpers;
use Auth;
use Socialite;
use DB;
use Session;
use Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Helpers $helper)
    {
        $this->helper = $helper;
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'real_name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 1,
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */

    public function handleProviderCallback($provider)
    {
        if(isset($_GET['error_code'])){
            return redirect()->intended('login')->withErrors(['status' => $_GET['error_message']]);
        }
        try {
            $user = Socialite::driver($provider)->user();
            $authUserCount = User::where('email', $user->email)->count();
            $updateuser = array();
            if($authUserCount>0){
                $updateuser['avatar'] = $user->avatar;
                $updateuser['login_at'] = date('Y-m-d H:i:s');
                User::where('email', $user->email)->update($updateuser);

                $empdata['photo'] = $user->avatar;
                $empId = DB::table('employees')->where('email',$user->email)->update($empdata);

                $authUser = User::where('email', $user->email)->first();
                Auth::login($authUser, true);
                if(Auth::user()->id) {
                    $url = "https://apiv2.shiprocket.in/v1/external/auth/login";
                    $apilogin = json_encode(array(
                        'email' => env('SHIPROCKET_API_EMAIL'),
                        'password' => env('SHIPROCKET_API_PASSWORD')
                    ));
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl, CURLOPT_POSTFIELDS,$apilogin);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    $result = curl_exec($curl);
                    curl_close($curl);
                    $result = json_decode($result, true);
                    $shiprocket['shiprocket_token'] = $result['token'];
                    Session::put($shiprocket);

                    return redirect()->intended('dashboard');
                    $permissions_data = DB::select(DB::raw("SELECT * FROM admin_permissions WHERE admin_user_id = $user->id"));
                    $permissions = array();
                    foreach($permissions_data as $permrow){
                        if($permrow->permission==1 && $permrow->module_name=="user"){
                            return redirect('/dashboard');
                        }else if($permrow->permission==1 && $permrow->module_name=="tools"){
                            return redirect('/dailyblogview');
                        }else if($permrow->permission==1 && $permrow->module_name=="merrchant_leads"){
                            return redirect('/raletta_adwords/1/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="coworking_leads"){
                            return redirect('/raletta_adwords/2/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="lakeview_leads"){
                            return redirect('/raletta_adwords/3/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="palmindore_leads"){
                            return redirect('/raletta_adwords/4/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="raletta_services"){
                            return redirect('/raletta_adwords/5/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="raletta_gread"){
                            return redirect('/raletta_adwords/6/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="employee_roles"){
                            return redirect('/manageadmin');
                        }else if($permrow->permission==1 && $permrow->module_name=="organisation"){
                            return redirect('/organisations');
                        }else if($permrow->permission==1 && $permrow->module_name=="mohini_leads"){
                            return redirect('/raletta_adwords/7/1');
                        }else if($permrow->permission==1 && $permrow->module_name=="remindar"){
                            return redirect('/reminderlist');
                        }
                    }
                }else{
                    return redirect()->intended('404');
                }
            }else{
                return redirect()->intended('404');
            }
        } catch (Exception $e) {
            return redirect('auth/$provider');
        }
        return redirect()->intended('/');
    }


    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
}
