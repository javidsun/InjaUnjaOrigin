<?php

namespace App\Models;

use App\Constant\TableParametersConst\RoleJson;
use App\Domain\Entity;
use App\DTOs\ModelEntityConvertable;
use App\Entities\RoleEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\Uid\Ulid;


/**
 * @property Ulid $id
 * @property string $name
 * @property string $description
 */
class Role extends Model implements ModelEntityConvertable
{
    protected $fillable = [
        RoleJson::NAME,
    ];
    protected $hidden = [
        RoleJson::DESCRIPTION
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function toEntity(): RoleEntity
    {
        return new RoleEntity(
            new Ulid($this->id),
            $this->name,
            $this->description
        );
    }

    public static function fromEntity(RoleEntity|Entity $entity): self
    {
        return new self([
            RoleJson::NAME => $entity->getName(),
            RoleJson::DESCRIPTION => $entity->getDescription()
        ]);
    }
}
