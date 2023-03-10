<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 */
ini_set('short_open_tag', '1');
ini_set('display_errors', (SUBDOMAIN == "dev" || HOSTNAME == "api.dev.paypara.co" || SUBDOMAIN == "deploy" ? 1 : 1));
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING & ~E_NOTICE & ~LOG_NOTICE & ~E_USER_WARNING & ~E_RECOVERABLE_ERROR);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow changes throughout
 | the system. It's not widely used currently, and may not survive
 | release of the framework.
 */
$isDebugMode = ($_SERVER['REQUEST_URI'] !== '/' && (in_array(SUBDOMAIN, ['dev', 'deploy']) || HOSTNAME === 'api.dev.paypara.co'));

defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', $isDebugMode);
defined('CI_DEBUG') || define('CI_DEBUG', $isDebugMode);
