<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 3/6/2018
 * Time: 6:16 PM
 *
 * Holds custom app settings
 */
return [
    'cashier' => [
        'currency' => env('CASHIER_CURRENCY'),
        'symbol' => env('CASHIER_CURRENCY_SYMBOL'),
    ]
];