<?php

return [

    'default' => 'api',

    'module' => [
        'admin' => [
            'api' => [
                'title' => 'Swagger Lume Admin Doc',
            ],

            'routes' => [
                'api' => '/documentation',
                'docs' => '/docs',
                'oauth2_callback' => '/oauth2-callback',
                'assets' => '/swagger-ui-assets',
                'middleware' => [
                    'api' => [],
                    'asset' => [],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
            ],

            'paths' => [
                'docs' => storage_path('admin-docs'),
                'docs_json' => 'admin-docs.json',
                'annotations' => base_path('app/admin'),
                'excludes' => [],
                'base' => env('L5_SWAGGER_BASE_PATH', null),
                'views' => base_path('resources/views/vendor/swagger-lume'),
                'yaml_annotations' => base_path('app/admin'),
            ],
        ],
        'api' => [
            'api' => [
                'title' => 'Swagger Lume Api Doc',
            ],

            'routes' => [
                'api' => '/documentation',
                'docs' => '/docs',
                'oauth2_callback' => '/oauth2-callback',
                'assets' => '/swagger-ui-assets',
                'middleware' => [
                    'api' => [],
                    'asset' => [],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
            ],

            'paths' => [
                'docs' => storage_path('api-docs'),
                'docs_json' => 'api-docs.json',
                'annotations' => base_path('app/api'),
                'excludes' => [],
                'base' => env('L5_SWAGGER_BASE_PATH', null),
                'views' => base_path('resources/views/vendor/swagger-lume'),
                'yaml_annotations' => base_path('app/api'),
            ],
        ]
    ],

    'common' => [
        'security' => [
            /*
            |--------------------------------------------------------------------------
            | Examples of Security definitions
            |--------------------------------------------------------------------------
            */
            /*
            'api_key_security_example' => [ // Unique name of security
                'type' => 'apiKey', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                'description' => 'A short description for security scheme',
                'name' => 'api_key', // The name of the header or query parameter to be used.
                'in' => 'header', // The location of the API key. Valid values are "query" or "header".
            ],
            'oauth2_security_example' => [ // Unique name of security
                'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                'description' => 'A short description for oauth2 security scheme.',
                'flow' => 'implicit', // The flow used by the OAuth2 security scheme. Valid values are "implicit", "password", "application" or "accessCode".
                'authorizationUrl' => 'http://example.com/auth', // The authorization URL to be used for (implicit/accessCode)
                //'tokenUrl' => 'http://example.com/auth' // The authorization URL to be used for (password/application/accessCode)
                'scopes' => [
                    'read:projects' => 'read your projects',
                    'write:projects' => 'modify projects in your account',
                ]
            ],*/

            /* Open API 3.0 support
            'passport' => [ // Unique name of security
                'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                'description' => 'Laravel passport oauth2 security.',
                'in' => 'header',
                'scheme' => 'https',
                'flows' => [
                    "password" => [
                        "authorizationUrl" => config('app.url') . '/oauth/authorize',
                        "tokenUrl" => config('app.url') . '/oauth/token',
                        "refreshUrl" => config('app.url') . '/token/refresh',
                        "scopes" => []
                    ],
                ],
            ],
            */
        ],

        /*
        |--------------------------------------------------------------------------
        | Turn this off to remove swagger generation on production
        |--------------------------------------------------------------------------
         */
        'generate_always' => env('SWAGGER_GENERATE_ALWAYS', false),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the swagger version number
        |--------------------------------------------------------------------------
         */
        'swagger_version' => env('SWAGGER_VERSION', '3.0'),

        /*
        |--------------------------------------------------------------------------
        | Edit to trust the proxy's ip address - needed for AWS Load Balancer
        |--------------------------------------------------------------------------
         */
        'proxy' => false,

        /*
        |--------------------------------------------------------------------------
        | Configs plugin allows to fetch external configs instead of passing them to SwaggerUIBundle.
        | See more at: https://github.com/swagger-api/swagger-ui#configs-plugin
        |--------------------------------------------------------------------------
        */

        'additional_config_url' => null,

        /*
        |--------------------------------------------------------------------------
        | Apply a sort to the operation list of each API. It can be 'alpha' (sort by paths alphanumerically),
        | 'method' (sort by HTTP method).
        | Default is the order returned by the server unchanged.
        |--------------------------------------------------------------------------
        */

        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),

        /*
        |--------------------------------------------------------------------------
        | Uncomment to pass the validatorUrl parameter to SwaggerUi init on the JS
        | side.  A null value here disables validation.
        |--------------------------------------------------------------------------
        */

        'validator_url' => null,

        /*
        |--------------------------------------------------------------------------
        | Uncomment to add constants which can be used in anotations
        |--------------------------------------------------------------------------
         */
        'constants' => [
            // 'SWAGGER_LUME_CONST_HOST' => env('SWAGGER_LUME_CONST_HOST', 'http://my-default-host.com'),
        ],
    ],
];
