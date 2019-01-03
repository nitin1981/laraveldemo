<?php

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

function adminLeadType()
{
    $data = [
        '1' => 'Merrchant',
        '2' => 'Co-Working',
        '3' => 'Lakeview',
        '4' => 'Palmtree',
        '5' => 'Services',
        '6' => 'GRAD',
        '7' => 'Ecommerce',
    ];
    return $data;
}

function getadminLeadTypeByKey($key)
{
    $data = [
        '1' => 'Merrchant',
        '2' => 'Co-Working',
        '3' => 'Lakeview',
        '4' => 'Palmtree',
        '5' => 'Services',
        '6' => 'GRAD',
        '7' => 'Ecommerce',
    ];
    return $data[$key];
}

function adminLeadSource()
{
    $data = [
        '0' => 'Select Source',
        '1' => 'PPC',
        '2' => 'Website',
        '3' => 'Refferal',
        '4' => 'Just Dial',
        '5' => 'Cold Calling',
        '6' => 'Survey',
        '7' => 'Affiliate',
        '8' => 'Social Media',
        '9' => 'New Sign-Up',
        '10' => 'Direct',
    ];
    return $data;
}

function getadminLeadSourceByKey($key)
{
    $data = [
        '0' => '',
        '1' => 'PPC',
        '2' => 'Website',
        '3' => 'Refferal',
        '4' => 'Just Dial',
        '5' => 'Cold Calling',
        '6' => 'Survey',
        '7' => 'Affiliate',
        '8' => 'Social Media',
        '9' => 'New Sign-Up',
        '10' => 'Direct',
    ];
    return $data[$key];
}

function plantLeadStatusSidebar()
{
    $data = [
        '1' => 'New Leads',
        '7' => 'Junk Leads',
        '3' => 'Attempted to Contact',
        '2' => 'In Progress',
        '10' => 'On Hold',
        '5' => 'Deals Lost',
        '8' => 'Confirmed',
        '4' => 'Shipping',
        '9' => 'Returned',
        '6' => 'Delivered',
    ];
    return $data;
}

function leadStatusGarden()
{
    $data = [
        '1' => 'New Leads',
        '3' => 'Attempted to Contact',
        '4' => 'Done',
        '7' => 'Junk Leads',
    ];
    return $data;
}

function leadStatusSidebar()
{
    $data = [
        '1' => 'New Leads',
        '2' => 'In Progress',
        '3' => 'Attempted to Contact',
        '4' => 'Contact in Future',
        '5' => 'Deals Lost',
        '6' => 'Deals Won',
        '7' => 'Junk Leads',
    ];
    return $data;
}

function leadStatus()
{
    $data = [
        '1' => 'New Leads',
        '2' => 'In Progress',
        '3' => 'Attempted to Contact',
        '4' => 'Contact in Future',
        '5' => 'Deals Lost',
        '6' => 'Deals Won',
        '7' => 'Junk Leads',
    ];
    return $data;
}

function getleadStatusByKey($key)
{
    $data = [
        '1' => 'New Leads',
        '2' => 'In Progress',
        '3' => 'Attempted to Contact',
        '4' => 'Contact in Future',
        '5' => 'Deals Lost',
        '6' => 'Deals Won',
        '7' => 'Junk Leads',
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

function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}