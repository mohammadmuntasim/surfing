<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;


class UserMetum extends Model
{
    protected $table = 'user_meta';
    public $timestamps = false;

    public function setUserMeta($setUserMeta){
    	UserMetum::insert($setUserMeta);
    }

    /* Get user meat of specific field */
    public function getUserMeta($checkMetaArray){
    	return UserMetum::where($checkMetaArray)->get();
    }

    /* Update user meta , accept array as argument */
    public function updateUserMeta($checkMetaArray, $metaArray){
    	UserMetum::where($checkMetaArray)->update($metaArray);
    }

    /* Check user meta key exist with current user */
    public function isUserMetaKeyExist($uid='',$metaKey=''){               
        $metaExist = UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', $metaKey)->get();
        foreach ($metaExist as $key => $metaExist) {
            if (!empty($metaExist)) {
                return 1;
            }else{
                return 0;
            }
        }
        
    }

     /* Check user meta key exist with current user */
    public function isUserMetaValueExist($uid='',$metaKey='',$metaValue=''){               
        $metaExist = UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', $metaKey)->where('user_meta_value', '=', $metaValue)->get();
        foreach ($metaExist as $key => $metaExist) {
            if (!empty($metaExist)) {
                return 1;
            }else{
                return 0;
            }
        }
        
    }

}
