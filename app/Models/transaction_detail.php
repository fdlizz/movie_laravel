<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_detail extends Model
{
    use HasFactory;
    protected $table = 'transaction_details';
    protected $fillable = [
        'transaction_id',
        'movie_id',
        'quantity',
    ];
    public $timestaps = true;
}
