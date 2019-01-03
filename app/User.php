<?php

namespace App;
use App\Models\Employee;
use App\Models\Project;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'real_name', 'email', 'role_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Login required validation
     *
     * @var array
     */
    public static $login_validation_rule = [
        'email' => 'required|email|exists:users',
        'password' => 'required',
        //'company' => 'required'
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function isHR()
    {
        $userId = Auth::user()->id;
        $userRole = UserRole::where('user_id', $userId)->first();
        if($userRole->role_id == 7 || $userRole->role_id == 1)
        {
            return true;
        }
        return false;
    }

    public function notAnalyst()
    {
        $userId = Auth::user()->id;
        $userRole = UserRole::where('user_id', $userId)->first();
        if($userRole->role_id != 3)
        {
            return true;
        }
        return false;
    }

    public function isCoordinator()
    {
        $userId = Auth::user()->id;
        $userRole = UserRole::where('user_id', $userId)->first();
        $roleIds = [2,5,7,8,9,10,14,16];
        if(in_array($userRole->role_id, $roleIds) )
        {
            return true;
        }
        return false;
    }

    public function isManager()
    {
        $userId = Auth::user()->id;
        $userRole = UserRole::where('user_id', $userId)->first();
        if($userRole->role_id == 16)
        {
            return true;
        }
        return false;
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
