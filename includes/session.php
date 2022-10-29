<?php
ob_start();
$maxlifetime = 60*30; //30 minuti
$secure = true;
$httponly = true;
$samesite = "lax";

ini_set("session.use_cookies","On");

ini_set("session.use_only_cookies","On");

ini_set("session.use_strict_mode","On");

ini_set("session.cookie_httponly","On");

ini_set("session.cookie_secure","On");

ini_set("session.use_trans_sid","Off");

ini_set("session.cache_limiter","nocache");

ini_set("session.sid_length","48");

ini_set("session.sid_bits_per_charachter","6");

ini_set("session.hash_function","sha256");

ini_set("session.name","session");

/*
session_set_cookie_params($lifetime);
session_set_cookie_params(["SameSite" => "Strict"]); //none, lax,strict
session_set_cookie_params(["Secure" => "true"]); //false, true
session_set_cookie_params(["HttpOnly" => "true"]); //false, true

*/
session_set_cookie_params([
            'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);

session_start();
session_regenerate_id();
session_gc();
?>