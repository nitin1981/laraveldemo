<?php

namespace App\Http\Start;

use View;
use Session;
use App\Models\Permission;
use App\Models\Role_user;
use App\Models\Permission_role;
use DB;
use Auth;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_Calendar;
class Helpers
{

	public static function has_permission($user_id, $permissions = '')
	{
		$permissions = explode('|', $permissions);
		$user_permissions = DB::table('permissions')->whereIn('name', $permissions)->get();
		$permission_id = [];
		$i = 0;
		foreach ($user_permissions as $value) {
			$permission_id[$i++] = $value->id;
		}
        $orgid = Session::get('orgid');
        if($orgid!=""){
		  $role = DB::table('role_user')->where(['user_id'=>$user_id,'org_id'=>$orgid])->first();
        }else{
          $role = DB::table('role_user')->where('user_id', $user_id)->first();
        }

		if(count($permission_id) && isset($role->role_id)){
			$has_permit = DB::table('permission_role')->where('role_id', $role->role_id)->whereIn('permission_id', $permission_id);
			return $has_permit->count();
		}
		else return 0;
	}

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function getparentuserid($id){
        $auth_id = Auth::user()->id;
        $org_id = Session::get('orgid');
        $orgdata = DB::table('organisationlink')->where(['org_id'=>$org_id,'user_id'=>$auth_id])->first();
        $prefer['dashboardview'] = isset($orgdata->dashboardview)?$orgdata->dashboardview:0;
        $prefer['fin_year_start'] = date('Y').'-04-01';
        Session::put($prefer);
        return Session::get('orgid');
    }

    function errorpage(){
        abort(406);
    }
    
    function createbasicaccounts($id){
        $orgdata = DB::table('organisation')->where('id',$id)->first();
        if($orgdata->company_country==101){
            DB::insert("INSERT INTO `item_tax_types` (`user_id`, `name`, `tax_rate`, `defaults`) VALUES
                (".$id.", 'CGST', '0', '1'),
                (".$id.", 'IGST', '0', '1'),
                (".$id.", 'SGST', '0', '1'),
                (".$id.", 'CESS', '0', '1');");
        }else{
            DB::insert("INSERT INTO `item_tax_types` (`user_id`, `name`, `tax_rate`, `defaults`) VALUES
                    (".$id.", 'Sales Tax on Imports', '0', '0'),
                    (".$id.", 'Tax Exempt', '0', '0'),
                    (".$id.", 'Tax on Purchases', '0', '0'),
                    (".$id.", 'Tax on Sales', '0', '0');");            
        }

        DB::insert("INSERT INTO `item_unit` (`user_id`, `abbr`, `name`, `inactive`) VALUES
                    (".$id.", 'Bags', 'Bags', 0),
                    (".$id.", 'Bale', 'Bale', 0),
                    (".$id.", 'Bundles', 'Bundles', 0),
                    (".$id.", 'Buckles', 'Buckles', 0),
                    (".$id.", 'Billion of units', 'Billion of units', 0),
                    (".$id.", 'Box', 'Box', 0),
                    (".$id.", 'Bottles', 'Bottles', 0),
                    (".$id.", 'Bunches', 'Bunches', 0),
                    (".$id.", 'Cans', 'Cans', 0),
                    (".$id.", 'Cubicmeter', 'Cubicmeter', 0),
                    (".$id.", 'Centimeter', 'Centimeter', 0),
                    (".$id.", 'Cubic centimeter', 'Cubic centimeter', 0),
                    (".$id.", 'Cartons', 'Cartons', 0),
                    (".$id.", 'Dozzens', 'Dozzens', 0),
                    (".$id.", 'Drums', 'Drums', 0),
                    (".$id.", 'Great gross', 'Great gross', 0),
                    (".$id.", 'Grammes', 'Grammes', 0),
                    (".$id.", 'Gross', 'Gross', 0),
                    (".$id.", 'Gross yards', 'Gross yards', 0),
                    (".$id.", 'Kilogram', 'Kilogram', 0),
                    (".$id.", 'Kiloleter', 'Kiloleter', 0),
                    (".$id.", 'Kilometer', 'Kilometer', 0),
                    (".$id.", 'Milileter', 'Milileter', 0),
                    (".$id.", 'Meter', 'Meter', 0),
                    (".$id.", 'Metric ton', 'Metric ton', 0),
                    (".$id.", 'Number', 'Number', 0),
                    (".$id.", 'Packes', 'Packes', 0),
                    (".$id.", 'Packets', 'Packets', 0),
                    (".$id.", 'Piece', 'Piece', 0),
                    (".$id.", 'Quintal', 'Quintal', 0),
                    (".$id.", 'Roll', 'Roll', 0),
                    (".$id.", 'Sets', 'Sets', 0),
                    (".$id.", 'Sqaure feet', 'Sqaure feet', 0),
                    (".$id.", 'Square meter', 'Square meter', 0),
                    (".$id.", 'Square yard', 'Square yard', 0),
                    (".$id.", 'Tonnes', 'Tonnes', 0),
                    (".$id.", 'Thousands', 'Thousands', 0)");
        
        $exempttax = DB::table("item_tax_types")->where(['user_id'=>$id,'name'=>'Tax Exempt'])->first();
        $purchtax = DB::table("item_tax_types")->where(['user_id'=>$id,'name'=>'Tax on Purchases'])->first();
        $salestax = DB::table("item_tax_types")->where(['user_id'=>$id,'name'=>'Tax on Sales'])->first();
        DB::insert("INSERT INTO `income_expense_categories` (`user_id`, `name`, `type`, `code`, `description`, `tax`, `account_type`) VALUES
            (".$id.", 'Sales', 'income', '200', 'Incomes earned from the sales of products and/or services are included', ".$salestax->id.", 20),
            (".$id.", 'Other Revenue', 'income', '260', 'Apart from general incomes, any additional income that is generated by the business is entered.', ".$salestax->id.", 20),
            (".$id.", 'Interest Income', 'income', '270', 'Find the difference between revenue from the asset of the bank and expenses from paying the liabilities, your net income from interest is here.', ".$exempttax->id.", 20),
            (".$id.", 'Cost of Goods Sold', 'expense', '310', 'Cost of Goods Sold or simply COGS is the amount that is incurred to make the products, material and all the associated expenses.', ".$purchtax->id.", 11),
            (".$id.", 'Advertising', 'expense', '400', 'With the hope to create brand awareness and/or to increase the sales, how much do you spend on the advertizing?', ".$purchtax->id.", 12),
            (".$id.", 'Bank Fees', 'expense', '404', 'Maintain a bank account leads to some fees form bank on your account, credit card and many other facilities offered by the bank.', ".$exempttax->id.", 12),
            (".$id.", 'Cleaning', 'expense', '408', 'Keeping your premises clean and tidy, how much have you spent on your cleaning needs is tracked here.', ".$purchtax->id.", 12),
            (".$id.", 'Consulting & Accounting', 'expense', '412', 'Different form that of advertizing, these are expenses associated with consultants and accountants.', ".$purchtax->id.", 12),
            (".$id.", 'Depreciation', 'expense', '416', 'Assets of the business have their own life and how much have you reap from these assets are tracked here.', ".$exempttax->id.", 12),
            (".$id.", 'Entertainment', 'expense', '420', 'Not deductable form the income tax purpose, track expenses made on the entertainment purpose here.', ".$exempttax->id.", 12),
            (".$id.", 'Freight & Courier', 'expense', '425', 'Courier and freights are two of those many recurring expenses of the business that are included in this entry.', ".$purchtax->id.", 12),
            (".$id.", 'General Expenses', 'expense', '429', 'Operating a business is full of general expenses from rent and insurance to many others that are carried here.', ".$purchtax->id.", 12),
            (".$id.", 'Insurance', 'expense', '433', 'Organizations have some precious assets that are necessarily insured, track the amount spent on insurance of assets. ', ".$purchtax->id.", 12),
            (".$id.", 'Interest Expense', 'expense', '437', 'From credit cards to business bank accounts and authorities, all your interest expenses can be calculated from this account.', ".$exempttax->id.", 12),
            (".$id.", 'Legal expenses', 'expense', '441', 'Organizations may have some legal matter that is enforceable by the law; expenses during the legal issues from lawyer fees to others are included.', ".$purchtax->id.", 12),
            (".$id.", 'Light, Power, Heating', 'expense', '445', 'Expenses that are related to utilities, lighting, heating and powering of the premises.', ".$purchtax->id.", 12),
            (".$id.", 'Motor Vehicle Expenses', 'expense', '449', 'Company and its motor vehicles lead to some expenses for the business are included.', ".$purchtax->id.", 12),
            (".$id.", 'Office Expenses', 'expense', '453', 'General office expenses that are made to improvise the office are included in this office expense account', ".$purchtax->id.", 12),
            (".$id.", 'Printing & Stationery', 'expense', '461', 'Office expense or simply business expenses that are lead by printing and stationery supplies are tracked in this account.', ".$purchtax->id.", 12),
            (".$id.", 'Rent', 'expense', '469', 'Payments made so as to lease the building and/or a particular space.', ".$purchtax->id.", 12),
            (".$id.", 'Repairs and Maintenance', 'expense', '473', 'Assets have their own life, machineries breakdown and repairs and maintenance charges are common to take place, track how much it cost to bring the machineries back to its working condition.', ".$purchtax->id.", 12),
            (".$id.", 'Wages and Salaries', 'expense', '477', 'Payments made to the employees of the company in exchange of services taken from them.', ".$exempttax->id.", 12),
            (".$id.", 'Superannuation', 'expense', '478', 'Superannuation on the employee including pensions is tracked in this account.', ".$exempttax->id.", 12),
            (".$id.", 'Subscriptions', 'expense', '485', 'Expenses that are lead by magazines, professional bodies and authorities are tracked.', ".$purchtax->id.", 12),
            (".$id.", 'Telephone & Internet', 'expense', '489', 'How much does your business make expenses on telephone calls, text messages and also form those that are associated with internet connection', ".$purchtax->id.", 12),
            (".$id.", 'Travel - National', 'expense', '493', 'Domestic travels can never be done without expenses, check out how much your traveling has cost.', ".$purchtax->id.", 12),
            (".$id.", 'Travel - International', 'expense', '494', 'Traveling to different nations for business purposes, meetings, seminars and others, all the expenses international traveling are here.', ".$exempttax->id.", 12),
            (".$id.", 'Bank Revaluations', 'expense', '497', 'Change in foreign exchange rates causes revaluation of your bank account, see here', ".$exempttax->id.", 12),
            (".$id.", 'Unrealised Currency Gains', 'expense', '498', 'Foreign exchange rates are fluctuating in nature, you can have some unrealized gain from this even before completion of transaction.', ".$exempttax->id.", 12),
            (".$id.", 'Realised Currency Gains', 'expense', '499', 'Currency exchange rates can lead to some realized currency gains, check out here.', ".$exempttax->id.", 12),
            (".$id.", 'Income Tax Expense', 'expense', '505', 'Expenses that are directly or indirectly associated with income tax.', ".$exempttax->id.", 12),
            (".$id.", 'Accounts Receivable', 'income', '610', 'Outstanding invoices that are delivered to the clients but are yet to be received in cash.', ".$exempttax->id.", 2),
            (".$id.", 'Prepayments', 'income', '620', 'Prepayments are those amounts that are being paid in advance; products/service is yet to be exchanged.', ".$exempttax->id.", 2),
            (".$id.", 'Inventory', 'income', '630', 'It includes the actual value of tracked items available for resale.', ".$exempttax->id.", 4),
            (".$id.", 'Office Equipment', 'income', '710', 'Owned and controlled by the business, all the Office equipment related expenses are tracked in this account. ', ".$purchtax->id.", 3),
            (".$id.", 'Less Accumulated Depreciation on Office Equipment', 'income', '711', 'Based on the useful life, the total amount of office equipment cost that is consumed by a particular entity.', ".$exempttax->id.", 3),
            (".$id.", 'Computer Equipment', 'income', '720', 'Owned and controlled by the business, it includes all the computer and peripheral related expenses', ".$purchtax->id.", 3),
            (".$id.", 'Less Accumulated Depreciation on Computer Equipment', 'income', '721', 'Based on the useful life, the total amount of computer equipment cost that has been consumed by the business during a period of time.', ".$exempttax->id.", 3),
            (".$id.", 'Accounts Payable', 'expense', '800', 'Amount for which the invoices are already received by the business but payments are yet to be made.', ".$exempttax->id.", 15),
            (".$id.", 'Unpaid Expense Claims', 'expense', '801', 'Claims of unpaid amounts that are generally made by stakeholders or employees.', ".$exempttax->id.", 15),
            (".$id.", 'Wages Payable', 'expense', '803', 'This account enables you to maintain separate accounts for employee, wages,payable amounts and so on. Automatically updates this account for payroll entries created using Payroll and will store the payroll amount to be paid to the employee for the pay run', ".$exempttax->id.", 15),
            (".$id.", 'Sales Tax', 'expense', '820', 'At the end of the tax period, it is this account that should be used to code against either the \'refunds from\' or \'payments to\' your tax authority that will appear. The balance in this account represents Sales Tax owing to or from your tax authority', ".$exempttax->id.", 15),
            (".$id.", 'Employee Tax Payable', 'expense', '825', 'This account includes the amount of tax that is deducted from wages or salaries paid to employees and are yet to be paid.', ".$exempttax->id.", 15),
            (".$id.", 'Superannuation Payable', 'expense', '826', 'The amount of superannuation that are yet to be paid.', ".$exempttax->id.", 15),
            (".$id.", 'Income Tax Payable', 'expense', '830', 'The amounts of income tax that are yet to be paid, also resident withholding tax paid on interest received are included.', ".$exempttax->id.", 15),
            (".$id.", 'Historical Adjustment', 'expense', '840', 'For accountant adjustments from the past.', ".$exempttax->id.", 15),
            (".$id.", 'Suspense', 'expense', '850', 'An entry that allows an unknown transaction to be entered, so the accounts can still be worked on in balance and the entry can be dealt with later.', 9, 15),
            (".$id.", 'Rounding', 'expense', '860', 'An entry of adjustment.', ".$exempttax->id.", 15),
            (".$id.", 'Tracking Transfers', 'expense', '877', 'Transfers that are made between tracking categories', ".$exempttax->id.", 15),
            (".$id.", 'Owner A Drawings', 'expense', '880', 'Withdrawals made by the owners of the business.', ".$exempttax->id.", 15),
            (".$id.", 'Owner A Funds Introduced', 'expense', '881', 'Funds that are directly contributed by the owner of the business.', ".$exempttax->id.", 15),
            (".$id.", 'Loan', 'expense', '900', 'Money that has been borrowed from a creditor', ".$exempttax->id.", 17),
            (".$id.", 'Retained Earnings', 'income', '960', 'Do not Use', ".$exempttax->id.", 8),
            (".$id.", 'Owner A Share Capital', 'income', '970', 'The actual value of shares that are being purchased by the shareholders of the business', ".$exempttax->id.", 8);");
    }

    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/credentials.json');
        $client->setAccessType('offline');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $accessToken = $client->authenticate($authCode);
        print_r($accessToken);die();
        $tokenPath = $_SERVER['DOCUMENT_ROOT'].'/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}
