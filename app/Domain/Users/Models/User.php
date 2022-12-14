<?php

namespace SAAS\Domain\Users\Models;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use SAAS\Domain\Teams\Models\Team;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use SAAS\Domain\Company\Models\Company;
use SAAS\Domain\Subscriptions\Models\Plan;
use SAAS\Domain\Users\Filters\UserFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Miracuthbert\LaravelRoles\Models\Traits\LaravelRolesUserTrait;
use SAAS\App\Traits\Eloquent\Auth\HasConfirmationToken;
use SAAS\App\Traits\Eloquent\Subscriptions\HasSubscriptions;
use SAAS\App\Traits\Eloquent\Auth\HasTwoFactorAuthentication;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,
        LaravelRolesUserTrait,
        Billable,
        HasSubscriptions,
        SoftDeletes,
        HasTwoFactorAuthentication,
        HasApiTokens,
        HasFactory;

    /**
     * The attributes that should be appended to the model.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Filters the result.
     *
     * @param Builder $builder
     * @param $request
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new UserFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Get user's full name as attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Check if user is activated.
     *
     * @return mixed
     */
    public function hasActivated()
    {
        return $this->activated;
    }

    /**
     * Check if user is not activated.
     *
     * @return bool
     */
    public function hasNotActivated()
    {
        return !$this->hasActivated();
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user's team limit reached.
     *
     * @return bool
     */
    public function teamLimitReached()
    {
        return $this->team->users->count() === $this->plan->teams_limit;
    }

    /**
     * Check if current user matches passed user.
     *
     * @param User $user
     * @return bool
     */
    public function isTheSameAs(User $user)
    {
        return $this->id === $user->id;
    }

    /**
     * Get plan that the user is currently on.
     *
     * @return mixed
     */
    public function plan()
    {
        return $this->plans->first();
    }

    /**
     * Get user's plan as a property.
     *
     * @return mixed
     */
    public function getPlanAttribute()
    {
        return $this->plan();
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    /**
     * Get plans owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function plans()
    {
        return $this->hasManyThrough(
            Plan::class,
            Subscription::class,
            'user_id',
            'gateway_id',
            'id',
            'stripe_price'
        )->orderBy('subscriptions.created_at', 'desc');
    }

    /**
     * Get teams that user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')->withTimestamps();
    }

    /**
     * Get roles assigned to the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->using(UserRole::class)
            ->withTimestamps()
            ->withPivot(['expires_at']);
    }

    /**
     * Get user's last accessed company.
     *
     * If using the new tenant switch functionality:
     * Append 'lastAccessedCompany' to model 'appends' property
     * And uncomment lines below
     *
     * @return mixed
     */
    // public function getLastAccessedCompanyAttribute()
    // {
    //    return $this->companies()->orderByDesc('last_login_at')->first();
    // }

    /**
     * Get companies that user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users');
    }
}
