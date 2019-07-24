<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carousels';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'carousel_id';
}
