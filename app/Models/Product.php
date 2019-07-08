<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'pid';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the category record associated with the product.
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'cid', 'cid');
    }

    /**
     * Get the spec of the product.
     */
    public function specification()
    {
        return $this->hasMany('App\Models\ProductSpecification', 'pid', 'pid');
    }
}
