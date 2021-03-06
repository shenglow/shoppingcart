<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'oid';

    /**
     * Get the order products record associated with the order.
     */
    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct', 'oid', 'oid');
    }
}
