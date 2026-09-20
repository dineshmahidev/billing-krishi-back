<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportType extends Model
{
    protected $fillable = ['name','title','active'];
    protected $casts = ['active'=>'boolean'];

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
