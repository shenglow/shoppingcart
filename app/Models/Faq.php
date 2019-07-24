<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'fid';
}
