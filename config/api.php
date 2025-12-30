<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Doctor Appointment API
    |
    */

    'version' => 'v1',

    'prefix' => 'api',

    /*
    |--------------------------------------------------------------------------
    | API Response Settings
    |--------------------------------------------------------------------------
    */

    'response' => [
        'success_status' => 'success',
        'error_status' => 'error',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    */

    'pagination' => [
        'per_page' => 15,
        'max_per_page' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Date/Time Format
    |--------------------------------------------------------------------------
    */

    'datetime_format' => 'Y-m-d H:i:s',
    'date_format' => 'Y-m-d',
    'time_format' => 'H:i:s',

    /*
    |--------------------------------------------------------------------------
    | Appointment Settings
    |--------------------------------------------------------------------------
    */

    'appointment' => [
        'slot_duration' => 30, // minutes
        'advance_booking_days' => 30, // how many days in advance can book
        'cancellation_hours' => 24, // minimum hours before appointment to cancel
    ],

];
