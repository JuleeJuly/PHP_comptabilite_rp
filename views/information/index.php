<div class="cont_inline">
    <div class="cont_inline_center">
        <?php echo $data['date'];?>
    </div>
</div>
<hr>
<div class="cont_inline">
    <div class="cont_inline_center">
        <h2>Ajouter une info</h2>
		<form method='post' action=''>
			<label for='title'>Sujet *</label>
			<input type="text" name="title" id="title" required>
			<br/>
			<label for='group'>Groupe</label>
			<select name="group" id='group'>
				<option></option>
                <?php
                    foreach($data['group_list'] as $group){
                        echo "<option value=".$group['id'].">".$group['nom']."</option>";
                    }
                ?>
			</select>
			<br/>
			<label for='content'>Contenu *</label>
		    <textarea name="content" id="content" required></textarea>
		    <br/>
			<input type="submit" value="Valider" name="validate" id="valider" class="button">
		</form>
    </div>
</div>
<hr>
<div class="cont_flex">
    
        <?php foreach($data['information_list'] as $info){
            echo "<div class='info_mobile'>
                    <form method='post' action=''>
                    <div class='info_mobile_title'>
                        <h2><input class='input_hidden' type='text' name='title' value='".$info['titre']."'></h2>
                    </div>
                    <div class='info_mobile_name'>
                        <h3>".$info['nom']."</h3>
                    </div>
                    <div class='info_mobile_content'>
                        <textarea name='content'>".$info['contenu']."</textarea>
                    </div>
                    <div class='info_mobile_infos'>
                        <p>".date('d/m/Y', strtotime($info['data']))." - ".$info['heure']." - ".$info['createur']."</p>
                    </div>
                    <div class='info_mobile_button'>
                        <input type='hidden' name='id' value='".$info['id']."'>
                        <input type='submit' class='button' name='update' value='Modifier'>
                    </div>
                    </form>
                    <form method='post' action=''>
                        <input type='hidden' name='id' value='".$info['id']."'>
                        <input type='submit' class='button' name='delete' value='Supprimer'>
                    </form>
                </div>";
        }?>
    
</div>