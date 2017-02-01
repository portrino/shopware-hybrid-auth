<?php

/**
 * Adapted HybridAuth config file for Port1HybridAuth shopware plugin
 */
$hybridauthLib = $_SERVER['DOCUMENT_ROOT'] . '/custom/plugins/Port1HybridAuth/vendor/hybridauth/hybridauth/';

return
    [
        "base_url" => "http://localhost/hybridauth-git/hybridauth/",
        "providers" => [
            "Google" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""],
                "scope" => ""
            ],
            "Facebook" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""],
                "scope" => []
            ],
            // windows live
            "Live" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""],
                'redirect_uri' => ''
            ],
            "LinkedIn" => [
                "enabled" => true,
                "keys" => ["key" => "", "secret" => ""],
                "fields" => []
            ],
            "Amazon" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""],
            ],
        ],
        // If you want to enable logging, set 'debug_mode' to true.
        // You can also set it to
        // - "error" To log only error messages. Useful in production
        // - "info" To log info and error messages (ignore debug messages)
        "debug_mode" => false,
        // Path to file writable by the web server. Required if 'debug_mode' is not false
        "debug_file" => "",
    ];
