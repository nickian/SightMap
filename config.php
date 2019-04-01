<?php
// Where this app is accessed
define('APP_URL', 'https://nick.do/sightmap');
// API key to use in cURL header
define('API_KEY', '7d64ca3869544c469c3e7a586921ba37');
// URL to make requests from the API
define('API_BASE_URL', 'https://api.sightmap.com/v1/assets/1273/multifamily/units');
// Valid options for the drop down per-page select element
define('VALID_PER_PAGE', array(25, 50, 100, 250, 500));

// Autoload any classes in the lib folder
function __autoload($class) {
    require_once(__DIR__.'/lib/'.$class.'.php');
}