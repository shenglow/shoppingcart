<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_products';

    /**
     * Get the product record associated with the order.
     */
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'pid', 'pid');
    }

    /**
     * Get the specification record associated with the order.
     */
    public function specification()
    {
        return $this->hasOne('App\Models\ProductSpecification', 'psid', 'psid');
    }
}
