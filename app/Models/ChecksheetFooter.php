<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecksheetFooter extends Model
{
    protected $fillable = [
        'id_checksheetdtl',
        'model',
        'prod_plan',
        'prod_actual',
    ];

    // Define the relationship with the checksheet_details table
    public function checksheetDetail()
    {
        return $this->belongsTo(ChecksheetDetail::class, 'id_checksheetdtl');
    }
}

