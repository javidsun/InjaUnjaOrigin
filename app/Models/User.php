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
    public $incrementing = false; // Importante per chiavi non numeriche auto-incrementanti

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
        'id', // Se generi e imposti l'ULID prima di chiamare create()
        UserJson::NAME,
        UserJson::EMAIL,
        UserJson::PASSWORD, // !!! AGGIUNGI QUESTO !!!
        UserJson::PROVIDER, // Aggiungi se lo imposti via mass assignment
        UserJson::PROVIDER_ID, // Aggiungi se lo imposti via mass assignment
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        UserJson::PASSWORD,
        'remember_token', // Tipicamente nascosto
    ];

    // Aggiungi un mutator per l'ID se usi Ulid per assicurarti che sia trattato correttamente
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
            $this->id instanceof Ulid ? $this->id : new Ulid($this->id), // Assicura che sia un Ulid
            $this->name,
            $this->email,
            null, // Non esporre la password hashata all'entità in questo modo di solito
            $this->provider,
            $this->provider_id
        );
    }

    public static function fromEntity2(UserEntity|Entity $entity): self
    {
        // /TODO : ho dubbio di questo devo sapere ci sta o no
        return new self([
            UserJson::ID => $entity->getId()?->toRfc4122(),
            UserJson::NAME => $entity->getName(),
            UserJson::EMAIL => $entity->getEmail(),
            UserJson::PASSWORD => $entity->getPassword() ? Hash::make($entity->getPassword()) : null,
            UserJson::PROVIDER => $entity->getProvider(),
            UserJson::PROVIDER_ID => $entity->getProviderId(),
        ]);
    }

    public static function fromEntity(UserEntity|Entity $entity): self
    {
        $data = [
            UserJson::NAME => $entity->getName(),
            UserJson::EMAIL => $entity->getEmail(),
        ];
        if ($entity->getId()) { // Se l'ID è già nell'entità (es. per un update)
            $data[UserJson::ID] = $entity->getId()->toString(); // o toRfc4122() se preferisci quel formato per la stringa
        }
        if ($entity->getPassword()) {
            $data[UserJson::PASSWORD] = Hash::make($entity->getPassword());
        }
        if ($entity->getProvider()) {
            $data[UserJson::PROVIDER] = $entity->getProvider();
        }
        if ($entity->getProviderId()) {
            $data[UserJson::PROVIDER_ID] = $entity->getProviderId();
        }
        // return new self($data); // Se gli attributi sono in $fillable
        // Oppure, se il repository si occupa di creare/trovare e poi popolare:
        $model = new self;
        $model->id = $data[UserJson::ID] ?? (string) Ulid::generate(); // Assicura che l'ID sia settato
        $model->name = $data[UserJson::NAME];
        $model->email = $data[UserJson::EMAIL];
        if (isset($data[UserJson::PASSWORD])) {
            $model->password = $data[UserJson::PASSWORD];
        }
        if (isset($data[UserJson::PROVIDER])) {
            $model->provider = $data[UserJson::PROVIDER];
        }
        if (isset($data[UserJson::PROVIDER_ID])) {
            $model->provider_id = $data[UserJson::PROVIDER_ID];
        }

        return $model;
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
