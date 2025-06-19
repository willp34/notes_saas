
jQuery(document).ready(function() {
  

  

  jQuery('.js-data-example-ajax').select2({
	   
  ajax: {
	   transport: function (params, success, failure) {
        const search = params.data.term || '';
		const teamId = jQuery('#team_id').val(); 
        const url = 'http://localhost/notes-saas/public/index.php/api/users/'+teamId+'/'+encodeURIComponent(search); // URL: /users/9/will
			jQuery.ajax({
			  url: url,
			  type: 'GET',
			  dataType: 'json',
			  success: success,
			  error: failure
			});
	   },
	   
	 
    delay: 250,
	
	processResults: function (data) {
		console.log(data); 
		return {
			results: data.items.map(function(user) {
				
				return {
					id: user.id,
					text: user.email
				};
			})
		}; 
	},
	  cache: true
  },

	dropdownParent: jQuery('#teamInviteForm'), // or the modal ID
   placeholder: "Select a user",
   minimumInputLength: 1,
   tags: true,
   tokenSeparators: [',', ' '] // Optional: allow typing multiple values
});


/*
jQuery('.js-data-example-ajax').on('select2:opening select2:closing', function( event ) {
    var $searchfield = jQuery(this).parent().find('.select2-search__field');
    $searchfield.prop('disabled', true);
});   */
});
