<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Product extends Eloquent {

    public $timestamps = [];
    protected $fillable = ['name', 'public_key', 'fk1_id'];

    public function user()
    {
        $this->belongsToMany('user', 'product_reviews', 'id', 'id');
    }
    public function getProduct_with_ASIN($asin)
    {
        return $user = $this->where('ASIN', '=', $asin)->first();
    }
    public function getAmazonReview ($asin)
    {
        $api = new amazon_api();
        return $api->getReviewURL($asin);
    }
}
