// Make API request on server-side and append results to HTML list data
function api_request(per_page, current_page) {
	
	// Make AJAX regquest
	var request = $.get(window.location.href, {
		'format':'json', 
		'per-page': per_page, 
		'page': current_page
	});
	
	// Request was successful
	request.done(function(data) {
    	
		console.log(data);
		
		// If we didn't find anything, redirect/restart to default settings
		if ( data.count.total == 0 ) {
			window.location = window.location.href.split('?')[0]+'?per-page='+per_page+'&page=1';
		// Found at least one unit to parse
		} else {
			// Reset the lists
			$('ul').html('');
			// Update count on column header
			$('section#area-1 header span').text(data.count.area_1);
			$('section#area-gt-1 header span').text(data.count.area_gt_1);
			// Append units to column lists
			$.each( data.area_1, function( index, value ) {
				$('section#area-1 ul').append('<li><strong>Unit '+value.unit_number+'</strong> \('+value.area+' ft<sup>2</sup>)<small>Last updated on '+value.formatted_update_time+'</small></li>');
			});
			$.each( data.area_gt_1, function( index, value ) {
				$('section#area-gt-1 ul').append('<li><strong>Unit '+value.unit_number+'</strong> ('+value.area+' ft<sup>2</sup>)<small>Last updated on '+value.formatted_update_time+'</small></li>');
			});
			// Update next/previous buttons
			if ( current_page != 1 ) {
				$('#restart').show();
				$('#restart').attr('href', window.location.href.split('?')[0]+'?per-page='+per_page+'&page=1');
			} else {
				$('#restart').hide();
			}
			if ( data.paging.next_url ) {
				var next_page = current_page + 1;
				$('#next span').text(next_page);
				$('#next').attr('href', window.location.href.split('?')[0]+'?per-page='+per_page+'&page='+next_page);
				$('#next').show();
			} else {
				$('#next').hide();
			}
			if ( data.paging.prev_url ) {
				var previous_page = current_page - 1;
				$('#previous span').text(previous_page);
				$('#previous').attr('href', window.location.href.split('?')[0]+'?per-page='+per_page+'&page='+previous_page);
				$('#previous').show();
			} else {
				$('#previous').hide();
			}
		}
		
	});
	// AJAX request failed
	request.fail(function() {
		alert('Error retrieving AJAX data.');
		console.log('Error retrieving AJAX data.');

	});
	// Always hide the loading overlay when we're done
	request.always(function() {
		$('#loading').fadeOut();
	});
}

// Event listener for select dropdown
$('body').on('change', '#per-page', function() {
	if ( Number.isInteger(parseInt($(this).val())) ) {
		$('#loading').show();
		per_page = $(this).val();
		api_request(per_page, current_page);
	}
});

// Event listener for previous and next buttons
$('body').on('click', 'nav a', function(e) {
	
	e.preventDefault();
	$('#loading').show();
	
	if ( $(this).attr('id') == 'next' ) {
		$(window).scrollTop(0);
		api_request(per_page, current_page + 1);
		current_page++;
		
	} else if ( $(this).attr('id') == 'previous' ) {
		$(window).scrollTop(0);
		api_request(per_page, current_page - 1);
		current_page--;
		
	} else if ( $(this).attr('id') == 'restart' ) {
		$(window).scrollTop(0);
		current_page = 1
		api_request(per_page, current_page);
	}

	$('span#current-page').text('Page '+current_page);
		
});

// Hide a couple things once we know we have JavaScript enabled
$(document).ready(function(){
	$('#submit-button').hide();
	$('#loading').hide();	
});
