<?php

namespace App\Models;

use App\Models\Concerns\DemoScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportType extends Model
{
    use DemoScoped;

    protected $fillable = ['name','title','active','show_specification','custom_columns','is_demo'];
    protected $casts = ['active'=>'boolean','show_specification'=>'boolean','custom_columns'=>'array','is_demo'=>'boolean'];

    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class)->orderBy('display_order');
    }

    public function activeParameters(): HasMany
    {
        return $this->hasMany(Parameter::class)->where('active', true)->orderBy('display_order');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
