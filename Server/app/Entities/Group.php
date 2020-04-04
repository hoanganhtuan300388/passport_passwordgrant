<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Group.
 *
 * @package namespace App\Entities;
 */
class Group extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $table = 'groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'member_id',
    ];

    /**
     * relationship belongs to many with contacts tables;
     */
    public function members()
    {
        return $this->belongsToMany(Member::class,'contacts', 'group_id', 'member_id');
    }

}
