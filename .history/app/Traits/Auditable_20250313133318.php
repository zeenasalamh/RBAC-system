<?php
namespace App\Traits;

use App\Services\AuditService;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AuditableModel",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier"
 *     ),
 *     @OA\Property(
 *         property="audit_logs",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="action", type="string"),
 *             @OA\Property(property="entity_type", type="string")
 *         )
 *     )
 * )
 */
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