<?php

require_once('config.php');

// Create a new SightMap object
$sightmap = new SightMap(API_KEY);

// Determine the URL for the request
if ( 
	(isset($_GET['per-page']) && in_array($_GET['per-page'], VALID_PER_PAGE)) && 
	(isset($_GET['page']) && is_numeric($_GET['page'])) 
) {
	$url = API_BASE_URL.'?per-page='.$_GET['per-page'].'&page='.$_GET['page'];
	$per_page = $_GET['per-page'];
} elseif ( isset($_GET['per-page']) && in_array($_GET['per-page'], VALID_PER_PAGE) ) {
	$url = API_BASE_URL.'?per-page='.$_GET['per-page'];
	$per_page = $_GET['per-page'];
} elseif ( isset($_GET['page']) && is_numeric($_GET['page']) ) {
	$url = API_BASE_URL.'?page='.$_GET['page'];
	$per_page = 100;
} else {
	$url = API_BASE_URL;
	$per_page = 100;
}

// Get units from the API
$units = $sightmap->getUnits($url);

// cURL response successful
if ( $units['status'] == 200 ) {

	$paging = $units['result']['paging'];

	// Return JSON
	if ( isset($_GET['format']) && $_GET['format'] == 'json' ) {
		
		header('Content-Type: application/json');
		echo $sightmap->sortUnits($units, true);
	
	// Return HTML
	} else {
		
		$units = $sightmap->sortUnits($units, false);
		
		if ( $units['count']['total'] == 0 ) {
			header('Location: '.APP_URL);
			exit();
		}
		
		if ( $paging['next_url'] != null ) {
			$next_page = $paging['current_page'] + 1;
		} else {
			$next_page = null;
		}
		
		if ( $paging['prev_url'] != null ) {
			$previous_page = $paging['current_page'] - 1;
		}

		require_once('view.php');	
	}

// cURL response failed
} else {
	die('Error connecting to API via cURL: ' . $units['status']);
}