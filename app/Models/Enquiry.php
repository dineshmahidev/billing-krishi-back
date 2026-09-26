<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = ['type','name','phone','email','sample_type','message'];

    public function ref(): string
    {
        return 'ENQ-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function isSample(): bool
    {
        return $this->type === 'sample';
    }

    public function typeLabel(): string
    {
        return $this->isSample() ? 'Sample Test Request' : 'Website Enquiry';
    }
}
