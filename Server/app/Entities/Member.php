<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class Member.
 *
 * @package namespace App\Entities;
 */
class Member extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'avatar',
        'city',
        'country',
        'birthday',
        'gender',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param $username
     * @return mixed
     */
    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }

    /**
     * Get the contact record associated with the member.
     */
    public function contact()
    {
        return $this->hasOne(MemberContact::class, 'member_id', 'id')
                    ->select(['id', 'member_id', 'email', 'mobile_phone', 'home_phone', 'office_phone', 'address1', 'address2']);
    }

    /**
     * Get the setting record associated with the member.
     */
    public function setting()
    {
        return $this->hasOne(MemberSetting::class, 'member_id', 'id')
                    ->select(['id', 'member_id', 'display_location', 'display_contact', 'offline_email']);
    }

    /**
     * relationship belongs to many with contacts tables;
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class,'contacts', 'member_id', 'group_id');
    }

    /**
     * relationship belongs to many with contacts tables;
     */
    public function friends()
    {
        return $this->belongsToMany(Member::class,'contacts', 'member_id', 'friend_id');
    }

    /**
     * Get the messages for the member.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'member_id', 'id');
    }

}
