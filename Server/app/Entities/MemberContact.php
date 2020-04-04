<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MemberContact.
 *
 * @package namespace App\Entities;
 */
class MemberContact extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $table = 'member_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'email',
        'mobile_phone',
        'home_phone',
        'office_phone',
        'address1',
        'address2',
    ];

    /**
     * Get the member that owns the contact.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

}
