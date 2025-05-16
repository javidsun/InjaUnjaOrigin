<?php

namespace App\Models;

use App\Constant\TableParametersConst\PermissionJson;
use App\Domain\Entity\Entity;
use App\Domain\Model\Model;
use App\Entities\PermissionEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Symfony\Component\Uid\Ulid;

/**
 * @property Ulid|string $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 */
class Permission extends Model implements PermissionContract
{
    use HasFactory, RefreshesPermissionCache;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        PermissionJson::ID,
        PermissionJson::NAME,
        PermissionJson::GUARD_NAME,
    ];

    public function __construct(array $attributes = [])
    {
        $attributes[PermissionJson::GUARD_NAME] = $attributes[PermissionJson::GUARD_NAME] ?? config('auth.defaults.guard');
        parent::__construct($attributes);
        // $this->setKeyName(PermissionJson::ID); // Se PermissionJson::ID è diverso da 'id'
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Ulid::generate();
            }
            if (
                static::where(PermissionJson::NAME, $model->name)
                ->where(PermissionJson::GUARD_NAME, $model->guard_name)
                ->where($model->getKeyName(), '!=', $model->getKey())
                ->exists()
            ) {
                throw PermissionAlreadyExists::create($model->name, $model->guard_name);
            }
        });
    }

    /**
     * Un permesso può essere applicato a ruoli.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_has_permissions'),
            config('permission.column_names.permission_pivot_key') ?: 'permission_id',
            config('permission.column_names.role_pivot_key') ?: 'role_id'
        )->withTimestamps(); // Opzionale
    }

    public static function findByName(string $name, $guardName = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermissions_()
            ->where(PermissionJson::NAME, $name)
            ->where(PermissionJson::GUARD_NAME, $guardName)
            ->first(); // Corretto alias

        if (! $permission) {
            throw PermissionDoesNotExist::create($name, $guardName);
        }

        return $permission;
    }

    public static function findById($id, $guardName = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermissions_()
            ->where((new static)->getKeyName(), $id)
            ->where(PermissionJson::GUARD_NAME, $guardName)
            ->first(); // Corretto alias

        if (! $permission) {
            throw PermissionDoesNotExist::withId($id, $guardName);
        }

        return $permission;
    }

    public static function findOrCreate(string $name, $guardName = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::where(PermissionJson::NAME, $name)
            ->where('guard_name', $guardName)
            ->first();

        if (! $permission) {
            return static::query()->create([PermissionJson::NAME => $name, PermissionJson::GUARD_NAME => $guardName]);
        }

        return $permission;
    }

    /**
     * Get the permissions based on the passed params.
     * Spatie usa un metodo getPermissions, ho rinominato in getPermissions_ per evitare conflitti se usi il tratto HasPermissions
     * ma per il modello Permission, il trait RefreshesPermissionCache è più appropriato.
     * Il metodo getPermissions di Spatie è solitamente per collezioni.
     * Qui potremmo direttamente usare il query builder.
     */
    protected static function getPermissions_(): Builder // Rinominato per chiarezza
    {
        return static::query();
    }

    // Implementazione per ModelEntityConvertable
    public function toEntity(): PermissionEntity
    {
        return new PermissionEntity(
            id: $this->getKey() instanceof Ulid ? $this->getKey() : new Ulid($this->getKey()),
            name: $this->name,
            guardName: $this->guard_name
        );
    }

    public static function fromEntity(Entity $entity): self // Specificare PermissionEntity se possibile
    {
        if (! $entity instanceof PermissionEntity) {
            throw new \InvalidArgumentException('Entity must be an instance of PermissionEntity.');
        }

        $attributes = [
            PermissionJson::NAME => $entity->name,
            PermissionJson::GUARD_NAME => $entity->guardName,
        ];

        if ($entity->id) {
            $attributes[(new static())->getKeyName()] = $entity->id->toString();
        }
        return new self($attributes);
    }
}
