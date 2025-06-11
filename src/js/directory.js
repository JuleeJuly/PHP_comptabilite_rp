$(document).ready(function() {
	$("input[id*='delete']").click(function(){
		var delete_id = $(this).attr('id').split('_');
		$.ajax({
			type: "POST",
			url: "src/js/update_directory.php",
			data: {
				id: delete_id[1],
			},success: function(response) {
				location.reload();
			}
		});	
	});
});