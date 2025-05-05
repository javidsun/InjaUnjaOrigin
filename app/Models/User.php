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
 * @property Ulid $id
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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id',
        UserJson::NAME,
        UserJson::EMAIL,
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        UserJson::PASSWORD,
        UserJson::PROVIDER,
        UserJson::PROVIDER_ID,
    ];

    public function toEntity(): UserEntity
    {
        return new UserEntity(
            new Ulid($this->id),
            $this->name,
            $this->email,
            $this->password,
            $this->provider,
            $this->provider_id
        );
    }

    public static function fromEntity(UserEntity|Entity $entity): self
    {
        ///TODO : ho dubbio di questo devo sapere ci sta o no
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
