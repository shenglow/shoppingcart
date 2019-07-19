<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_specification';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'psid';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the product of the spec.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'pid', 'pid');
    }
}
