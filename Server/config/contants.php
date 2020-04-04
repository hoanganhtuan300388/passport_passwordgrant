<?php
if (!defined('GRANT_TYPE_PASSWORD'))
    define('GRANT_TYPE_PASSWORD', 'password');

if (!defined('CLIENT_ID_PASSWORD'))
    define('CLIENT_ID_PASSWORD', 2);

if (!defined('CLIENT_SECRET_PASSWORD'))
    define('CLIENT_SECRET_PASSWORD', 'gl5EdPx6OuUWGEzd23JMtFLYd1aZGoKEaOjQNXiW');

if (!defined('QR_CODE_SIZE_DEFAULT'))
    define('QR_CODE_SIZE_DEFAULT', 200);

if (!defined('STATUS_OK'))
    define('STATUS_OK', 200);

if (!defined('STATUS_CREATED'))
    define('STATUS_CREATED', 201);

if (!defined('STATUS_BAD_REQUEST'))
    define('STATUS_BAD_REQUEST', 400);

if (!defined('STATUS_UNAUTHORIZED'))
    define('STATUS_UNAUTHORIZED', 401);

if (!defined('STATUS_NOT_FOUND'))
    define('STATUS_NOT_FOUND', 404);

if (!defined('STATUS_METHOD_ALLOWED'))
    define('STATUS_METHOD_ALLOWED', 405);

if (!defined('STATUS_PAGE_EXPIRED'))
    define('STATUS_PAGE_EXPIRED', 419);

if (!defined('STATUS_INVALID_TOKEN'))
    define('STATUS_INVALID_TOKEN', 498);

if (!defined('STATUS_TOKEN_REQUIRED'))
    define('STATUS_TOKEN_REQUIRED', 499);

if (!defined('STATUS_SERVER_ERROR'))
    define('STATUS_SERVER_ERROR', 500);
