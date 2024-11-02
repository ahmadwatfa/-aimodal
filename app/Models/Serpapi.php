<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serpapi extends Model
{
    use HasFactory;
    protected $fillable = [
        'query',
        'user_id',
        'project_id',
        'date',
        'timestamp',
        'value',
        'extracted_value',
        'partial_data',
    ];
}
