$(window).on("load",function(){
	$(".container").fadeIn();
});

$(document).ready(function(e){
	$('#submitForm').click(function(e){
		e.preventDefault();

		$("#disp").html('');
		$('#showMatch').val('N');
		$("#sessMove").val('N');

		stream();

	});

	$('#sessExec').click(function(e){
		e.preventDefault();
		$("#disp").html('');
		$("#sessMove").val('Y');
		$('#showMatch').val('N');

		stream();
	});

	$('#showFiles').click(function(e){
		e.preventDefault();

		$("#disp").html('');
		$('#showMatch').val('Y');
		$("#sessMove").val('N');

		stream();

	});

});//Document ready close

function stream(){

	if (!window.XMLHttpRequest){
	    alert("Your browser does not support the native XMLHttpRequest object.");
	    return;
	}
	try{
	    var xhr = new XMLHttpRequest();  
	    // var previous_text = '';
	    var form_data = $("#form").serialize();
	                                 
	    xhr.onerror = function() { alert("[XHR] Fatal Error."); };
	    xhr.onreadystatechange = function() {
	        try{
	        	$("#loader").show();
	            if (xhr.readyState == 4){
	            	$("#loader").hide();
	                console.log('[XHR] Done');
	            } 
	            else if (xhr.readyState > 2){
	                // var new_response = xhr.responseText.substring(previous_text.length);
	                // var result = new_response;
	                 console.log(xhr.responseText);
	               
	                            
	              $("#disp").html(xhr.responseText);
	                // document.getElementById('progressor').style.width = result + "%";
	                            
	                // previous_text = xhr.responseText;
	            }  
	        }
	        catch (e){
	            console.log("[XHR STATECHANGE] Exception: " + e);
	        }                     
	    };
	    xhr.open("POST", "Mover.php", true);
	    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    xhr.send(form_data);      
	}
	catch (e){
	    console.log("[XHR REQUEST] Exception: " + e);
	}
}