<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 3/9/2018
 * Time: 3:05 PM
 */

namespace SAASBoilerplate\App\TwoFactor;

use Exception;
use GuzzleHttp\Client;
use SAASBoilerplate\Domain\Users\Models\User;

class Authy implements TwoFactor
{
    /**
     * Holds GuzzleHttp Client.
     * To handle API requests.
     *
     * @var Client
     */
    protected $client;

    /**
     * Authy constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Registers a user.
     *
     * @param User $user
     * @return mixed
     */
    public function register(User $user)
    {
        try {
            $response = $this->client->request(
                'POST',
                'https://api.authy.com/protected/json/users/new?api_key=' . config('services.authy.secret'),
                [
                    'form_params' => [
                        'user' => $this->getTwoFactorRegistrationDetails($user)
                    ]
                ]
            );
        } catch (Exception|\Throwable $e) {
            return false;
        }

        return json_decode($response->getBody(), false);
    }

    /**
     * Validates user's token.
     *
     * @param User $user
     * @param $token
     * @return mixed
     */
    public function validateToken(User $user, $token)
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://api.authy.com/protected/json/verify/' . $token . '/' . $user->twoFactor->identifier .
                '?force=true&api_key=' . config('services.authy.secret')
            );
        } catch (Exception|\Throwable $e) {
            return false;
        }

        $response = json_decode($response->getBody(), false);

        return $response->token === 'is valid';
    }

    /**
     * Removes user from the 'auth provider' app.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        try {
            $response = $this->client->request(
                'POST',
                'https://api.authy.com/protected/json/users/delete/' . $user->twoFactor->identifier . '?api_key='
                . config('services.authy.secret')
            );
        } catch (Exception|\Throwable $e) {
            return false;
        }

        return true;
    }

    /**
     * Returns user's  registration details.
     *
     * @param User $user
     * @return array
     */
    protected function getTwoFactorRegistrationDetails(User $user)
    {
        return [
            'email' => $user->email,
            'cellphone' => $user->twoFactor->phone,
            'country_code' => $user->twoFactor->dial_code,
        ];
    }
}