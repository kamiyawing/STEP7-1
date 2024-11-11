<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    public function getList() {
        $companies = DB::table('companies');
        return $companies;
    }
    public function company() {        
        return $this->hasMany(Product::class, 'company_id');
    }
}
