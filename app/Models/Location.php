<?php

namespace App\Models;

use App\Constant\TableParametersConst\LocationJson;
use App\Domain\Entity\Entity;
use App\Domain\Model\Model;
use App\Domain\ModelEntityConvertable;
use App\Entities\LocationEntity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\Uid\Ulid;

/**
 * @property Ulid|string $id
 * @property string $latitude
 * @property string $longitude
 * @property string $country
 */
class Location extends Model
{
    protected $fillable = [
        LocationJson::ID,
        LocationJson::LATITUDE,
        LocationJson::LONGITUDE,
        LocationJson::COUNTRY
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Ulid::generate();
            }
        });
    }

    public function location(): HasOne
    {
        return $this->hasOne(HomeAnnouncement::class);
    }

    public function toEntity(): LocationEntity
    {
        return new LocationEntity(
            id: $this->id instanceof Ulid ? $this->id : new Ulid($this->id),
            latitude: $this->latitude,
            longitude: $this->longitude,
            country: $this->country,
        );

    }

    public static function fromEntity(Entity $entity): ModelEntityConvertable
    {
        if (! $entity instanceof LocationEntity) {
            throw new \InvalidArgumentException('Entity must be an instance of LocationEntity.');
        }

        $attributes = [
            LocationJson::ID => $entity->id?->toRfc4122(),
            LocationJson::LATITUDE => $entity->latitude,
            LocationJson::LONGITUDE => $entity->longitude,
            LocationJson::COUNTRY => $entity->country,
        ];

        // return self::updateOrCreate([(new static())->getKeyName() => $attributes[(new static())->getKeyName()] ?? null], $attributes);
        return new self($attributes);
    }
}
