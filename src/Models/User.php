<?php

declare(strict_types=1);

namespace Rinvex\Fort\Models;

use Rinvex\Fort\Traits\HasRoles;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Rinvex\Fort\Traits\CanVerifyEmail;
use Rinvex\Fort\Traits\CanVerifyPhone;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Support\Traits\HasHashables;
use Illuminate\Notifications\Notifiable;
use Rinvex\Fort\Traits\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Fort\Traits\AuthenticatableTwoFactor;
use Rinvex\Fort\Contracts\CanVerifyEmailContract;
use Rinvex\Fort\Contracts\CanVerifyPhoneContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Rinvex\Fort\Contracts\CanResetPasswordContract;
use Rinvex\Fort\Contracts\AuthenticatableTwoFactorContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Rinvex\Fort\Models\User.
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $username
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property string                                                                                                         $email
 * @property bool                                                                                                           $email_verified
 * @property \Carbon\Carbon                                                                                                 $email_verified_at
 * @property string                                                                                                         $phone
 * @property bool                                                                                                           $phone_verified
 * @property \Carbon\Carbon                                                                                                 $phone_verified_at
 * @property string                                                                                                         $name_prefix
 * @property string                                                                                                         $first_name
 * @property string                                                                                                         $middle_name
 * @property string                                                                                                         $last_name
 * @property string                                                                                                         $name_suffix
 * @property string                                                                                                         $job_title
 * @property string                                                                                                         $country_code
 * @property string                                                                                                         $language_code
 * @property array                                                                                                          $two_factor
 * @property string                                                                                                         $birthday
 * @property string                                                                                                         $gender
 * @property bool                                                                                                           $is_active
 * @property \Carbon\Carbon                                                                                                 $last_activity
 * @property \Carbon\Carbon                                                                                                 $created_at
 * @property \Carbon\Carbon                                                                                                 $updated_at
 * @property \Carbon\Carbon                                                                                                 $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\Ability[]                                         $abilities
 * @property-read \Illuminate\Support\Collection                                                                            $all_abilities
 * @property-read \Rinvex\Country\Country                                                                                   $country
 * @property-read \Rinvex\Language\Language                                                                                 $language
 * @property-read string                                                                                                    $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\Role[]                                            $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\Session[]                                    $sessions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\Socialite[]                                  $socialites
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereEmailVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereNamePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereNameSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User wherePhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereTwoFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Model implements UserContract, AuthenticatableContract, AuthenticatableTwoFactorContract, AuthorizableContract, CanResetPasswordContract, CanVerifyEmailContract, CanVerifyPhoneContract
{
    use HasRoles;
    use Notifiable;
    use Authorizable;
    use HasHashables;
    use CanVerifyEmail;
    use CanVerifyPhone;
    use Authenticatable;
    use ValidatingTrait;
    use CanResetPassword;
    use CacheableEloquent;
    use AuthenticatableTwoFactor;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'username',
        'password',
        'two_factor',
        'email',
        'email_verified',
        'email_verified_at',
        'phone',
        'phone_verified',
        'phone_verified_at',
        'name_prefix',
        'first_name',
        'middle_name',
        'last_name',
        'name_suffix',
        'job_title',
        'country_code',
        'language_code',
        'birthday',
        'gender',
        'is_active',
        'last_activity',
        'abilities',
        'roles',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'username' => 'string',
        'password' => 'string',
        'two_factor' => 'json',
        'email' => 'string',
        'email_verified' => 'boolean',
        'email_verified_at' => 'datetime',
        'phone' => 'string',
        'phone_verified' => 'boolean',
        'phone_verified_at' => 'datetime',
        'name_prefix' => 'string',
        'first_name' => 'string',
        'middle_name' => 'string',
        'last_name' => 'string',
        'name_suffix' => 'string',
        'job_title' => 'string',
        'country_code' => 'string',
        'language_code' => 'string',
        'birthday' => 'string',
        'gender' => 'string',
        'is_active' => 'boolean',
        'last_activity' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'two_factor',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'abilities',
        'roles',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The attributes to be encrypted before saving.
     *
     * @var array
     */
    protected $hashables = [
        'password',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.fort.tables.users'));
        $this->setRules([
            'username' => 'required|alpha_dash|min:3|max:150|unique:'.config('rinvex.fort.tables.users').',username',
            'password' => 'sometimes|required|min:'.config('rinvex.fort.password_min_chars'),
            'two_factor' => 'nullable|array',
            'email' => 'required|email|min:3|max:150|unique:'.config('rinvex.fort.tables.users').',email',
            'email_verified' => 'sometimes|boolean',
            'email_verified_at' => 'nullable|date',
            'phone' => 'nullable|numeric|min:4',
            'phone_verified' => 'sometimes|boolean',
            'phone_verified_at' => 'nullable|date',
            'name_prefix' => 'nullable|string|max:150',
            'first_name' => 'nullable|string|max:150',
            'middle_name' => 'nullable|string|max:150',
            'last_name' => 'nullable|string|max:150',
            'name_suffix' => 'nullable|string|max:150',
            'job_title' => 'nullable|string|max:150',
            'country_code' => 'nullable|alpha|size:2|country',
            'language_code' => 'nullable|alpha|size:2|language',
            'birthday' => 'nullable|date_format:Y-m-d',
            'gender' => 'nullable|string|in:m,f',
            'is_active' => 'sometimes|boolean',
            'last_activity' => 'nullable|date',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $user) {
            foreach (array_intersect($user->getHashables(), array_keys($user->getAttributes())) as $hashable) {
                if ($user->isDirty($hashable) && Hash::needsRehash($user->$hashable)) {
                    $user->$hashable = Hash::make($user->$hashable);
                }
            }
        });
    }

    /**
     * Register a validating user event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function validating($callback)
    {
        static::registerModelEvent('validating', $callback);
    }

    /**
     * Register a validated user event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    public static function validated($callback)
    {
        static::registerModelEvent('validated', $callback);
    }

    /**
     * Get the active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    /**
     * Get the inactive users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $builder): Builder
    {
        return $builder->where('is_active', false);
    }

    /**
     * A user may have multiple direct abilities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        return $this->belongsToMany(config('rinvex.fort.models.ability'), config('rinvex.fort.tables.ability_user'), 'user_id', 'ability_id')
                    ->withTimestamps();
    }

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('rinvex.fort.models.role'), config('rinvex.fort.tables.role_user'), 'user_id', 'role_id')
                    ->withTimestamps();
    }

    /**
     * A user may have many sessions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(config('rinvex.fort.models.session'), 'user_id', 'id');
    }

    /**
     * A user may have multiple socialites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialites(): HasMany
    {
        return $this->hasMany(config('rinvex.fort.models.socialite'), 'user_id', 'id');
    }

    /**
     * Get name attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        $segments = [$this->name_prefix, $this->first_name, $this->middle_name, $this->last_name, $this->name_suffix];

        return trim(implode(' ', $segments));
    }

    /**
     * Get all abilities of the user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllAbilitiesAttribute()
    {
        return $this->abilities->merge($this->roles->pluck('abilities')->collapse());
    }

    /**
     * Determine if the user is super admin.
     *
     * @return bool
     */
    public function isSuperadmin()
    {
        return $this->getAllAbilitiesAttribute()->where('resource', 'global')->where('policy', null)->contains('action', 'superadmin');
    }

    /**
     * Determine if the user is protected.
     *
     * @return bool
     */
    public function isProtected()
    {
        return in_array($this->id, config('rinvex.fort.protected.users'));
    }

    /**
     * Route notifications for the authy channel.
     *
     * @return int
     */
    public function routeNotificationForAuthy()
    {
        if (! ($authyId = array_get($this->getTwoFactor(), 'phone.authy_id')) && $this->getEmailForVerification() && $this->getPhoneForVerification() && $this->getCountryForVerification()) {
            $result = app('rinvex.authy.user')->register($this->getEmailForVerification(), preg_replace('/[^0-9]/', '', $this->getPhoneForVerification()), $this->getCountryForVerification());
            $authyId = $result->get('user')['id'];

            // Prepare required variables
            $twoFactor = $this->getTwoFactor();

            // Update user account
            array_set($twoFactor, 'phone.authy_id', $authyId);

            $this->fill(['two_factor' => $twoFactor])->forceSave();
        }

        return $authyId;
    }

    /**
     * Get the user's country.
     *
     * @return \Rinvex\Country\Country
     */
    public function getCountryAttribute()
    {
        return country($this->country_code);
    }

    /**
     * Get the user's language.
     *
     * @return \Rinvex\Language\Language
     */
    public function getLanguageAttribute()
    {
        return language($this->language_code);
    }

    /**
     * Attach the user roles.
     *
     * @param mixed $roles
     *
     * @return void
     */
    public function setRolesAttribute($roles)
    {
        static::saved(function (self $model) use ($roles) {
            $model->roles()->sync($roles);
        });
    }

    /**
     * Attach the user abilities.
     *
     * @param mixed $abilities
     *
     * @return void
     */
    public function setAbilitiesAttribute($abilities)
    {
        static::saved(function (self $model) use ($abilities) {
            $model->abilities()->sync($abilities);
        });
    }

    /**
     * Active the user.
     *
     * @return $this
     */
    public function activate(): self
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the user.
     *
     * @return $this
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}
