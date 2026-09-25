<?php

namespace App\Models\Scopes;

use App\Models\User;
use App\Support\DemoContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DemoScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // Console (seeder/tinker/artisan): never filter; seeders must
        // filter is_demo explicitly so they stay idempotent.
        if (app()->runningInConsole()) {
            return;
        }

        if (!app()->bound(DemoContext::class)) {
            // HTTP context not resolved yet (login/auth bootstrap).
            if ($model instanceof User) {
                return;
            }
            // Fail closed for everything else.
            $builder->where($model->qualifyColumn('is_demo'), 0);
            return;
        }

        $user = app(DemoContext::class)->user;

        // Unauthenticated User lookups (login) must see every account.
        if ($user === null && $model instanceof User) {
            return;
        }

        $builder->where(
            $model->qualifyColumn('is_demo'),
            $user !== null && $user->is_demo ? 1 : 0
        );
    }
}
