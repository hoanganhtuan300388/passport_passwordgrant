<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contact.
 *
 * @package namespace App\Entities;
 */
class Contact extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'contacts';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'friend_id',
        'group_id',
        'action_at',
    ];

    /**
     * Get the messages for the contact.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'contact_id', 'id');
    }

    /**
     *  Get first message for contact
     */
    public function message()
    {
        return $this->messages()->select('id', 'contact_id', 'member_id', 'content')->orderBy('messages.created_at', 'desc')->limit(1);
    }

}
