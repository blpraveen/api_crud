<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

	protected $fillable = ['nick_name','content','news_id','events_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
        'updated_at' => 'datetime:d-M-Y'
    ];

    public function news()
    {       
		return $this->hasOne('App\Models\News',  'id', 'news_id');
    }
    public function events()
    {       
		return $this->hasOne('App\Models\Events', 'id', 'events_id');
    }    
}
