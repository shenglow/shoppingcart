<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_reviews';

    /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'prid';

    /**
     * Get the author of the review.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'id');
    }
}
