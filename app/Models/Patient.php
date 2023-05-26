<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;

    protected $fillable =[
        'first_name',
        'last_name',
        'birthdate',
        'age',
        'age_type'
    ];

    public function scopeList($query)
    {
        return $query->select(
            DB::raw('CONCAT(first_name," ",last_name) AS name'),
            DB::raw('DATE_FORMAT(birthdate,"%d.%m.%Y") AS birthdate'),
            DB::raw('CONCAT(age," ",age_type) AS age')
        );
    }

}
