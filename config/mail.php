<?php

return [

    

    'default' => env('MAIL_MAILER', 'smtp'),

    

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'sandbox.smtp.mailtrap.io'),
            'port' => env('MAIL_PORT', 2525),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME', '84dea8bb07cf55'),
            'password' => env('MAIL_PASSWORD', 'd154e964127692'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', 'localhost'),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            'client' => [
                'timeout' => 5,
            ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],

    ],

   
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'carservice@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Car Service Center'),
    ],

];
