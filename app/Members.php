<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    public $table = 'members';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'id',
    	'email',
        'user_id',
    	'mm_user_id',
    	'referer_url'
    ];

    public function user_id()
    {
        return $this->belongsTo('App\User');
    }

    public function getallMember($emailoruserid)
    {
    	return $this->where('email', $emailoruserid)->orWhere('thirdrdparty_user_id', $emailoruserid)->get();
    	// return $this->find('')
    }

    public function getMember($emailoruserid)
    {
    	return $this->where('email', $emailoruserid)->orWhere('thirdrdparty_user_id', $emailoruserid)->first();
    	// return $this->find('')
    }

    public function getMemberByMId($mmid, $emailoruserid)
    {
        return $this->where('mm_user_id',$mmid)
                    ->where(function($query) use ($emailoruserid) {
                        $query->where('email', $emailoruserid)->orWhere('thirdrdparty_user_id', $emailoruserid)->first();
                    })
                    ->first();
    	// return $this->find('')
    }
}
