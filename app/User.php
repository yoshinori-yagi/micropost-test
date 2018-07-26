<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // confirm if already following
        $exist = $this->is_following($userId);
        // confirming that it is not you
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // do nothing if already following
            return false;
        } else {
            // follow if not following
            $this->followings()->attach($userId);
            return true;
                }
    }

    public function unfollow($userId)
    {
        // confirming if already following
        $exist = $this->is_following($userId);
        // confirming that it is not you
        $its_me = $this->id == $userId;


        if ($exist && !$its_me) {
            // stop following if following
            $this->followings()->detach($userId);
            return true;
        } else {
            // do nothing if not following
            return false;
        }
    }


    public function is_following($userId) {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_microposts() {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    public function favorings()
    {
        return $this->belongsToMany(Micropost::class, 'favorite', 'user_id', 'micropost_id')->withTimestamps();
    }

    public function favorite($micropostId)
    {
        $exist = $this->is_favoring($micropostId) ;
  
        if ($exist) {
            return false;
        } else {
            $this->favorings()->attach($micropostId) ;
            return true;
        }
    }
    
    public function unfavorite($micropostId)
    {
        // confirming if already following
        $exist = $this->is_favoring($micropostId);

        if ($exist) {
            // stop following if following
            $this->favorings()->detach($micropostId);
            return true;
        } else {
            // do nothing if not following
            return false;
        }
    }
    
    public function is_favoring($micropostId) {
        return $this->favorings()->where('micropost_id', $micropostId)->exists();
    }

     public function retweetings()
    {
        return $this->belongsToMany(Micropost::class, 'retweets', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    public function retweet($micropostId)
    {
        $exist = $this->is_retweeting($micropostId) ;
  
        if ($exist) {
            return false;
        } else {
            $this->favorings()->attach($micropostId) ;
            return true;
        }
    }
    
    public function unretweet($micropostId)
    {
        // confirming if already following
        $exist = $this->is_retweeting($micropostId);

        if ($exist) {
            // stop following if following
            $this->retweetings()->detach($micropostId);
            return true;
        } else {
            // do nothing if not following
            return false;
        }
    }
    
     public function is_retweeting($micropostId) {
        return $this->retweetings()->where('micropost_id', $micropostId)->exists();
    }
}
