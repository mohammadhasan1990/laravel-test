<?php

return [
    'enabled' => env('SCRIBE_TDD_ENABLED', true),
    'strategies' => [
        'metadata' => [
            // ...
            AjCastro\ScribeTdd\Strategies\Metadata\GetFromDocBlocksFromScribeTdd::class,
        ],
        'urlParameters' => [
            // ...
            AjCastro\ScribeTdd\Strategies\UrlParameters\GetFromUrlParamTagFromScribeTdd::class,
        ],
        'queryParameters' => [
            // ...
            AjCastro\ScribeTdd\Strategies\QueryParameters\GetFromTestResult::class,
            AjCastro\ScribeTdd\Strategies\QueryParameters\AddPaginationParametersFromScribeTdd::class,
            AjCastro\ScribeTdd\Strategies\QueryParameters\GetFromQueryParamTagFromScribeTdd::class,
        ],
        'headers' => [
            // ...
            AjCastro\ScribeTdd\Strategies\Headers\GetFromHeaderTagFromScribeTdd::class,
        ],
        'bodyParameters' => [
            // ...
            AjCastro\ScribeTdd\Strategies\BodyParameters\GetFromTestResult::class,
            AjCastro\ScribeTdd\Strategies\BodyParameters\GetFromBodyParamTagFromScribeTdd::class,
        ],
        'responses' => [
            // ...
            AjCastro\ScribeTdd\Strategies\Responses\GetFromTestResult::class,
            AjCastro\ScribeTdd\Strategies\Responses\UseResponseTagFromScribeTdd::class,
            AjCastro\ScribeTdd\Strategies\Responses\UseResponseFileTagFromScribeTdd::class,
        ],
        'responseFields' => [
            // ...
            AjCastro\ScribeTdd\Strategies\ResponseFields\GetFromResponseFieldTagFromScribeTdd::class,
        ],
    ],
];
