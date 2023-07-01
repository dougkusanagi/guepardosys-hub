<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Tenantable
{
    protected static function bootTenantable()
    {
        static::addGlobalScope(new TenantScope);

        if (
            session()->has('tenant_id')
            && !is_null(session()->get('tenant_id'))
        ) {
            static::creating(function ($model) {
                $model->tenant_id = auth()->user()->tenant_id;
            });
        }
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
