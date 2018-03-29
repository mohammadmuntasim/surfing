<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Reviews extends Model
{
    protected $table = 'reviews';
    public $timestamps = true;
    
    /* add reviews  data */
    public function setReview($reviewdata){
    	Reviews::insert($reviewdata);
    }

    /* Check Reviews*/
    public function getReviews($checkreview){
    	return Reviews::where($checkreview)->get();
    }
    /* Count  Reviews*/
    public function countReviews($countreviews){
    	return Reviews::where($countreviews)->count();
    }
    public function updateReviews($checkdata, $setdata){
    	Reviews::where($checkdata)->update($setdata);
    }

}
