<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MemberSetting.
 *
 * @package namespace App\Entities;
 */
class MemberSetting extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $table = 'member_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'display_location',
        'display_contact',
        'offline_email',
    ];

    /**
     * Get the member that owns the setting.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

}
