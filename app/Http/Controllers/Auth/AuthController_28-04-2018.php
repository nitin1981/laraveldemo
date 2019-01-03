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
        if(isset($_GET['error'])){
            return redirect()->intended('login')->withErrors(['status' => $_GET['error_description']]);
        }
        try {
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
                $currency['country_id'] = 101;
                Session::put($currency);

                $id = Auth::user()->id;
                DB::table('users')->where('id',$id)->update(array('login_at'=>date('Y-m-d H:i:s')));
                $orginfo = DB::table('organisation')
                ->Join('organisationlink', 'organisation.id', '=', 'organisationlink.org_id')
                ->where(['organisationlink.user_id'=>$id,'organisationlink.organisation_default'=>1])
                ->select('organisation.*','organisationlink.last_visit_at','organisationlink.organisation_default')
                ->orderBy('organisation.created_at','DESC')
                ->first();
                if(sizeof($orginfo)>0){
                    $countrydata = \DB::table('countries')->where('id',$orginfo->company_country)->first();
                    $company_country = $countrydata->country;
                    $prefer['company_name'] = $orginfo->company_name;
                    $prefer['company_street'] = $orginfo->company_street;
                    $prefer['company_city'] = $orginfo->company_city;
                    $prefer['company_state'] = $orginfo->company_state;
                    $prefer['company_country_id'] = $company_country;
                    $prefer['company_zipCode'] = $orginfo->company_zipcode;
                    $prefer['company_picture'] = $orginfo->picture;
                    $prefer['orgid'] = $orginfo->id;
                    $prefer['orgname'] = $orginfo->company_name;
                    Session::put($prefer);

                    $curr = \DB::table('currency')->where(['user_id'=>$orginfo->id,'curr_default'=>1])->first();
                    if($curr!=""){
                        $currency['currency_name'] = $curr->name;
                        $currency['currency_symbol'] = $curr->name;
                        Session::put($currency);
                    }
                    if(Session::get('invite_user_id')!=""){
                        if(Session::get('invite_type')=="accept"){
                            return redirect()->intended('invitation/accept/'.Session::get('invite_user_id'));
                        }else{
                            return redirect()->intended('invitation/reject/'.Session::get('invite_user_id'));
                        }
                    }else{
                        return redirect()->intended('organisations');
                    }
                }else{
                    return redirect()->intended('organisations');
                }         
            }
        } catch (Exception $e) {
            return redirect('auth/$provider');
        }
        return redirect()->intended('organisations');
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
        $data = User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);

        $user_id = $data->id;
        $user = User::findOrFail($user_id);
        /*Send Confirmation mail*/
        Mail::send('emails.welcome', ['user' => $user], function ($m) use ($user) {
         $m->to($user->email, $user->real_name)->subject('Registration Success!');
        });

        /*Start to create personal account*/
        $dataorg['company_name'] = "Personal Account";
        $dataorg['company_email'] = $user->email;
        $dataorg['company_phone'] = '';
        $dataorg['organisation_work'] = "Personal";
        $dataorg['company_country'] = 101;
        $dataorg['company_currency'] = 101;
        $dataorg['access_type'] = 1;
        $dataorg['status'] = 1;
        $dataorg['created_by'] = $user_id;
        $dataorg['created_at'] = date("Y-m-d H:i:s");
        
        $id = DB::table('organisation')->insertGetId($dataorg);
        /*Start to create charts of accounts*/

        $role_data['user_id'] = $user_id;
        $role_data['role_id'] = 1;
        $role_data['org_id'] = $id;
        DB::table('role_user')->insert($role_data);

        $parent_id = $this->helper->createbasicaccounts($id);
        /*End to create charts of accounts*/

        /*Start to create cash in hand account*/
        $bdata['account_name'] = "Cash In Hand";
        $bdata['account_type_id'] = 4;
        $bdata['account_no'] = '123';
        $bdata['user_id'] = $id;
        $bdata['created_by'] = $user_id;
        $bdata['default_account'] = 1;
        DB::table('bank_accounts')->insertGetId($bdata);

        /*Start to create payment method*/
        $bmdata['name'] = "Cash";
        $bmdata['user_id'] = $id;
        DB::table('payment_terms')->insertGetId($bmdata);

        $bmdata['name'] = "Bank";
        $bmdata['user_id'] = $id;
        DB::table('payment_terms')->insertGetId($bmdata);
        
        if(!empty($id)) {
            $data2['org_id'] = $id;
            $data2['user_id'] = $user_id;
            $data2['last_visit_at'] = date("Y-m-d H:i:s");
            $data2['organisation_default'] = 1;

            $data3['organisation_default'] = 0;
            DB::table('organisationlink')->where('user_id',$user_id)->update($data3);
            DB::table('organisationlink')->insert($data2);

            /*Start Add default currency*/
            $currencydata = DB::table('countries')->where('id',101)->first();
            $datacurr['name'] = $currencydata->code;
            $datacurr['symbol'] = $currencydata->symbol;
            $datacurr['user_id'] = $id;
            $datacurr['curr_id'] = $currencydata->id;
            $datacurr['curr_default'] = 1;
            $id = \DB::table('currency')->insertGetId($datacurr);
            /*End Add default currency*/

        }
        /*End to create personal account*/
        
        return $data;
    }
}
