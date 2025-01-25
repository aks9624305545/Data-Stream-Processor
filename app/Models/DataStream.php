<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataStream extends Model
{
    protected $table = 'data_stream';
    protected $fillable = [
        'stream',
        'k',
        'top',
        'exclude',
        'sequenceData',
    ];
}
