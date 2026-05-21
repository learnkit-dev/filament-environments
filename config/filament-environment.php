<?php

return [
    'mapping' => [
        'local' => '#FFDB58',
        'dev' => '#FFDB58',
        'staging' => '#D2042D',
        'prod' => '#4169E1',
        'production' => '#4169E1',
    ],

    'production' => [
        'prod', 'production',
    ],

    /*
     * How to display the environment indicator.
     * Supported values: 'bar', 'badge', 'both'.
     */
    'display' => env('FILAMENT_ENVIRONMENT_DISPLAY', 'bar'),
];
