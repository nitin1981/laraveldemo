<?php  

function d($var,$a=false)
{
	  echo "<pre>";
	  print_r($var);
	  echo "</pre>";
	  if($a)exit;
}

function selectDatabase()
{
        $host = \Session::get('host');
        $db_user = \Session::get('db_user');
        $db_password = \Session::get('db_password');
        $db_name = \Session::get('db_name');
        
        if (!empty($host) && !empty($db_user) && !empty($db_name) ) {

            selectDatabase1($host,$db_user,$db_password,$db_name);
        }
}


function selectDatabase1($host,$db_user,$db_password,$db_name)
{
    
    \Config::set('database.connections.mysql.host', $host);
    \Config::set('database.connections.mysql.username', $db_user);
    \Config::set('database.connections.mysql.password', $db_password);
    \Config::set('database.connections.mysql.database', $db_name);

    \Config::set('database.default', 'mysql');
     \DB::reconnect('mysql');
}


function objectToArray($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = objectToArray($value);
        }
        return $result;
    }
    return $data;
}

function dbConnect($host,$db_user,$db_password,$db_name)
{
    error_reporting(0);
    $mysqli = new mysqli($host, $db_user, $db_password, $db_name);

    /* check if server is alive */
    if ($mysqli->ping()) {
        return true;
    } else {
        return false;
    }
    /* close connection */
    $mysqli->close();
}

function setDbConnect($db_id)
{
    $companyData = \DB::table('company')->where('company_id', $db_id)->first();
    $companyData = objectToArray($companyData);
        
    selectDatabase1($companyData['host'], $companyData['db_user'], $companyData['db_password'], $companyData['db_name']);
}


/*
 * Function to Encrypt user sensitive data for storing in the database
 *
 * @param string    $value      The text to be encrypted
 * @param           $encodeKey  The Key to use in the encryption
 * @return                      The encrypted text
 */
function encryptIt($value) {
    //$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
    $plaintext = 'Li1KUqJ4tgX14dS,A9ejk?uwnXaNSD@fQ+!+D.f^`Jy';
    $key = 'Li1KUqJ4tgX14dS,A9ejk?uwnXaNSD@fQ+!+D.f^`Jy';
    $cipher = "aes-128-gcm";
    if (in_array($cipher, openssl_get_cipher_methods()))
    {
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
        //store $cipher, $iv, and $tag for decryption later
        $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
        return($original_plaintext);
    }
}

/*
 * Function to decrypt user sensitive data for displaying to the user
 *
 * @param string    $value      The text to be decrypted
 * @param           $decodeKey  The Key to use for decryption
 * @return                      The decrypted text
 */
function decryptIt($value) {
    // The decodeKey MUST match the encodeKey
    $decodeKey = 'Li1KUqJ4tgX14dS,A9ejk?uwnXaNSD@fQ+!+D.f^`Jy';
    $decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($decodeKey), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($decodeKey))), "\0");
    return($decoded);
    $c = base64_decode($value);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
        return($original_plaintext);
    }
}

function emptyDatabase()
{
    foreach (\DB::select('SHOW TABLES') as $table) {
        $table_array = get_object_vars($table);
        
        if(!empty($table_array)) {
            \Schema::drop($table_array[key($table_array)]);
        }
    }
}

function uniqueMultidimArray($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
}

function getDefaultLocation()
{
    $loc_id = \DB::table('location')->select('loc_code')->where('inactive', '=', 1)->first();
    
    return $loc_id->loc_code;
}

function AssColumn($a=array(), $column='id')
{
    $two_level = func_num_args() > 2 ? true : false;
    if ( $two_level ) $scolumn = func_get_arg(2);

    $ret = array(); settype($a, 'array');
    if ( false == $two_level )
    {   
        foreach( $a AS $one )
        {   
            if ( is_array($one) ) 
                $ret[ @$one[$column] ] = $one;
            else
                $ret[ @$one->$column ] = $one;
        }   
    }   
    else
    {   
        foreach( $a AS $one )
        {   
            if (is_array($one)) {
                if ( false==isset( $ret[ @$one[$column] ] ) ) {
                    $ret[ @$one[$column] ] = array();
                }
                $ret[ @$one[$column] ][ @$one[$scolumn] ] = $one;
            } else {
                if ( false==isset( $ret[ @$one->$column ] ) )
                    $ret[ @$one->$column ] = array();

                $ret[ @$one->$column ][ @$one->$scolumn ] = $one;
            }
        }
    }
    return $ret;
}

function formatDate($value)
{
    $pref = \DB::table('preference')->where('category', 'preference')->get();
    $prefData = AssColumn($a=$pref, $column='id');

    if($prefData[2]->value == '0') {
        //yyyy-mm-dd
        $format ='Y'.$prefData[3]->value.'m'.$prefData[3]->value.'d'; 
        $date = date($format, strtotime($value));
    }elseif($prefData[2]->value == '1') {
        //dd-mm-yyyy
        $format ='d'.$prefData[3]->value.'m'.$prefData[3]->value.'Y'; 
        $date = date($format, strtotime($value));
    }elseif($prefData[2]->value == '2') {
        //mm-dd-yyyy
        $format ='m'.$prefData[3]->value.'d'.$prefData[3]->value.'Y'; 
        $date = date($format, strtotime($value));
    }elseif($prefData[2]->value == '3') {
        //D-M-yyyy
        $format ='d'.$prefData[3]->value.'M'.$prefData[3]->value.'Y'; 
        $date = date($format, strtotime($value));
    }elseif($prefData[2]->value == '4') {
        //yyyy-mm-D
        $format ='Y'.$prefData[3]->value.'M'.$prefData[3]->value.'d'; 
        $date = date($format, strtotime($value));
    }

    return $date;

}

function DbDateFormat($value){
    $preference = \Session::get('date_format_type');
    $data = str_replace(['/','.',' ','-'],['-','-','-','-'],$preference);
    $data = explode('-', $data);
    $mm = $data[0];
    if($mm=='mm'){
        $dateInfo = str_replace(['/','.',' ','-'],['-','-','-','-'],$value);
        $datas = explode('-', $dateInfo);
        $month = $datas[0];
        $day = $datas[1];
        $year = $datas[2];
        $value = $day.'-'.$month.'-'.$year;
    }else{
       $value = str_replace(['/','.',' ','-'],['-','-','-','-'],$value);
   }
       $value = date('Y-m-d',strtotime($value));
    
     return $value;
}

function getDestinatin($loc)
{
    $location = \DB::table('location')
        ->where('loc_code', $loc)
        ->select('location_name')
        ->first();
    return $location->location_name;
}

function getSupplier($sid)
{
    $supplier = \DB::table('suppliers')
        ->where('supplier_id', $sid)
        ->select('supp_name')
        ->first();
    return $supplier->supp_name;
}

function getCustomer($cid){
    $customer = \DB::table('debtors_master')
        ->where('debtor_no', $cid)
        ->select('name')
        ->first();
    return $customer->name;
}

function getItemName($stock_id)
{
    $location = \DB::table('item_code')->where('stock_id', $stock_id)->select('description')->first();
    return $location->description;
}

function getItemQtyByLocationName($location_code,$stock_id)
{
    
        $qty = DB::table('stock_moves')
                            ->where(['loc_code'=>strtoupper($location_code),'stock_id'=>$stock_id])
                            ->sum('qty');
        if(empty($qty)){
            $qty = 0;
        }
        return $qty;
}

function getTransactionType($code)
{
    $type = '';
    if($code == PURCHINVOICE){
        $type = 'Stock In By Purchase';
    }
    elseif($code == SALESINVOICE){
        $type = 'Stock Out By Sale';
    }
    elseif($code == STOCKMOVEIN){
        $type = 'Stock In By Transfer';
    }
    elseif($code == STOCKMOVEOUT){
        $type = 'Stock Out By Transfer';
    }

        return $type;
}

function getShipmentStatus($sid)
{
    $info = \DB::table('shipment')->where('id', $sid)->select('status')->first();
    if($info->status == 1){
        $status = 'Delivered';
    }else{
       $status = 'Packed'; 
    }
    return $status;
}

function backup_tables($host,$user,$pass,$name,$tables = '*')
{
    try {
        $con = mysqli_connect($host,$user,$pass,$name);
    }catch(Exception $e){
        
    }
    //mysqli_select_db($name,$link);

    if (mysqli_connect_errno())
    {
        \Session::flash('fail', "Failed to connect to MySQL: ".mysqli_connect_error());
        return 0;
    }
    
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($con, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    
    //cycle through
    $return = '';
    foreach($tables as $table)
    {
        $result = mysqli_query($con, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        
        
        //$return.= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $row2[1]).";\n\n";
        
        for ($i = 0; $i < $num_fields; $i++) 
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j < $num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j < ($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }

        $return.="\n\n\n";
    }
    
    $backup_name = date('Y-m-d-His').'.sql';
    //save file
    $handle = fopen(storage_path("laravel-backups").'/'.$backup_name,'w+');
    fwrite($handle,$return);
    fclose($handle);

    return $backup_name;
}

    function getAvailableQtyByLocation($stockid,$loc){
        $data = \DB::select("SELECT SUM(`qty`) as qty FROM `stock_moves` WHERE `loc_code`='$loc' AND `stock_id`= '$stockid'");
        return $data[0]->qty;
    }

function getTotalPaidAmountByOrder($order_reference,$order_no){
    $invoiceInfo = \DB::select("SELECT SUM(total) as invoiceAmount,SUM(paid_amount) as paidAmount FROM sales_orders WHERE order_reference_id = '$order_no'");
    $dueAmount = ($invoiceInfo[0]->invoiceAmount - $invoiceInfo[0]->paidAmount);
    //d($dueAmount,1);
    return $dueAmount;
}

function makeExpenseReportGraph($datas){
    $graphData = [];
    $i=0;$j=0;
    foreach($datas as $key => $value){
        $graphData[$i][$j++] = $key;
        $sm = 0;
        foreach($value as $v){
            $sm += abs($v);
        }
        $graphData[$i][$j++] = $sm;
        $j = 0;
        $i++;
    }
    return $graphData;
}

    function previousDate(){
        $preDate = date("Y-m-d", strtotime("-5 month")); 
        $preday = date("d", strtotime($preDate))-1;
        $newdate = strtotime ("-$preday day",strtotime($preDate ));
        $newdate = date('Y-m-j',$newdate );
        return $newdate;
    }

    function getLastSixMonthName(){
        $data = array();
        for ($j = 5; $j >= 0; $j--) {
            $data[5-$j] = date("F-Y", strtotime(" -$j month"));
        }
        return $data;
    }

    function getLastSixMonthNameNew(){
        $data = array();
        for ($j = 5; $j >= 0; $j--) {
            $data[5-$j] = date("F", strtotime(" -$j month"));
        }
        return $data;
    }

    function getLastSixMonthNumber(){
        $data = array();
        for ($j = 5; $j >= 0; $j--) {
            $data[5-$j] = date("n-Y", strtotime(" -$j month"));
        }
        return $data;
    }

    function getExpenseArrayList($sixMonthExpense,$getLastSixMonthNumber){

        $data_map = [];
        foreach ($sixMonthExpense as $key => $value) {
           $data_map[$value->month][$value->year] = $value->amount;
        }
        $final = [];
        $i = 0;
        foreach ($getLastSixMonthNumber as $key => $value) {
          $date = explode('-', $value);
          $tm = (int) $date[0];
          $ty = (int) $date[1];
          $final[$i]['month'] =  $date[0];
          $final[$i]['year'] =  $date[1];
          if(isset($data_map[$tm][$ty])) $final[$i]['amount'] =  $data_map[$tm][$ty];
          else $final[$i]['amount'] =  0;
          $i++;
        }

        return $final;

    }
    /*Start Invoice Over due and outstanding amout array*/
    function getOverDueArrayList($sixMonthOverdue,$getLastSixMonthNumber){

        $data_map = [];
        foreach ($sixMonthOverdue as $key => $value) {
           $data_map[$value->month][$value->year] = $value->dueamount;
        }
        $final = [];
        $i = 0;
        foreach ($getLastSixMonthNumber as $key => $value) {
          $date = explode('-', $value);
          $tm = (int) $date[0];
          $ty = (int) $date[1];
          $final[$i]['month'] =  $date[0];
          $final[$i]['year'] =  $date[1];
          if(isset($data_map[$tm][$ty])) $final[$i]['dueamount'] =  $data_map[$tm][$ty];
          else $final[$i]['dueamount'] =  0;
          $i++;
        }

        return $final;

    }

    function getOutStandingArrayList($OutStandingSixMonth,$getLastSixMonthNumber){

        $data_map = [];
        foreach ($OutStandingSixMonth as $key => $value) {
           $data_map[$value->month][$value->year] = $value->unpaidamount;
        }
        $final = [];
        $i = 0;
        foreach ($getLastSixMonthNumber as $key => $value) {
          $date = explode('-', $value);
          $tm = (int) $date[0];
          $ty = (int) $date[1];
          $final[$i]['month'] =  $date[0];
          $final[$i]['year'] =  $date[1];
          if(isset($data_map[$tm][$ty])) $final[$i]['unpaidamount'] =  $data_map[$tm][$ty];
          else $final[$i]['unpaidamount'] =  0;
          $i++;
        }

        return $final;

    }  
    /*End Invoice*/
    /*Start Bill Over due and outstanding amout array*/

    function getOverDueBillArrayList($sixMonthOverdue,$getLastSixMonthNumber){

        $data_map = [];
        foreach ($sixMonthOverdue as $key => $value) {
           $data_map[$value->month][$value->year] = $value->dueamount;
        }
        $final = [];
        $i = 0;
        foreach ($getLastSixMonthNumber as $key => $value) {
          $date = explode('-', $value);
          $tm = (int) $date[0];
          $ty = (int) $date[1];
          $final[$i]['month'] =  $date[0];
          $final[$i]['year'] =  $date[1];
          if(isset($data_map[$tm][$ty])) $final[$i]['dueamount'] =  $data_map[$tm][$ty];
          else $final[$i]['dueamount'] =  0;
          $i++;
        }

        return $final;

    }

    function getOutStandingBillArrayList($OutStandingSixMonth,$getLastSixMonthNumber){

        $data_map = [];
        foreach ($OutStandingSixMonth as $key => $value) {
           $data_map[$value->month][$value->year] = $value->unpaidamount;
        }
        $final = [];
        $i = 0;
        foreach ($getLastSixMonthNumber as $key => $value) {
          $date = explode('-', $value);
          $tm = (int) $date[0];
          $ty = (int) $date[1];
          $final[$i]['month'] =  $date[0];
          $final[$i]['year'] =  $date[1];
          if(isset($data_map[$tm][$ty])) $final[$i]['unpaidamount'] =  $data_map[$tm][$ty];
          else $final[$i]['unpaidamount'] =  0;
          $i++;
        }

        return $final;

    }
    /*End Bill*/

    function getProfitArrayList($expenseArrayList,$incomeArrayList){

        $data = array();
        for($i=0;$i<6;$i++){
            
            $incomeAmount = isset($incomeArrayList[$i]['amount']) ? abs($incomeArrayList[$i]['amount']) : 0;
            $expenseAmpunt = isset($expenseArrayList[$i]['amount']) ? abs($expenseArrayList[$i]['amount']) : 0;
            if($incomeAmount>0 && $incomeAmount > $expenseAmpunt){
            $data[$i] = ($incomeAmount-$expenseAmpunt);
           }else{
            $data[$i] = 0;
           }
        }
        return $data;
    }

    function getLastOneMonthDates(){
        $data = array();
        for ($j = 30; $j > -1; $j--) {
            $data[30-$j] = date("d-m", strtotime(" -$j day"));
        }
        return $data;
    }

    function thirtyDaysNameList(){
        $data = array();
        for ($j = 30; $j > -1; $j--) {
            $data[30-$j] = date("d M", strtotime("-$j day"));
        }
       // d($data,1);
        return $data;
    }

    function lastThirtyDaysProfit($income,$expense){
        $profit = [];
       // d($income,1);
        for($i = 0; $i<=30;$i++){
            $incomeAmount = !empty($income) ? abs($income[$i]) : 0;
            $expenseAmpunt = !empty($expense) ? abs($expense[$i]) : 0;
            if($incomeAmount>0 && $incomeAmount>$expenseAmpunt){
                $profit[$i] = $incomeAmount-$expenseAmpunt;
            }else{
                $profit[$i] = 0;
            }
        }
        return $profit;

    }


function totalLeaves($leaveType)
{
    $result = [
        '1' => '24',//casual leave
        '2' => '6',//sick leave
        '3' => '15',//marriage leave
        '4' => '10',//bereavement leave
        '6' => '15',//paternity leave
        '12' => '90',//maternity leave
        '7' => '0',
        '8' => '0',
        '9' => '0',
        '10' => '0',
        '11' => '0'
    ];

    return $result[$leaveType];
}

function convertRole($role)
{
    $data = [
        'Admin' => '1',
        'Director' => '2',
        'Research Analyst' => '3',
        'Senior Research Analyst' => '4',
        'Team Lead' => '5',
        'IT Executive' => '6',
        'HR Manager' => '7',
        'Associate-Enforcement' => '8',
        'Enforcement Head' => '9',
        'Finance Controller' => '10',
        'Consultant' => '11',
        'Front desk Executive' => '12',
        'Software Developer' => '13',
        'Senior Software Developer' => '14',
        'Accounts Executive' => '15',
        'Manager' => '16'
        //bharo baki
    ];
    if($role){
        return $data[$role];
    }
    return $data;
}

function convertStatus($emp_status)
{
    $data = [
        'Present' => 1,
        'Ex' => 0
    ];
    return $data[$emp_status];
}

function convertStatusBack($emp_status)
{
    if($emp_status==""){return "";}
    $data = [
        1 => 'Present',
        0 => 'Ex'
    ];
    return $data[$emp_status];
}

function getLeaveType($leave_id)
{
    $result = \App\Models\LeaveType::where('id', $leave_id)->first();
    return $result->leave_type;
}

function covertDateToDay($date)
{
    $day = strtotime($date);
    $day = date("l", $day);
    return strtoupper($day);
}
/*
function getFormattedDate($date)
{
    $date = new DateTime($date);
    return date_format($date, 'l jS \\of F Y');
}*/


function getFormattedDate($date)
{
    $date =  strtotime($date);
    return date('Y-m-d', $date);
}

function getEmployeeDropDown()
{
    $data = [

        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'department' => 'Department',
        'email' => 'Email',
        'number' => 'Number'
    ];
    return $data;
}


function getLeaveColumns()
{
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'days' => 'Days',
        'leave_type' => 'Leave type',
        'status' => 'Status'
    ];

    return $data;
}

function getAttendanceDropDown()
{
    $data = [

        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'date' => 'Date',
        'day' => 'Day',
        'hours_worked' => 'Hours Worked',
        'status' => 'Status'
    ];
    return $data;
}


function getHoursWorked($inTime, $outTime)
{

    $result = strtotime($outTime) - strtotime($inTime);
    $totalMinutes = abs($result) / 60;

    $minutes = $totalMinutes % '60';
    $hours = $totalMinutes - $minutes;
    $hours = $hours / 60;

    return $hours . ':00' . $minutes . ':00';

}

function convertAttendanceTo($status)
{
    $data = [
        'P' => '1',
        'A' => '2',
        'Va' => '3',
        'Le' => '4',
        'Sick' => '5',
        'HLF' => '6'
    ];
    return $data[$status];
}

function convertAttendanceFrom($status)
{
    $data = [
        '1' => 'P',
        '2' => 'A',
        '3' => 'Va',
        '4' => 'Le',
        '5' => 'Sick',
        '6' => 'HLF'
    ];
    return $data[$status];
}

function convertAttendanceClassFrom($status)
{
    $data = [
        '1' => 'present',
        '2' => 'absent',
        '3' => 'vacation',
        '4' => 'leave',
        '5' => 'sick',
        '6' => 'half-day'
    ];
    return $data[$status];
}

function qualification()
{
    $data = [
        '' => 'Select one',
        'B.Com' => 'B.Com',
        'B.Sc' => 'B.Sc',
        'BCA' => 'BCA',
        'MCA' => 'MCA',
        'BCA+MCA' => 'BCA+MCA',
        'BBA' => 'BBA',
        'MBA' => 'MBA',
        'BBA+MBA' => 'BBA+MBA',
        'Engineering(B.Tech)' => 'Engineering(B.Tech)',
        'Engineering(B.Tech+M.Tech)' => 'Engineering(B.Tech+M.Tech)',
        'Other' => 'Other'
    ];

    return $data;
}

function getGender($gender)
{
    $data = [
        '0' => 'Male',
        '1' => 'Female',
    ];

    return $data[$gender];
}

function getUserData($userId)
{
    $user = \App\User::where('id', $userId)->with('employee')->first();

    return $user;
}

/*Helper function for CRM*/

function leadSource()
{
    $data = [
        '' => 'Select one',
        '1' => 'Advertisement',
        '2' => 'Cold Call',
        '3' => 'Employee Referral',
        '4' => 'External Referral',
        '5' => 'Online Store',
        '6' => 'Partner',
        '7' => 'Public Relations',
        '8' => 'Sales Email Alias',
        '9' => 'Seminar Partner',
        '10' => 'Internal Seminar',
        '11' => 'Trade Show',
        '12' => 'Web Download',
        '13' => 'Web Research',
        '14' => 'Chat'
    ];

    return $data;
}

function getleadSourceByKey($key)
{
    $data = [
        '' => 'Select one',
        '1' => 'Advertisement',
        '2' => 'Cold Call',
        '3' => 'Employee Referral',
        '4' => 'External Referral',
        '5' => 'Online Store',
        '6' => 'Partner',
        '7' => 'Public Relations',
        '8' => 'Sales Email Alias',
        '9' => 'Seminar Partner',
        '10' => 'Internal Seminar',
        '11' => 'Trade Show',
        '12' => 'Web Download',
        '13' => 'Web Research',
        '14' => 'Chat'
    ];

    return $data[$key];
}

function leadStatus()
{
    $data = [
        '' => 'Select one',
        '1' => 'Attempted to Contact',
        '2' => 'Contact in Future',
        '3' => 'Contacted',
        '4' => 'Junk Lead',
        '5' => 'Lost Lead',
        '6' => 'Not Contacted',
        '7' => 'Pre-Qualified',
        '8' => 'Not Qualified'
    ];
    return $data;
}

function getleadStatusByKey($key)
{
    $data = [
        '1' => 'Attempted to Contact',
        '2' => 'Contact in Future',
        '3' => 'Contacted',
        '4' => 'Junk Lead',
        '5' => 'Lost Lead',
        '6' => 'Not Contacted',
        '7' => 'Pre-Qualified',
        '8' => 'Not Qualified'
    ];
    return $data[$key];
}

function leadStage()
{
    $data = [
        '' => 'Select one',
        '1' => 'Qualified',
        '2' => 'Negotiation',
        '3' => 'Deal Won',
        '4' => 'Deal Lost',
        '5' => 'Deal Discard',
    ];
    return $data;
}

function getleadStageByKey($key)
{
    $data = [
        '0' => '',
        '1' => 'Qualified',
        '2' => 'Negotiation',
        '3' => 'Deal Won',
        '4' => 'Deal Lost',
        '5' => 'Deal Discard',
    ];
    return $data[$key];
}

function taskAccounts()
{
    $data = [
        '' => 'Select Account',
        '1' => 'Deal',
        '2' => 'Product',
        '3' => 'Campaign',
        '4' => 'Case',
        '5' => 'Vendor',
        '6' => 'Quote',
        '7' => 'Sales Order',
        '8' => 'Purchase Order',
        '9' => 'Invoice'
    ];
    return $data;
}

function gettaskAccountByKey($key)
{
    $data = [
        '0' => '',
        '1' => 'Deal',
        '2' => 'Product',
        '3' => 'Campaign',
        '4' => 'Case',
        '5' => 'Vendor',
        '6' => 'Quote',
        '7' => 'Sales Order',
        '8' => 'Purchase Order',
        '9' => 'Invoice'
    ];
    return $data[$key];
}

function taskStatus()
{
    $data = [
        '' => 'Select Status',
        '1' => 'Not Started',
        '2' => 'Deferred',
        '3' => 'In Progress',
        '4' => 'Completed',
        '5' => 'Waiting for input',
    ];
    return $data;
}

function gettaskStatusByKey($key)
{
    $data = [
        '0' => '',
        '1' => 'Not Started',
        '2' => 'Deferred',
        '3' => 'In Progress',
        '4' => 'Completed',
        '5' => 'Waiting for input',
    ];
    return $data[$key];
}

function taskPriority()
{
    $data = [
        '' => 'Select Priority',
        '1' => 'High',
        '2' => 'Highest',
        '3' => 'Low',
        '4' => 'Lowest',
        '5' => 'Normal',
    ];
    return $data;
}

function getPriorityByKey($key)
{
    $data = [
        '0' => '',
        '1' => 'High',
        '2' => 'Highest',
        '3' => 'Low',
        '4' => 'Lowest',
        '5' => 'Normal',
    ];
    return $data[$key];
}

function leadIndustry()
{
    $data = [
        '' => 'Select one',
        '1' => 'ASP (Application Service Provider)',
        '2' => 'Data/Telecom OEM',
        '3' => 'ERP (Enterprise Resource Planning)',
        '4' => 'Government/Military',
        '5' => 'Large Enterprise',
        '6' => 'ManagementISV',
        '7' => 'MSP (Management Service Provider)',
        '8' => 'Network Equipment Enterprise',
        '9' => 'Non-management ISV',
        '10' => 'Optical Networking',
        '11' => 'Service Provider',
        '12' => 'Small/Medium Enterprise',
        '13' => 'Storage Equipment',
        '14' => 'Storage Service Provider',
        '15' => 'Systems Integrator',
        '16' => 'Wireless Industry',
        '17' => 'ERP'
    ];
    return $data;
}

function getleadIndustryByKey($key)
{
    $data = [
        '' => 'Select one',
        '1' => 'ASP (Application Service Provider)',
        '2' => 'Data/Telecom OEM',
        '3' => 'ERP (Enterprise Resource Planning)',
        '4' => 'Government/Military',
        '5' => 'Large Enterprise',
        '6' => 'ManagementISV',
        '7' => 'MSP (Management Service Provider)',
        '8' => 'Network Equipment Enterprise',
        '9' => 'Non-management ISV',
        '10' => 'Optical Networking',
        '11' => 'Service Provider',
        '12' => 'Small/Medium Enterprise',
        '13' => 'Storage Equipment',
        '14' => 'Storage Service Provider',
        '15' => 'Systems Integrator',
        '16' => 'Wireless Industry',
        '17' => 'ERP'
    ];
    return $data[$key];
}

function leadRating()
{
    $data = [
        '' => 'Select one',
        '1' => 'Acquired',
        '2' => 'Active',
        '3' => 'Market Failed',
        '4' => 'Project Cancelled',
        '5' => 'Shut Down',
    ];
    return $data;
}

function getleadRatingById($key)
{
    $data = [
        '' => 'Select one',
        '1' => 'Acquired',
        '2' => 'Active',
        '3' => 'Market Failed',
        '4' => 'Project Cancelled',
        '5' => 'Shut Down',
    ];
    return $data[$key];
}