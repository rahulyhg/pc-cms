<?php

namespace App;

use App\Traits\ModelTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class User extends Authenticatable
{
    use Notifiable, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'last_login',
        'IP',
        'USER_AGENT'
    ];

    protected static $sortable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function getUsersWithPagination()
    {
        return self::getModelDataWithPagination(false, ['role'], [(int) Auth::id()]);
    }

    public static function createNewUser()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
           'email' => 'required|unique:users',
           'password' => 'required|min:6',
           'role_id'  => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data['password'] = Hash::make($data['password']);

        self::create($data);

        return redirect(route(getRouteName('users', 'index')))->with('alert', [
            'type' => 'success',
            'message' => __('messages.item_created_success')
        ]);
    }

    public function updateUser()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->email, 'email')
            ],
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $this->update($data);

        return back()->with('alert', [
            'type' => 'success',
            'message' => __('messages.item_updated_success')
        ]);
    }

    public function removeUser()
    {
        if ($this->id === Auth::id()) {
            return back();
        }

        $this->delete();

        return back()->with('alert', [
            'type' => 'success',
            'message' => __('messages.item_deleted_success')
        ]);
    }

    public function resetPassword()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'password' => 'required|min:6',
            'repeatedPassword' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if ($data['password'] !== $data['repeatedPassword']) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'Passwords must be the same'
            ]);
        }

        $this->update(['password' => Hash::make($data['password'])]);

        return back()->with('alert', [
            'type' => 'success',
            'message' => __('passwords.reset')
        ]);
    }

    public static function updateLoggedUserSettings()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::user()->email, 'email')
            ],
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        Auth::user()->update($data);

        return back()->with('alert', [
            'type' => 'success',
            'message' => __('messages.item_updated_success')
        ]);
    }

    public function updateUserAfterLogin()
    {
        $this->update([
            'last_login' => date("Y-m-d H:i:s", time()),
            'IP' => request()->server('REMOTE_ADDR'),
            'USER_AGENT' => request()->server('HTTP_USER_AGENT')
        ]);
    }

    public function updateUserRole()
    {
        $data = request()->all();

        $this->update([
            'role_id' => $data['role_id']
        ]);

        return back()->with('alert', [
            'type' => 'success',
            'message' => __('messages.item_updated_success')
        ]);
    }

    public static function getLastRegisteredUsers($limit = 5)
    {
        return self::latest()->limit($limit)->get();
    }

    public static function massActions()
    {
        $data = request()->all();
        $selected_ids = explode(',', $data['selected_values']);

        switch ($data['action_name']) {
            case 'delete':
                return self::massActionsDelete($selected_ids);
        }
    }
}
