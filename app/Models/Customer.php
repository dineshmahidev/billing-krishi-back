<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name','company_name','contact_person','phone','email','address','gstin','city','state','notes','is_active'];
    protected $casts = ['is_active'=>'boolean'];

    public function reports(): HasMany { return $this->hasMany(Report::class); }
    public function invoices(): HasMany { return $this->hasMany(Invoice::class); }
}
