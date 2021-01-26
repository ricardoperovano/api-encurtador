<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = "urls";

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'original_url',
        'shortened_url',
        'expiration_date',
        'created_at'
    ];

    public function setShortenedUrl($value)
    {
        $this->shortened_url = $value;

        return $this;
    }
}
