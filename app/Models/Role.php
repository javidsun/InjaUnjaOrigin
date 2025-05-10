<?php

namespace App\Models;

use App\Constant\TableParametersConst\RoleJson;
use App\Domain\Entity\Entity;
use App\Domain\Model\Model;
use App\Entities\RoleEntity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\Permission\Contracts\Permission as PermissionContractInterface;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasPermissions;
use Symfony\Component\Uid\Ulid;

// Alias per il contratto

/**
 * @property Ulid|string $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 */
class Role extends Model implements RoleContract
{
    // TODO JAVID : review per documentazione  e togliere commenti
    use HasFactory, HasPermissions;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        RoleJson::ID,
        RoleJson::NAME,
        RoleJson::GUARD_NAME,
    ];

    protected $hidden = [
    ];

    public function __construct(array $attributes = [])
    {
        // Imposta il guard_name di default se non fornito
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');
        parent::__construct($attributes);

        // $this->setKeyName(RoleJson::ID); // Se RoleJson::ID è diverso da 'id'
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            // Genera ULID se l'ID non è già impostato (es. da fromEntity)
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Ulid::generate();
            }
            // Verifica l'esistenza di un ruolo con lo stesso nome e guard
            if (static::where(RoleJson::NAME, $model->name)
                ->where(RoleJson::GUARD_NAME, $model->guard_name)
                ->where($model->getKeyName(), '!=', $model->getKey()) // Escludi il modello corrente in caso di update
                ->exists()
            ) {
                throw RoleAlreadyExists::create($model->name, $model->guard_name);
            }
        });
    }

    // Implementazione per ModelEntityConvertable
    public function toEntity(): RoleEntity
    {
        return new RoleEntity(
            id: $this->getKey() instanceof Ulid ? $this->getKey() : new Ulid($this->getKey()),
            name: $this->name,
            guardName: $this->guard_name
        );
    }

    public static function fromEntity(Entity $entity): self // Specificare RoleEntity se possibile
    {
        if (! $entity instanceof RoleEntity) {
            throw new \InvalidArgumentException('Entity must be an instance of RoleEntity.');
        }

        $attributes = [
            RoleJson::NAME => $entity->name,
            RoleJson::GUARD_NAME => $entity->guardName,
        ];

        if ($entity->id) {
            // Assumiamo che getId() restituisca Ulid
            $attributes[(new static)->getKeyName()] = $entity->id->toString();
        }

        // Se l'ID è fornito, potresti voler fare updateOrCreate
        // return self::updateOrCreate([(new static())->getKeyName() => $attributes[(new static())->getKeyName()] ?? null], $attributes);
        return new self($attributes); // Per creare una nuova istanza non salvata
    }

    /**
     * Un ruolo può avere vari permessi.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            config('permission.column_names.role_pivot_key') ?: 'role_id', // Usa il nome della colonna FK per Role
            config('permission.column_names.permission_pivot_key') ?: 'permission_id' // Usa il nome della colonna FK per Permission
        )->withTimestamps(); // Opzionale: se la tabella pivot ha timestamps
    }

    /**
     * Un ruolo appartiene a utenti del modello associato al suo guard.
     */
    public function users(): BelongsToMany
    {
        return $this->morphedByMany(
            getModelForGuard($this->attributes[RoleJson::GUARD_NAME]),
            'model', // Nome della relazione polimorfica (colonne model_type, model_id)
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.role_pivot_key') ?: 'role_id',
            config('permission.column_names.model_morph_key') // Nome della colonna per model_id
        );
    }

    /**
     * Trova un ruolo per nome e guard_name.
     */
    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $role = static::where(RoleJson::NAME, $name)
            ->where(RoleJson::GUARD_NAME, $guardName)
            ->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name, $guardName);
        }

        return $role;
    }

    /**
     * Trova un ruolo per ID e guard_name.
     */
    public static function findById($id, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        // Assumiamo che getKeyName() restituisca il nome corretto della colonna ID (es. 'id' o RoleJson::ID)
        $role = static::where((new static)->getKeyName(), $id)
            ->where(RoleJson::GUARD_NAME, $guardName)
            ->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($id, $guardName);
        }

        return $role;
    }

    /**
     * Trova o crea un ruolo.
     */
    public static function findOrCreate(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $role = static::where(RoleJson::NAME, $name)
            ->where(RoleJson::GUARD_NAME, $guardName)
            ->first();

        if (! $role) {
            // Assicurati che RoleJson::NAME e 'guard_name' siano in $fillable
            return static::query()
                ->create([RoleJson::NAME => $name, RoleJson::GUARD_NAME => $guardName]);
        }

        return $role;
    }

    /**
     * Determina se il ruolo ha un certo permesso.
     * ATTENZIONE: Sovrascrivere questo metodo è complesso.
     * È generalmente meglio affidarsi all'implementazione del tratto HasPermissions.
     */
    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        $effectiveGuardName = $guardName ?? $this->getDefaultGuardName();

        $permissionInstance = null;
        $permissionClass = $this->getPermissionClass(); // Metodo dal tratto HasPermissions

        if (is_string($permission)) {
            $permissionInstance = $permissionClass->findByName($permission, $effectiveGuardName);
        } elseif (is_int($permission) || ($permission instanceof Ulid) || Ulid::isValid((string) $permission)) {
            $permissionInstance = $permissionClass->findById($permission, $effectiveGuardName);
        } elseif ($permission instanceof PermissionContractInterface) {
            $permissionInstance = $permission;
        }

        if (! $permissionInstance) {
            return false;
        }

        // Coerenza del Guard Name: Spatie lancia un'eccezione se i guard non corrispondono.
        // Un ruolo è associato a un guard_name. Se il permesso richiesto è per un guard_name
        // diverso da quello del ruolo (o quello specificato, se rilevante), allora non dovrebbe averlo.
        // La logica di Spatie nel tratto HasPermissions è più elaborata e usa $this->filterPermission().
        // Replicarla esattamente qui è complesso.
        // La semplice verifica di appartenenza alla collezione dei permessi del ruolo è la parte finale.
        // $this->permissions è la collezione dei permessi direttamente assegnati a questo ruolo.
        if ($permissionInstance->getAttribute(RoleJson::GUARD_NAME) !== $effectiveGuardName) {
            // Questo scenario indica che si sta chiedendo se un ruolo con guard 'web'
            // ha un permesso che appartiene al guard 'api'. In genere, la risposta è no.
            // Spatie potrebbe lanciare GuardDoesNotMatch in alcuni contesti.
            // Se il permesso non può esistere per questo guard, non può essere parte del ruolo.
            return false;
        }

        return $this->permissions->contains($permissionInstance->getKeyName(), $permissionInstance->getKey());
    }

    /**
     * Get the class name of the permission model.
     */
    public function getPermissionClass()
    {
        return app(PermissionRegistrar::class)->getPermissionClass();
    }
}
