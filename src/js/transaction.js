$(document).ready(function() {
	for(var i = 1; i <=10 ; i++){
		$("#bleaching_rate_"+i+"").css("display","none");
		$("label[for=bleaching_rate_"+i+"").css("display","none");
	}

	$('input, select').keypress(function(e) { return e.keyCode != 13; });

	$("#add_item").click(function () {
		//verifier qui est display none
		//afficher le prochain none en block
		for(var i = 2; i <=10 ; i++){
			var test = $(".hidden_"+i);
			if(test.css('display') == 'none'){
				test.css("display","block");
				i = 11;
			}
		}
	});	

	$("#delete_item").click(function () {
		//verifier qui est display none
		//afficher le prochain none en block
		for(var i = 10; i >=2 ; i--){
			var test = $(".hidden_"+i);
			if(test.css('display') == 'block'){
				test.css("display","none");
				$("#quantity_"+i+"").val("");
				$("#weight_"+i+"").val("");
				$("#amount_"+i+"").val("");
				$("#bleaching_rate_"+i+"").val("");
				i = 1;
			}
		}
	});

	$("input").click(function(){
		/*-------VALIDER TRANSACTION----------*/
		if($(this).attr("name") === "order_validate"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					order_validate: id[2],
				},success: function(response) {
                    location.reload();
				}
			});	
		}
		/*-------SUPPRIMER TRANSACTION----------*/
		else if($(this).attr("name") === "order_delete"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					order_delete: id[2],
				},success: function(response) {
                    location.reload();
				}
			});
		}
	});

	$("input").blur(function(){
		if($(this).attr("name") === "pocket_item"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					pocket_item: id[2],
					value: $(this).val(),
				},success: function(response) {
					location.reload();
				}
			});
		}
	});

	$("input").blur(function(){
		if($(this).attr("name") === "pocket_member_item"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					pocket_member_item: id[3],
					value: $(this).val(),
				},success: function(response) {
					location.reload();
				}
			});
		}
	});

	$("input").blur(function(){
		if($(this).attr("name") === "pocket_vehicle_item"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					pocket_vehicle_item: id[3],
					value: $(this).val(),
				},success: function(response) {
					location.reload();
				}
			});
		}
	});

	/************************************************/
	$("select[id*='item']").change(function (){
		var id = $(this).attr('id').split('_');
		var recover_item = $("select#item_"+id[1]+"").children('option:selected').val();
		if(recover_item == 13){
			$("label[for=bleaching_rate_"+id[1]+"").css("display","inline-block");
			$("#bleaching_rate_"+id[1]+"").css("display","inline-block");
			recover_bleaching_rate(id[1]);
		}
		else{
			$("label[for=bleaching_rate_"+id[1]+"").css("display","none");
			$("#bleaching_rate_"+id[1]+"").css("display","none");
			price_calculation(id[1]);
		}
		weight_calculation(id[1]);
    });

	$("input[id*='quantity']").blur(function(){
		var id = $(this).attr('id').split('_');
		price_calculation(id[1]);
		weight_calculation(id[1]);
	});

	$("select[name='group']").change(function (){
		for(var i = 1; i <=10 ; i++){
			var recover_item = $("select#item_"+i+"").children('option:selected').val();
			if(recover_item == 13){
				recover_bleaching_rate(i);
			}else{
				price_calculation(i);
			}
		}
	});

	$("select[id*='price']").change(function (){
		var id = $(this).attr('id').split('_');
		price_calculation(id[1]);
	});

	$("select[id*='dirty_own']").change(function (){
		var id = $(this).attr('id').split('_');
		price_calculation(id[2]);
	});

	$("select[id*='purchase_sale']").change(function (){
		var id = $(this).attr('id').split('_');
		var recover_item = $("select#item_"+id[2]+"").children('option:selected').val();
		if(recover_item == 13){
			recover_bleaching_rate(id[2]);
		}else{
			price_calculation(id[2]);
		}
	});

	$("input[id*='bleaching_rate']").blur(function(){
		var id = $(this).attr('id').split('_');
		price_calculation(id[2]);
	});

	function weight_calculation(id){
		var recover_item = $("select#item_"+id+"").children('option:selected').val();
		var quantity = $('#quantity_'+id+'').val();
		if(quantity != 0 || quantity !== ""){
			$.ajax({
				type: "POST",
				url: "src/js/update_transaction.php",
				data: {
					weight_calculation: recover_item,
					quantity: quantity
				},success: function(response) {
					$('#weight_'+id+'').val(response.weight);
				}
			});
		}
	}

	function recover_bleaching_rate(i){
		var group = $('select#group').children('option:selected').val();
		var purchase_sale = $("select#purchase_sale_"+i+"").children('option:selected').val();
		var recover_item = $("select#item_"+i+"").children('option:selected').val();
		$.ajax({
			type: "POST",
			url: "src/js/update_transaction.php",
			data: {
				bleaching_rate: recover_item,
				group: group,
				purchase_sale: purchase_sale
			},success: function(response) {
				$('#bleaching_rate_'+i+'').val(response.bleaching_rate);
				price_calculation(i);
			}
		});
	}

	function price_calculation(i){
		var dirty_own = $("select#dirty_own_"+i+"").children('option:selected').val();
		var group = $('select#group').children('option:selected').val();
		var price = $('select#price_'+i+'').children('option:selected').val();
		var recover_item = $("select#item_"+i+"").children('option:selected').val();
		var bleaching_rate = $("#bleaching_rate_"+i+"").val();
		var quantity = $("#quantity_"+i+"").val();
		var purchase_sale = $("select#purchase_sale_"+i+"").children('option:selected').val();
		$.ajax({
			type: "POST",
			url: "src/js/update_transaction.php",
			data: {
				price_calculation: recover_item,
				dirty_own: dirty_own,
				group: group,
				price: price,
				bleaching_rate: bleaching_rate,
				quantity: quantity,
				purchase_sale: purchase_sale
			},success: function(response) {
				$("#amount_"+i+"").val(response.amount);
			}
		});
	}

});