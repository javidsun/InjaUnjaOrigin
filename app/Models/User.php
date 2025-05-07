<?php

namespace App\Models;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Entity;
use App\DTOs\ModelEntityConvertable;
use App\Entities\UserEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\Uid\Ulid;

/**
 * @property Ulid|string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null provider
 * @property string|null provider_id
 */
class User extends Authenticate implements ModelEntityConvertable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Indica se gli ID sono auto-incrementanti.
     * Se usi ULID come chiave primaria, impostalo a false.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Il tipo di dato della chiave primaria.
     * Se usi ULID, impostalo a 'string'.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        UserJson::ID,
        UserJson::NAME,
        UserJson::EMAIL,
        UserJson::PASSWORD,
        UserJson::PROVIDER,
        UserJson::PROVIDER_ID,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        UserJson::PASSWORD,
        'remember_token',
    ];


    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Ulid::generate();
            }
        });
    }

    public function toEntity(): UserEntity
    {
        return new UserEntity(
            id: $this->id instanceof Ulid ? $this->id : new Ulid($this->id), // Assicura che sia un Ulid
            name: $this->name,
            email: $this->email,
            password: null, // Non esporre la password hashata all'entità in questo modo di solito
            provider: $this->provider,
            providerId: $this->provider_id
        );
    }

    public static function fromEntity(UserEntity|Entity $entity): self
    {
        return new self([
            UserJson::ID => $entity->getId()?->toRfc4122(),
            UserJson::NAME => $entity->getName(),
            UserJson::EMAIL => $entity->getEmail(),
            UserJson::PASSWORD => $entity->getPassword() ? Hash::make($entity->getPassword()) : null,
            UserJson::PROVIDER => $entity->getProvider(),
            UserJson::PROVIDER_ID => $entity->getProviderId(),
        ]);
    }

    public function homeAnnouncements(): HasMany
    {
        return $this->hasMany(HomeAnnouncement::class, 'user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
