<?php

namespace App\Models\Concerns;

use App\Models\Scopes\DemoScope;
use App\Support\DemoContext;
use Illuminate\Database\Eloquent\Model;

trait DemoScoped
{
    public static function bootDemoScoped(): void
    {
        static::addGlobalScope(new DemoScope());

        static::creating(function (Model $model): void {
            if (!app()->bound(DemoContext::class)) {
                return;
            }
            $user = app(DemoContext::class)->user;
            if ($user === null) {
                return;
            }
            $model->setAttribute('is_demo', $user->is_demo ? 1 : 0);
        });
    }
}
