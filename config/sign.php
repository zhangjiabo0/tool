<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'v2free' => [
        [
            'email'=> env('V2FREE_1_EMAIL'),
            'passwd'=> env('V2FREE_1_PASSWD'),
        ],
        [
            'email'=> env('V2FREE_2_EMAIL'),
            'passwd'=> env('V2FREE_2_PASSWD'),
        ],
    ],

    'aliyunpan' => [
        [
            'mobile'=> env('ALIYUNPAN_1_MOBILE'),
            'refresh_token'=> env('ALIYUNPAN_1_REFRESH_TOKEN'),
        ],
    ],


];
