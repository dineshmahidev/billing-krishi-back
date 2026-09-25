<?php
namespace App\Models;
use App\Models\Concerns\DemoScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use DemoScoped;

    protected $fillable = ['name','company_name','contact_person','phone','email','address','gstin','city','state','notes','is_active','group_id','is_demo'];
    protected $casts = ['is_active'=>'boolean','is_demo'=>'boolean'];

    public function reports(): HasMany { return $this->hasMany(Report::class); }
    public function invoices(): HasMany { return $this->hasMany(Invoice::class); }
    public function group(): BelongsTo { return $this->belongsTo(CustomerGroup::class, 'group_id'); }
}
