<div class="cont_inline">
    <div class="cont_inline_center">
        <?php echo $data['date'];
			$all_items = $data['all_items']->fetchAll();
			$members = $data['members']->fetchAll();
			$all_pocket_item_name = $data['all_pocket_item_name']->fetchAll();
		?>
    </div>
</div>
<hr>
<div class="cont_inline">
	<div class="cont_inline_center">
		<form method="post" action=''>
			<table class='pocket_table'>
				<tr>
					<th>Membres</th>
					<?php	
					foreach($all_pocket_item_name as $apin){
						echo "<th><input class='pochepair' name='pocket_item' type='text' id='pocket_item_".$apin['id']."' value='".$apin['nom_item']."'></th>";
					}?>
				</tr>
				<tr><th>Total</th>
					<?php	
					foreach($all_pocket_item_name as $apin){
						echo "<th><input class='total_pocket' name='total_pocket' type='text' id='total_pocket_".$apin['id']."' value='' disabled></th>";
					}?>
				</tr>
					<?php	
					$i = 1;
					foreach($data['all_pocket_item_member'] as $apim){
						echo "<tr><th>".$apim['prenom']."</th>";
						if($i%2 == 1){
							echo "<td><input class='pocheimpair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_liasse']."' value='".$apim['liasse']."'></td>";
							echo "<td><input class='pocheimpair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_sac']."' value='".$apim['sac']."'></td>";
							echo "<td><input class='pocheimpair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_march']."' value='".$apim['march']."'></td>";
						}else{
							echo "<td><input class='pochepair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_liasse']."' value='".$apim['liasse']."'></td>";
							echo "<td><input class='pochepair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_sac']."' value='".$apim['sac']."'></td>";
							echo "<td><input class='pochepair' name='pocket_member_item' type='text' id='pocket_member_item_".$apim['id_march']."' value='".$apim['march']."'></td>";
						}
						echo "</tr>";
						$i++;
					}
					foreach($data['all_pocket_item_vehicle'] as $apiv){
						echo "<tr><th>Véhicule</th>";
						echo "<td><input type='text' class='pocheimpair' name='pocket_vehicle_item'  id='pocket_vehicle_item_".$apiv['id_liasse']."' value='".$apiv['liasse']."'></td>";
						echo "<td><input type='text' class='pocheimpair' name='pocket_vehicle_item' id='pocket_vehicle_item_".$apiv['id_sac']."' value='".$apiv['sac']."'></td>";
						echo "<td><input type='text' class='pocheimpair' name='pocket_vehicle_item' id='pocket_vehicle_item_".$apiv['id_march']."' value='".$apiv['march']."'></td>";
						echo "</tr>";
					}?>
				</table>
				<input type="submit" value="Vider" name="delete_pocket" id="delete_pocket" class="button">
		</form>
	</div>
    <div class="cont_inline_center">
    	<h2>Transactions</h2>
			<form method="post" action='' class="form_transaction">
				<div>
					<div class='left'>
						<label for='group'>Client</label>
					</div>
					<div class='right'>
						<select name="group" id='group'>
		       				<option value="0"> </option>
							<?php
								foreach($data['group_list'] as $group){
									echo "<option value=".$group['id'].">".$group['nom']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for='member'>Payeur</label>
					</div>
					<div class='right'>
						<select name="member" id='member'>
							<?php
								foreach($members as $member){
									echo "<option value=".$member['id'].">".$member['prenom']." - ".$member['nom']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="comment">Commentaire</label>
					</div>
					<div class='right'>
						<textarea name="comment" id="comment"></textarea>
					</div>
				</div>				
				<hr>
				<!------Item--------->
				<div>
					<div class='left'>
						<label for='item_1'>Item</label>
					</div>
					<div class='right'>
						<select name="item_1" id="item_1" >
			        		<option value="0"> </option>
							<?php
								foreach($all_items as $item){
									echo "<option value=".$item['id'].">".$item['nom']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="quantity_1">Quantité</label>
					</div>
					<div class='right'>
						<input type="number" name="quantity_1" id="quantity_1" required>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="weight_1">Poids</label>
					</div>
					<div class='right'>
						<input type="number" name="weight_1" id="weight_1" step='0.01' required>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for='price_1'>Tarifs</label>
					</div>
					<div class='right'>
						<select name="price_1" id="price_1">
							<option value="1">Nos tarifs</option>
							<option value="0">Tarif client</option>
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="puchase_sale_1">Achat/vente</label>
					</div>
					<div class='right'>
						<select name="puchase_sale_1" id="puchase_sale_1">
							<option value="purchase">Achat</option>
							<option value="sale">Vente</option>
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="bleaching_rate_1">Tx blanchi</label>
					</div>
					<div class='right'>
						<input type="text" name="bleaching_rate_1" id="bleaching_rate_1" step='0.01'>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="dirty_own_1">Sale / Propre</label>
					</div>
					<div class='right'>
						<select name="dirty_own_1" id="dirty_own_1">
							<option value="dirty">Sale</option>
							<option value="own">Propre</option>	
						</select>
					</div>
				</div>
				<div>
					<div class='left'>
						<label for="amount_1">Montant</label>
					</div>
					<div class='right'>
						<input type="number" name="amount_1" id="amount_1" step='0.1'>
					</div>
				</div>
				<div>
					<div class='left'>
						<input value="-" class="button_plus" id="delete_item">
					</div>
					<div class='right'>
						<input value="+" class="button_plus" id="add_item">
					</div>
				</div>
				<?php
					for($i = 2; $i <= 10; $i++){
						echo "
						<div class='hidden_".$i."'>
							<div>
								<div class='left'>
									<label for='item_".$i."'>Item</label>
								</div>
								<div class='right'>
									<select name='item_".$i."' id='item_".$i."'>
				        				<option value='0'> </option>";
										foreach($items as $item){
											echo "<option value=".$item['id'].">".$item['nom']."</option>";
										}
									echo "
									</select>
								</div>
							</div>
						<div>
						<div class='left'>
							<label for='quantity_".$i."'>Quantité</label>
						</div>
						<div class='right'>
							<input type='number' name='quantity_".$i."' id='quantity_".$i."'>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='weight_".$i."'>Poids</label>
						</div>
						<div class='right'>
							<input type='number' name='weight_".$i."' id='weight_".$i."' step='0.01'>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='price_".$i."'>Tarifs</label>
						</div>
						<div class='right'>
							<select name='price_".$i."' id='price_".$i."'>
								<option value='1'>Nos tarifs</option>
								<option value='0'>Tarif client</option>
							</select>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='puchase_sale_".$i."'>Achat/vente</label>
						</div>
						<div class='right'>
							<select name='puchase_sale_".$i."' id='puchase_sale_".$i."'>
								<option value='purchase'>Achat</option>
								<option value='sale'>Vente</option>
							</select>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='bleaching_rate_".$i."'>Tx blanchi</label>
						</div>
						<div class='right'>
							<input type='text' name='bleaching_rate_".$i."' id='bleaching_rate_".$i."' step='0.01'>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='dirty_own_".$i."'>Sale / Propre</label>
						</div>
						<div class='right'>
							<select name='dirty_own_".$i."' id='dirty_own_".$i."'>
								<option value='dirty'>Sale</option>
								<option value='own'>Propre</option>
							</select>
						</div>
					</div>
					<div>
						<div class='left'>
							<label for='amount_".$i."'>Montant</label>
						</div>
						<div class='right'>
							<input type='number' name='amount_".$i."' id='amount_".$i."' step='0.1'>
						</div>
					</div>
					<hr>
				</div>";
				}?>
			<input type="submit" value="Valider" name="validate" class="button">
		</form>
	</div>
</div>
<hr>
<div style="display:inline-block">
	<form method='post' action=''>
		Nb transac/pages : <input type="number" min="5" max="100" name="number_transac">
		<input type="submit" name="validate_number_transac" value="Valider" class="button">
	</form>
</div>
<menu class="pagination">
	<!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
	<?php for($page = 1; $page <= $data['pages']; $page++): ?>
		<!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
		<li class="page-item">
			<a class="button <?= ($data['current_page'] == $page) ? "active" : "" ?>" href="transaction?page=<?= $page ?>"><?= $page ?></a>
		</li>
	<?php endfor ?>
</menu>
<div style="display:inline-block">
	<form method='post' action=''>
		<select name="sort">
			<option value="groupe">Par groupe</option>
			<option value="date">Par date</option>
		</select>
		<input type="submit" name="sort_validate" value="Trier" class="button">
	</form>
</div>
<hr>
<div class="cont_inline_flex">
<?php 
    foreach($data['orders'] as $order){
        echo "<div class='transac_mobile'>
				<div class='a'><label class='poids'>Transac n° ".$order['id']."</label>
				</div>
			<div class='b1'>
				<label>".date('d-m-Y', strtotime($order['data']))." </label>
				<label class='transac_groupe' style='background-color:rgb(".$order['couleur'].")'>".$order['client']."</label>
				<label class='transac_label'>Débit sale</label>
				<label class='transac_debit'>".number_format($order['debit_sale'], 2, ',', ' ')."</label>
				<label class='transac_label'>Débit propre</label>
				<label class='transac_debit'>".number_format($order['debit_propre'], 2, ',', ' ')."</label>
				<label class='transac_label'>Poids achat</label>
				<label class='transac_poids'>".number_format($order['poids_achat'], 2, ',', ' ')."</label>
			</div>
			<div class='b2'></div>
			<div class='b3'>
				<label>".$order['heure']."</label>
				<label class='transac_poids'>".$order['prenom']."</label>
				<label class='transac_label'>Crédit sale</label>
				<label class='transac_credit'>".number_format($order['credit_sale'], 2, ',', ' ')."</label>
				<label class='transac_label'>Crédit propre</label>
				<label class='transac_credit'>".number_format($order['credit_propre'], 2, ',', ' ')."</label>
				<label class='transac_label'>Poids vente</label>
				<label class='transac_poids'>".number_format($order['poids_vente'], 2, ',', ' ')."</label>
			</div>
			<div class='c1'>
				<label>".$order['commentaire']."</label>
			</div>
			<div class='c2'>
				<label class='transac_label'>Heure validation</label>
				<label>".$order['heure_valide']."</label>
			</div>";
            if($order['valide'] == 1){
				echo "<div class='c3'><label class='debit'>Validé</label></div>";
			}else{
				echo "<div class='c3'></div>";
			}
            $i = 1;
			foreach($order['details'] as $detail){
				$alpha = "d";
				switch($i){
					case 1:
						$alpha = "d";
					break;
					case 2:
						$alpha = "e";
					break;
					case 3:
						$alpha = "f";
					break;
					case 4:
						$alpha = "g";
					break;
					case 5:
						$alpha = "h";
					break;
				}
				echo "<div class='".$alpha."1'>
						<label  class='transac_poids'>".$detail['type']."</label>
						<label  class='transac_label'>Item</label>
						<label  class='transac_poids'>".$detail['item']."</label>
						<label class='transac_label'>Débit</label>
						<label  class='transac_debit'>".number_format($detail['debit'], 2, ',', ' ')."</label>
						<label>".$lc['heure_valide']."</label>
						<br/>
						</div>
						<div class='".$alpha."2'>
							<label>  </label><br/>
							<label class='transac_label'>Quantité</label>
							<label  class='transac_poids'>".$detail['quantite']."</label>
							<label class='transac_label'>Crédit</label>
							<label  class='transac_credit'>".number_format($detail['credit'], 2, ',', ' ')."</label>
						    <br/><br/>
						</div>
						<div class='".$alpha."3'>
							<label  class='transac_poids'>".$detail['sale_propre']."</label>
							<label class='transac_label'>Poids</label>
							<label  class='transac_poids'>".number_format($detail['poids'], 2, ',', ' ')." Kg</label>
							<label class='transac_label'>Taux blanchi</label>
							<label   class='transac_poids'>".$detail['tx_blanchi']."</label>";
						if($detail['valide'] == 0){
						    echo "<input id='order_validate_".$detail['id']."' type='' name='order_validate' value='Valider' class='transac_valide'><input id='order_delete_".$detail['id']."' type='' name='order_delete' value='X' class='transac_supprime'></div>";
						}else{
						    echo "<label>Validé</label></div>";
						}
					$i++;
			    }
			echo "</div>";
    }
?>
</div>
<script src="src/js/transaction.js"></script>