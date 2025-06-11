$(document).ready(function() {
    /*****Instanciation de la couleur*****/
    var couleur = $('#couleur').val();
	var color = "#000000";
	var color2 = "#000000";
	switch(couleur){
		case "rouge":
			color = "#850606";
			color2 = "#370000";
		break;
		case "bleu":
			color = "#2a596e";
			color2 = "#042838";
		break;
		case "vert":
			color = "#30783a";
			color2 = "#01450a";
		break;
		case "rose":
			color = "#90315b";
			color2 = "#490121";
		break;
		case "jaune":
			color = "#c59900";
			color2 = "#9b7800";
		break;
		case "violet":
			color = "#552c72";
			color2 = "#24053a";
		break;
        case "orange":
			color = "#e27a04";
			color2 = "#b66000";
		break;
	    default:
			color = "#2a596e";
			color2 = "#042838";
		break;
	}
    /*****Affichage de la couleur de fond des membres s'ils sont présents ou non*****/
    var nbChamp = $("#nb_members").val();
	for(i=1; i <= nbChamp ; i++){
		if($('#present_'+i).is(":checked")){
			$('#member_'+i).css("background-color",color);
	    	$('#member_'+i).css("color","white");
		}
		else{
			$("#member_"+i).css("background-color","#f7f7f7");
	    	$('#member_'+i).css("color",color2);
		}
	}
    /*****Mise à jour de la couleur de fond des membres au click*****/
    $("input:checkbox").click(function(){
		//var present = $(this).attr('id').split('_');
        var val = $(this).attr('id').split('_');
        switch(val[0]){
            case "present":
                var color = "#000000";
                var color2 = "#000000";
                switch(couleur){
                    case "rouge":
                        color = "#850606";
                        color2 = "#370000";
                    break;
                    case "bleu":
                        color = "#2a596e";
                        color2 = "#042838";
                    break;
                    case "vert":
                        color = "#30783a";
                        color2 = "#01450a";
                    break;
                    case "rose":
                        color = "#90315b";
                        color2 = "#490121";
                    break;
                    case "jaune":
                        color = "#c59900";
                        color2 = "#9b7800";
                    break;
                    case "violet":
                        color = "#552c72";
                        color2 = "#24053a";
                    break;
                    case "orange":
                        color = "#e27a04";
                        color2 = "#b66000";
                    break;
                    default:
                        color = "#2a596e";
                        color2 = "#042838";
                    break;
                }
                var value = 0;
                if($(this).is(':checked')){
                    $('#member_'+val[1]).css("background-color",color);
                    $('#member_'+val[1]).css("color","white");
                    value = 1;
                }
                else{
                    $("#member_"+val[1]).css("background-color","#f7f7f7");
                    $('#member_'+val[1]).css("color",color2);
                    value = 0;
                }	
                $.ajax({
                    type: "POST",
                    url: "src/js/update_home.php",
                    data: {
                        action: "update_present",
                        id_member: val[1],
                        value: value
                    },success: function(response) {}
                });		
            break;
            case "presence":
                var value = 0;
                if($(this).is(':checked')){
                    value = 1;
                }else{
                    value = 0;
                }	
                $.ajax({
                    type: "POST",
                    url: "src/js/update_home.php",
                    data: {
                        action: "update_present_day_war",
                        id_day_presence: val[2],
                        moment: val[1],
                        value: value,
                        id_day: val[3]
                    },
                    success: function(response) {
                        $("#total_"+val[1]+"_"+val[3]+"").text(response.total);
                    }
                });	
            break;
        }
	});

    /*****Mise à jour du tableau d'operation*****/
    $("input").blur(function(){
		if($(this).attr("name") === "operation"){
			var id = $(this).attr("id").split("_");
			$.ajax({
				type: "POST",
				url: "src/js/update_home.php",
				data: {
                    action: "update_operation",
					id_operation: id[1],
					value: $(this).val(),
				},success: function(response) {}
			});
		}
        else if($(this).attr("name") === "present_day_war"){
            var id = $(this).attr('id').split('_');
			$.ajax({
				type: "POST",
				url: "src/js/update_home.php",
				data: {
                    action: "update_present_day_war_text",
					id_day: id[1],
					value: $(this).val(),
				},success: function(response) {}
			});	
        }
	});

    /*****Supprimer un soleil*****/
	$("input[id*='delete']").click(function(){
		var sun = $(this).attr('id').split('_');
		$.ajax({
			type: "POST",
			url: "src/js/update_home.php",
			data: {
                action: "delete_sun",
				id_sun: sun[1],
			},success: function(response) {
				location.reload();
			}
		});	
	});

});