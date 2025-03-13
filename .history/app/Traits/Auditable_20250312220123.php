<?php

use App\Services\AuditService;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            app(AuditService::class)->log(
                'created',
                get_class($model),
                $model->id,
                null,
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $original = array_intersect_key($model->getOriginal(), $changes);

            app(AuditService::class)->log(
                'updated',
                get_class($model),
                $model->id,
                $original,
                $changes
            );
        });

        static::deleted(function ($model) {
            app(AuditService::class)->log(
                'deleted',
                get_class($model),
                $model->id,
                $model->toArray(),
                null
            );
        });
    }
}
