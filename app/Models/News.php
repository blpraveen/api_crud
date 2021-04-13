<?php

namespace App\Models;
use Cache;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Comment;

class News extends Model
{
	protected $table = 'news';

	protected $fillable = ['title', 'content','user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
        'updated_at' => 'datetime:d-M-Y'
    ];
     /**
     * Return human readable 'created at' date.
     *
     * E.g. '3 hours ago'.
     *
     * @return string
     */
    public function getCreatedAgoAttribute() : string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Return human readable 'updated at' date.
     *
     * E.g. '3 hours ago'.
     *
     * @return string
     */
    public function getUpdatedAgoAttribute() : string
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNotNull('news_id');
    }    
    public function news()
    {       
		return $this->hasOne('App\Models\User',  'id', 'user_id');
    }
}
