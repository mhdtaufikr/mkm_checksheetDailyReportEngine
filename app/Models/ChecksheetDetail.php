<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecksheetDetail extends Model
{
    use HasFactory;
    protected $table = 'checksheets_details';
    protected $guarded=[
        'id'
    ];
}
