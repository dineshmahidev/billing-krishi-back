<?php
namespace App\Models;

use App\Models\Concerns\DemoScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerGroup extends Model
{
    use DemoScoped;

    protected $fillable = ['name','is_demo'];
    protected $casts = ['is_demo'=>'boolean'];

    public function customers(): HasMany { return $this->hasMany(Customer::class, 'group_id'); }
}
