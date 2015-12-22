function drop_down_list(){
    var state = $('#state').val();

    if(state == 'AK' || state == 'DC' || state == 'NULL'){ // NULL means outside of U.S, Alaska and District Columbia have no counties
    
    	$('#loading_county_drop_down').hide(); // Hide the Loading...
	    $('#no_county_drop_down').show(); // Show the "no counties" message (if it's the case)
    }else{

	    $('#loading_county_drop_down').show(); // Show the Loading...
	    $('#county_drop_down').hide(); // Hide the drop down
	    $('#no_county_drop_down').hide(); // Hide the "no counties" message (if it's the case)
		
		var jsURL = asset_url+"js/";
    	$.getScript(jsURL+"states/"+ state.toLowerCase() +".js", function(){
	  		populate($("#county")[0]);
			
 			$('#loading_county_drop_down').hide(); // Hide the Loading...
			$('#county_drop_down').show(); // Show the drop down
    	});
	}
}

$(document).ready(function(){
	$("#state").change(drop_down_list);

});

$(window).load(drop_down_list);


function new_drop_down_list(value){
    var state = $('#state').val();

    if(state == 'AK' || state == 'DC' || state == 'NULL'){ // Alaska and District Columbia have no counties
		//$('#county_original').hide();
    	$('#loading_county_drop_down').hide(); // Hide the Loading...
	    $('#no_county_drop_down').show(); // Show the "no counties" message (if it's the case)
    }else{
		$('#county_original').hide(); // Hide the original drop down
		$('#county_drop_down').show(); // Show the drop down
		$('#no_county_drop_down').hide();
		var jsURL = asset_url+"js/";
    	$.getScript(jsURL+"states/"+ state.toLowerCase() +".js", function(){

	  		populate($("#county")[0]);
			//$("#county").val(value);
			$('#loading_county_drop_down').hide();
			$('#county_drop_down').show(); // Show the drop down
    	});
	}
}
