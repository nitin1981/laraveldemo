<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Model\Orders;
use App\Model\Sales;
use App\Model\Shipment;
use DB;
use PDF;
use Mail;
use Razorpay\Api\Api;
use Excel;
use Session;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Calendar;
use App\Http\Start\Helpers;
class AdminPanelController extends Controller
{
    public function __construct(Helpers $helper) {
        $this->helper = $helper;
    }

    public function index()
    {
        $auth_id = Auth::user()->id;
        $data['user_id'] = $auth_id;
        $data['menu'] = 'dashboard';
        $data['sub_menu'] = 'dashboard';
        return view('admin.dashboard',$data);
    }

    public function managecorporates()
    {
        $auth_id = Auth::user()->id;
        $data['user_id'] = $auth_id;
        $data['menu'] = 'corporateslist';
        $data['sub_menu'] = 'corporateslist';
        $data['corporates'] = DB::table('corporate_banks')->where('type', 1)->get();
        return view('admin.corporateslist',$data);
    }

    public function savecorporate(Request $request)
    {
        $auth_id = Auth::user()->id;
        $randpassword = rand();
        $userdata['real_name'] = $request->corporatename;
        $userdata['email'] = $request->corporatemail;
        $userdata['password'] = \Hash::make($randpassword);
        $userdata['phone'] = $request->corporatephone;
        $userdata['user_type'] = 2;
        $userid = DB::table('users')->insertGetId($userdata);

        $corpodata['name'] = $request->corporatename;
        $corpodata['email'] = $request->corporatemail;
        $corpodata['phone'] = $request->corporatephone;
        $corpodata['type'] = 1;
        $corpodata['unique_id'] = $request->uniqueid;
        $corpodata['user_id'] = $userid;
        $userid = DB::table('corporate_banks')->insertGetId($corpodata);
        \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("corporates");
    }

    public function updatecorporate(Request $request)
    {
        $auth_id = Auth::user()->id;
        $corpid = $request->corporate_id;
        $user_id = $request->user_id;
        $userdata['real_name'] = $request->corporatename;
        $userdata['email'] = $request->corporatemail;
        $userdata['phone'] = $request->corporatephone;
        $userdata['user_type'] = 2;
        DB::table('users')->where('id',$user_id)->update($userdata);

        $corpodata['name'] = $request->corporatename;
        $corpodata['email'] = $request->corporatemail;
        $corpodata['phone'] = $request->corporatephone;
        $corpodata['type'] = 1;
        $corpodata['unique_id'] = $request->uniqueid;
        DB::table('corporate_banks')->where('id',$corpid)->update($corpodata);
        return redirect()->intended("corporates");
    }

    public function managebanks()
    {
        $auth_id = Auth::user()->id;
        $data['user_id'] = $auth_id;
        $data['menu'] = 'corporateslist';
        $data['sub_menu'] = 'corporateslist';
        $data['banks'] = DB::table('corporate_banks')->where('type', 2)->get();
        return view('admin.bankslist',$data);
    }

    public function savebank(Request $request)
    {
        $auth_id = Auth::user()->id;
        $randpassword = rand();
        $userdata['real_name'] = $request->bankname;
        $userdata['email'] = $request->bankmail;
        $userdata['password'] = \Hash::make($randpassword);
        $userdata['phone'] = $request->bankphone;
        $userdata['user_type'] = 3;
        $userid = DB::table('users')->insertGetId($userdata);

        $bankdata['name'] = $request->bankname;
        $bankdata['email'] = $request->bankmail;
        $bankdata['phone'] = $request->bankphone;
        $bankdata['type'] = 2;
        $bankdata['unique_id'] = $request->uniqueid;
        $bankdata['user_id'] = $userid;
        $userid = DB::table('corporate_banks')->insertGetId($bankdata);
        \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("banks");
    }

    public function updatebank(Request $request)
    {
        $auth_id = Auth::user()->id;
        $bankid = $request->bank_id;
        $user_id = $request->user_id;
        $userdata['real_name'] = $request->bankname;
        $userdata['email'] = $request->bankmail;
        $userdata['phone'] = $request->bankphone;
        $userdata['user_type'] = 3;
        DB::table('users')->where('id',$user_id)->update($userdata);

        $bankdata['name'] = $request->bankname;
        $bankdata['email'] = $request->bankmail;
        $bankdata['phone'] = $request->bankphone;
        $bankdata['type'] = 2;
        $bankdata['unique_id'] = $request->uniqueid;
        DB::table('corporate_banks')->where('id',$bankid)->update($bankdata);
        return redirect()->intended("banks");
    }

    public function vendorrequest(){
        $auth_id = Auth::user()->id;
        $corporate = DB::table("corporate_banks")->where('user_id',$auth_id)->first();
        $data['user_id'] = $auth_id;
        $data['menu'] = 'createform';
        $data['sub_menu'] = 'createform';
        if(isset($corporate->id)){
            $data['requestlists'] = DB::table('earlypayment_requests')->leftjoin('organisation','organisation.id','=','earlypayment_requests.orgid')->where('corp_id',$corporate->id)->select('earlypayment_requests.*','organisation.company_name','organisation.company_email','organisation.company_phone')->get();
        }
        return view('admin.vendor_request_list',$data);
    }

    public function updaterequeststatus(Request $request){
        $data['status'] = $request->status;
        DB::table('earlypayment_requests')->where('id',$request->requestid)->update($data);
        if($request->status==1){
            \Session::flash('success',"Request Accepted");
        }else{
            \Session::flash('success',"Request Decline");
        }
        return redirect()->intended("vendorrequest");
    }

    public function getInvoices(){
        $auth_id = Auth::user()->id;
        
    }
}
