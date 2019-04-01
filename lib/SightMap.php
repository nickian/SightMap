<?php

class Sightmap {
	
	private $api_key;
	
	// Set the API key for the object when it's created
	function __construct($api_key) {
		$this->api_key = $api_key;
	}
	
	// use cURL to GET units data
	public function getUnits($url) {
		
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => TRUE,
		    // API_KEY is set in config.php
			CURLOPT_HTTPHEADER => array(
				'API-Key: '.API_KEY
			)
		));
		
		// Get HTTP code and data response
		$result = array(
			// Convert JSON to associative array
			'result' => json_decode(curl_exec($ch), true),
			'status' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
		);
		
		curl_close($ch);
		
		return $result;
		
	}
	
	// Sort the units into a a multi-dimensional array, separating units with
	// area equal to 1 and units with an area greater than one
	public function sortUnits($units, $json=false) {
		
		// This is where we'll put them
		$sorted_units = array(
			'area_1' => array(),
			'area_gt_1' => array(),
		);
		
		// Use these to count totals
		$count_total = 0;
		$count_area_1 = 0;
		$count_area_gt1 = 0;
		
		$paging = $units['result']['paging'];
		
		// Loop through units and decide which list they belong to based on area value
		foreach( $units['result']['data'] as $key => $unit ) {
			// Format "update time" to human-friendly format (e.g., "January 1, 2019 at 12:00 AM")
			$unit['formatted_update_time'] = date('F j, Y \a\t H:i A', strtotime($unit['updated_at']));
			if ( $unit['area'] == 1 ) {
				$sorted_units['area_1'][] = $unit;
				$count_area_1++;
			} elseif ( $unit['area'] > 1 ) {
				$sorted_units['area_gt_1'][] = $unit;
				$count_area_gt1++;
			}
			$count_total++;
		}
		
		// Number of units counted
		$sorted_units['count']['total'] = $count_total;
		$sorted_units['count']['area_1'] = $count_area_1;
		$sorted_units['count']['area_gt_1'] = $count_area_gt1;
		
		// Add paging data
		$sorted_units['paging'] = $paging;
		
		// Sort the units with area > 1 in ascending order
		$sorted_units['area_gt_1'] = $this->sortByArea($sorted_units['area_gt_1']);
		
		if ( $json == true ) {
			return json_encode($sorted_units, JSON_PRETTY_PRINT);
		} else {
			return $sorted_units;
		}
		
	}
	
	// Sort units by area in ascending order
	public function sortByArea($units, $order=SORT_ASC) {
		foreach ($units as $key => $unit) {
		    $sorted[$key] = $unit['area'];
		}
		array_multisort($sorted, $order, $units);
		return $units;
	}
	
}