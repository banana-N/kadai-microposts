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
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me)
        {
            // 既にフォローしていれば何もしない
            return false;
        }else{
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしていかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($exist && !$its_me)
        {
            // 既にフォローしている & 自分自身ではなお場合、フォローを外す
            $this->followings()->detach($userId);
            return true;
        }else{
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    
    /*
    * favorite
    --------------------------*/
    public function favorites()
    {
        return $this->belongstoMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    public function favorite($micropost_id)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_favorite($micropost_id);
        
        
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $micropost_id;
        
        // if ($exist || $its_me)
        if ($exist)
        {
            // 既にフォローしていれば何もしない
            return false;
        }else{
            // 未フォローであればフォローする
            $this->favorites()->attach($micropost_id);
            return true;
        }
    }
    
    public function unfavorite($micropost_id)
    {
        // 既にフォローしていかの確認
        $exist = $this->is_favorite($micropost_id);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $micropost_id;
        
        // if ($exist && !$its_me)
        if ($exist)
        {
            // 既にフォローしている & 自分自身ではなお場合、フォローを外す
            $this->favorites()->detach($micropost_id);
            return true;
        }else{
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_favorite($micropost_id)
    {
        return $this->favorites()->where('micropost_id', $micropost_id)->exists();
    }
    
    public function feed_favorites()
    {
        $favorite_user_ids = $this->favorites()->pluck('users.id')->toArray();
        $favorite_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $favorite_user_ids);
    }
}