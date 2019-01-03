<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Socialite;
use DB;
use Session;

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
    public function __construct()
    {
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
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        if (Auth::user()->id) {
            $pref = \DB::table('preference')->get();
            if(!empty($pref)) {
                $prefData = AssColumn($a=$pref, $column='id');
                foreach ($prefData as $value) {
                    $prefer[$value->field] = $value->value;
                }
            }
           
            Session::put($prefer);
            $curr = \DB::table('currency')->where('id',Session::get('dflt_currency_id'))->first();
            $currency['currency_name'] = $curr->name;
            $currency['currency_symbol'] = $curr->symbol;
            Session::put($currency);

            $id = Auth::user()->id;
            $orginfo = DB::table('organisation')
            ->Join('organisationlink', 'organisation.id', '=', 'organisationlink.org_id')
            ->where(['organisationlink.user_id'=>$id,'organisationlink.organisation_default'=>1])
            ->select('organisation.*','organisationlink.last_visit_at','organisationlink.organisation_default')
            ->orderBy('organisation.created_at','DESC')
            ->first();
            if(sizeof($orginfo)>0){
                $prefer['orgid'] = $orginfo->id;
                $prefer['orgname'] = $orginfo->company_name;
                Session::put($prefer);
                return redirect()->intended('home');
            }else{
                return redirect()->intended('organisation/list');
            }         
        }
        return redirect('home');
    }


    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
