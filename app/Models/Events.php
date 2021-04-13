<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Models\Comment;

class Events extends Model
{
    protected $table = 'events';

	protected $fillable = ['valid_from','valid_to','title', 'content','gps_lat','gps_lng','user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
        'updated_at' => 'datetime:d-M-Y'
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNotNull('events_id');
    }     
    public function news()
    {       
		return $this->hasOne('App\Models\User',  'id', 'user_id');
    }    
}
