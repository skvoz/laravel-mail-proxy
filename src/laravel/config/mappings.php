<?php

use Ramsey\Uuid\Doctrine\UuidGenerator;

return [
    'App\Domain\Email\Email' => [
        'type'   => 'entity',
        'table'  => 'email',
        'id'     => [
            'id' => [
                'type'     => 'integer',
                'generator' => [
                    'strategy' => 'auto'
                ],
            ],
        ],
        'fields' => [
            'target' => [
                'type' => 'string'
            ],
            'subject' => [
                'type' => 'string'
            ],
            'body' => [
                'type' => 'string'
            ],
            'user_id' => [
                'type' => 'integer'
            ],
        ]
    ],
    'App\Domain\Users\Users' => [
            'type'   => 'entity',
            'table'  => 'users',
            'id'     => [
                'id' => [
                    'type'     => 'integer',
                    'generator' => [
                        'strategy' => 'auto'
                    ],
                ],
            ],
            'fields' => [
                'name' => [
                    'type' => 'string'
                ],
                'email' => [
                    'type' => 'string'
                ],
                'password' => [
                    'type' => 'string'
                ],
                'remember_token' => [
                    'type' => 'string'
                ],
                'created_at' => [
                    'type' => 'datetime'
                ],
                'updated_at' => [
                    'type' => 'datetime'
                ],
                'api_token' => [
                    'type' => 'string'
                ],
            ]
        ]
];