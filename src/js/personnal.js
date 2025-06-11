$(document).ready(function() {
	$('input, select').keypress(function(e) { return e.keyCode != 13; });
	$("input").blur(function(){
		$.ajax({
			type: "POST",
			url: "src/js/update_personnal.php",
			data: {
				id: $(this).attr("id"),
				value: $(this).val(),
				member_id: $("#member_id").val(),
			},success: function(response) {
				location.reload();
			}
		});
	});

	$("input[id*='delete_gains']").click(function(){
		var id = $(this).attr("id").split("_");
		$.ajax({
			type: "POST",
			url: "src/js/update_personnal.php",
			data: {
				delete_gains: id[2],
			},success: function(response) {
                location.reload();
            }
		});
	});

	$("input[id*='delete_expense']").click(function(){
		var id = $(this).attr("id").split("_");
		$.ajax({
			type: "POST",
			url: "src/js/update_personnal.php",
			data: {
				delete_expense: id[2],
			},success: function(response) {
                location.reload();
            }
		});
	});
});