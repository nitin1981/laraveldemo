<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Bank;
use App\User;
use App\Http\Start\Helpers;
use App\Model\Organisation;
use DB;
use Excel;
use Validator;
use Input;
use Auth;
use Session;
class ApiController extends Controller
{
    public function __construct(Bank $bank, Organisation $Organisation, Helpers $helper){
        $this->bank = $bank;
        $this->helper = $helper;
        $this->organisation = $Organisation;
    }

    /**
     * Display a Check login form
     *
     * @return \Illuminate\Http\Response
     */

    public function login($email,$password)
    {
        if($email!="" && $password!=""){
            if(Auth::attempt(['email' => $email, 'password' => $password])){
                $userdata = User::where(['email'=>$email,'password'=>$password])->first();
                echo json_encode(array(array('status'=>'success','message'=>'Login Success','data'=>$userdata)));
            }else{
                echo json_encode(array(array('status'=>'failed','message'=>'Invalid Login Details')));
            }
        }else{
            echo json_encode(array(array('status'=>'failed','message'=>'Invalid Login Details')));
        }
    }

    /**
     * Display a auto login form
     *
     * @return \Illuminate\Http\Response
     */

    public function autologin($email,$password)
    {
        if($email!="" && $password!=""){
            if(Auth::attempt(['email' => $email, 'password' => $password])){
                return redirect()->intended('home');
            }else{
                echo json_encode(array(array('status'=>'failed','message'=>'Invalid Login Details')));
            }
        }else{
            echo json_encode(array(array('status'=>'failed','message'=>'Invalid Login Details')));
        }
    }

    public function signup()
    {
        if(isset($_REQUEST['email'])){
            $usercount = User::where('email', $_REQUEST['email'])->count();
            if($usercount==0){
                $data['real_name'] = $_REQUEST['full_name'];
                $data['phone'] = $_REQUEST['phone'];
                $data['email'] = $_REQUEST['email'];
                $data['password'] = $_REQUEST['password'];
                $data['activation_code'] = md5($_REQUEST['email']);
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['country_id'] = $_REQUEST['country_id'];
                $user_id = DB::table('users')->insertGetId($data);
                $user = User::where('id', $user_id)->first();
                echo json_encode(array(array('status'=>'success','message'=>'Register success','data'=>$user)));
            }else{
                echo json_encode(array(array('status'=>'failed','message'=>'Email id already exists')));
                }
        }else{
            echo json_encode(array(array('status'=>'failed','message'=>'Invalid Login Details')));
        }
    }

    public function getCountries(){
        $countries = DB::table('countries')->where('currency','!=','')->get();
        echo json_encode(array(array('countries'=>$countries)));die();
    }

    public function gettoken(){
        echo csrf_token();
    }
}
