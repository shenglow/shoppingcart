<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wishlists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'pid'];

    /**
     * Get the author of the wistlist.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'id');
    }

    /**
     * Get the product of the wistlist.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'pid', 'pid');
    }

    /**
     * Get the spec of the product.
     */
    public function specification()
    {
        return $this->hasMany('App\Models\ProductSpecification', 'pid', 'pid');
    }
}
