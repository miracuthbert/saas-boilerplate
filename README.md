# saas-boilerplate
This is a SaaS boilerplate built on top of the Laravel framework. 
Built to provide developers with a template to kickoff their SaaS application,
without the hustle for repetitive tasks such as user account setup, subscriptions 
and role management.

## features
- Authentication
    - Login / Registration
    - Email Activation
    - Two Factor Login (only when enabled)
- Subscription with Stripe
    - User plans
    - Team plans
- Account (User Account)
    - Profile Update
    - Change Password
    - Two Factor Authentication
    - Subscription
        - Cancel Subscription
        - Resume Subscription
        - Swap Plan
        - Update Card
    - API Tokens
- Admin
    - User Management
        - Manage User Roles
    - Role & Permissions Management
- Developer Panel
    - Manage OAuth Clients
    - Manage Personal Access Tokens   
- Other features
    - Filtering (extendable)
    - API access (starter template)

*Note: Some features may be subjected to change. Other features may not be listed 
since they are under development or do not qualify as a standard / main SaaS feature. 
Some common features will not be listed as well.*

## usage
1. Fork, clone or download this repository.
2. Run `composer install` if its the initial setup or `composer update`.
3. Setup your environment keys in .env 
    (*If .env does not exist then copy / rename .env.example as .env*)
4. Run `php artisan app:name` to set the name (namespace) of your app. 
    (*Remember not to live any spaces*)
5. Run `php artisan migrate` for initial tables setup.
6. `Optional` Run `php artisan db:seed --class=RoleTableSeeder` to set the initial 
    roles and permissions if you opt to use the initial user and roles management.

## libraries & packages
- Main
    - PHP (>=7.1.3)
    - Laravel (Minimal 5.6)
    - Laravel Cashier (can be switched)
- UI (can be switched)
    - Bootstrap (v4)
    - Font awesome
    - Simple Line Icons
    - jQuery
    - VueJs
    - Development
        - nodejs
        - npm

## services
- Stripe (payment gateway)
- Authy by Twilio (two factor authentication)