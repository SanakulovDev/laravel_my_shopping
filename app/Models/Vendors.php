<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    // filiable fields
    protected $fillable = [
        'name',
        'description',
        'company_name',
        'logo_url',
        'website',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'postal_code',
        'country',
        'status',
        'commission_rate',
        'bank_details',
        'bank_name',
        'tax_id',
    ];
}
