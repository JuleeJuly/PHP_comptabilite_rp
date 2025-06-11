<div class="cont_inline">
    <div class="cont_inline_center">
        <?php echo $data['date'];?>
    </div>
</div>
<div class="content table_count_home"><label>Oseille</label>
	<?php 
		foreach($data['black_box'] as $bb){
			if($bb['total'] >= $bb['seuil_caisse_noir']){
				echo "<label class='debit money'>".number_format($bb['total'], 2, ',', ' ')." $</label>";
			}
			else{
				echo "<label class='credit money'>".number_format($bb['total'], 2, ',', ' ')." $</label>";
			}
		}
	?>
	<hr>
	<?php 
		foreach($data['detail_black_box'] as $dbb){
			switch($dbb['affiche_caisse_accueil']){
				case 1:
					echo "<div><div class='left'><label>".$dbb['grade']." - ".$dbb['nom']." ".$dbb['prenom']." </label></div><div class='right'>";
					if($dbb['caisse_noir'] >= $dbb['seuil_caisse_noir']){
						echo "<label class='debit money'>".number_format($dbb['caisse_noir'], 2, ',', ' ')." $</label>";
					}
					else{
						echo "<label class='credit money'>".number_format($dbb['caisse_noir'], 2, ',', ' ')." $</label>";
					}
					echo "</div></div>";
				break;				
			}
		}
	?>
</div>
<div>
	<form method='post' action='' id="">
		<?php 
			foreach($data['payment_cartel'] as $pc){
				if($pc["valide"] == 0){
					echo "<p>Il faut payer l'envoyé du cartel !</p>";
					echo "<input type='hidden' name='cartel_id' value='".$pc['id']."'>";
					echo "<input type='submit' class='button' name='button_cartel' value='Payé !'>";
				}
				else{
					echo "<p>L'envoyé du cartel est payé.</p>";
				}
			}
		?>
	</form>
	<hr>
	<form method='post' action='' id="">
		<?php 
			foreach($data['blanchi'] as $bl){
				if($bl["valide"] == 0){
					echo "<p>Il faut blanchir !</p>";
					echo "<input type='hidden' name='blanchi_id' value='".$bl['id']."'>";
					echo "<input type='submit' class='button' name='button_blanchi' value='Blanchir !'>";
				}
				else{
					echo "<p>Le blanchi est fait.</p>";
				}
			}
		?>
	</form>
	<hr>
	<form method='post' action='' id="">
		<?php 
			foreach($data['bennys'] as $be){
				if($be["valide"] == 0){
					echo "<p>Il faut payer le Benny's !</p>";
					echo "<input type='hidden' name='bennys_id' value='".$be['id']."'>";
					echo "<input type='submit' class='button' name='button_bennys' value='Payé !'>";
				}
				else{
					echo "<p>Le Benny's est payé.</p>";
				}
			}
		?>
	</form>
</div>
<hr>
<div class="sun">
	<form method='post' action='' id="">
		<input type="text" name="reason" data-testid="input-sun" required>
		<input type="submit" data-testid="button-sun" class="button" name="button_sun" value="1 2 3 SOLEIL">
	</form>
</div>
<div class="content">
	<?php 
		foreach($data['all_sun'] as $sun){
			echo "<label data-testid='total-sun'>".$sun['total']." Soleil(s)</label><br/>";
		}
	?>
	<hr>
	<?php 
		foreach($data['sun'] as $sun){
			echo "<label>".$sun['motif']."</label><label>|  ".date('d/m/Y', strtotime($sun['data']))."</label><input type='button' class='button' data-testid='delete_sun' id='delete_".$sun['id']."' value='X'><br/>";
		}
	?>
</div>
<hr>
<div>
	<form method='post' action='' class="form_home_present">
		<div class="content_home_present">
			<?php
			$i = 1;
			$members = $data['members']->fetchAll();
				foreach($members as $member){
					if($i == 7){
						echo "</div><div class='content_home_present'>";
					}
					echo "<div class='content' data-testid='member_".$member['id']."' id='member_".$member['id']."'><div class='cont_trombine'><img class='trombinoscope' src='".$member['photo']."'></div><label>".$member['nom']." </label><br/><label class='gras'> ".$member['prenom']."</label><br/><label class='small'> ".$member['name']."</label><hr><label class='medium'>CID : ".$member['cid']." </label><hr><label class='medium'>N° ".$member['num']." </label>
					<br/><label class='small'>".$member['date_naissance']." </label><hr>";
					if((int)$member['present'] == 1){
						echo "<div><input data-testid='present_".$member['id']."' id='present_".$member['id']."' type='checkbox' name='present' checked/><label>Présent</label></div></div>";
					}
					else{
						echo "<div><input data-testid='present_".$member['id']."' id='present_".$member['id']."' type='checkbox' name='present' /><label>Présent</label></div></div>";
					}
					$i++;
				}
			?>
		</div>
		<?php echo "<input type='hidden' id='nb_members' value='".$data['nb_members']."'>"; ?>
		<input type='hidden' value='Valider' name="valider" class="button">
	</form>
</div>
<hr>
<table class="desktop">
	<tr><th>LEAD</th><th>Véhicule</th><th>Conducteur</th><th>Passager</th><th>Arriere</th><th>Arriere</th></tr>
	<?php
		foreach($data['operation'] as $op){
			if($op['id'] == 1){
				echo "<tr>";
			}
			else if ($op['id'] == 7 || $op['id'] == 13 || $op['id'] == 19){
				echo "</tr><tr>";
			}
			echo "<td><input type='text' name='operation' value='".$op['id_content']."' data-testid='operation_".$op['id']."' id='operation_".$op['id']."'></td>";
		}
		?>
	</tr>
</table>
<hr>
<table class="desktop">
	<tr>
		<th></th>
		<?php foreach($data['days_war'] as $days){
			echo "<th colspan='2'><input class='input_hidden' name='present_day_war' type='text' id='day_".$days['id']."' value='".$days['nom']."'></th>";
		}
		?>
		<th></th>
	</tr>
	<tr>
		<th></th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th>Ap. midi</th><th>Soir</th>
		<th></th>
	</tr>
	<tr class='impair'>
	<?php
		$count = 1;
		$count_member = 1;
		foreach($data['days_war_members'] as $days_war_member){
			if($count_member == 1){
				echo "<td>".$days_war_member['prenom_membre']."</td>";
			}
			if($days_war_member['apres_midi'] == 1){
				echo "<td><input data-testid='presence_1_".$days_war_member['id']."_".$days_war_member['id_jour']."' id='presence_1_".$days_war_member['id']."_".$days_war_member['id_jour']."' type='checkbox' value='".$days_war_member['apres_midi']."' checked></td>";
			}else{
				echo "<td><input data-testid='presence_1_".$days_war_member['id']."_".$days_war_member['id_jour']."' id='presence_1_".$days_war_member['id']."_".$days_war_member['id_jour']."' type='checkbox' value='".$days_war_member['apres_midi']."'></td>";
			}
			if($days_war_member['soir'] == 1){
				echo "<td><input data-testid='presence_2_".$days_war_member['id']."_".$days_war_member['id_jour']."' id='presence_2_".$days_war_member['id']."_".$days_war_member['id_jour']."' type='checkbox' value='".$days_war_member['soir']."' checked></td>";
			}else{
				echo "<td><input data-testid='presence_2_".$days_war_member['id']."_".$days_war_member['id_jour']."' id='presence_2_".$days_war_member['id']."_".$days_war_member['id_jour']."'  type='checkbox' value='".$days_war_member['soir']."'></td>";
			}
			$count_member++;
			if($count_member > 7){
				echo "<td>".$days_war_member['prenom_membre']."</td></tr>";
				$count_member = 1;
				$count++;
				if($count&1){
					echo "<tr class='impair'>";
				}
			}
		}
	?>
	<tr class='total_present_day_war'>
		<td>Total</td>
		<?php
		for($i = 1; $i <= 7;$i++){
			foreach($data['total_days_war'] as $total_day){
				echo "<td data-testid='total_1_".$total_day['id_jour']."' id='total_1_".$total_day['id_jour']."'>".$total_day['apres_midi']."</td><td data-testid='total_2_".$total_day['id_jour']."' id='total_2_".$total_day['id_jour']."'>".$total_day['soir']."</td>";
			}
		}
		?>
	</tr>
</table>
<script src="src/js/home.js"></script>