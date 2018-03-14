<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 3/6/2018
 * Time: 12:46 PM
 */

namespace SAASBoilerplate\App\Traits\Eloquent\Subscriptions;


trait HasSubscriptions
{
    /**
     * Check if user has team subscription.
     *
     * @return bool
     */
    public function hasTeamSubscription()
    {
        return optional($this->plan)->isForTeams();
    }

    /**
     * Check if user has no team subscription.
     *
     * @return bool
     */
    public function doesNotHaveTeamSubscription()
    {
        return !$this->hasTeamSubscription();
    }

    /**
     * Check if user has subscription based as a team member.
     *
     * @return bool
     */
    public function hasPiggybackSubscription()
    {
        foreach ($this->teams as $team) {
            if ($team->owner->hasSubscription()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has subscription.
     *
     * @return mixed
     */
    public function hasSubscription()
    {
        if ($this->hasPiggybackSubscription()) {
            return true;
        }

        return $this->subscribed('main');
    }

    /**
     * Check if user has no subscription.
     *
     * @return bool
     */
    public function doesNotHaveSubscription()
    {
        // TODO: Uncheck lines below
        // if user is allowed to have a subscription
        // on top of a piggyback subscription

        // if($this->hasPiggybackSubscription()) {
        //     return true;
        // }

        return !$this->hasSubscription();
    }

    /**
     * Check if user has cancelled subscription.
     *
     * @return bool
     */
    public function hasCancelled()
    {
        return optional($this->subscription('main'))->cancelled();
    }

    /**
     * Check if user has not cancelled subscription.
     *
     * @return bool
     */
    public function hasNotCancelled()
    {
        return !$this->hasCancelled();
    }

    /**
     * Check if user is customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        /**
         * Use line below if you don't want to be limited to a single payment gateway
         * $this->hasCardOnFile()
         */
        return $this->hasStripeId();
    }
}