<script>
	  <!-- Script para autocompletar -->
	  $(document).ready(function(){
		  $.urlParam = function(name){
		  var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		  if(results != null)
		  	return results[1] || 0;
		  else {
			  $.getJSON( "{{path('amigos') }}",
				        function(data){
				    	var amigos = [];
				    	$.each(data.amigos, function(i,item){
					    	 amigos.push(item.username);    	
				            	});	
				    	$( "#etiquetar" ).autocomplete({
			                source: amigos    	
				    		});
				          });
			  }
		  }

		  var user = $.urlParam('user') || null;
		  if(user != null) {
		  $('#message_recipient').val(user);
		  $('#recipientContainer').hide();
		  $('#recipientUser').html('Mensaje para ' +user);
		  }
		  });	
	  </script>