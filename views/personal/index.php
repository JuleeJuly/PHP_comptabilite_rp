<div class="cont_inline">
    <div class="cont_inline_center">
        <?php echo $data['date'];?>
    </div>
</div>
<h1>Compta Perso</h1>
<hr>
<form method="post" action=''>
    <?php echo "<input type='hidden' name='member_id' value='".$data['member_id']."'>";?>
    <select name="color">
            <option value='bleu'>Bleu</option>
            <option value='vert'>Vert</option>
            <option value='rouge'>Rouge</option>
            <option value='jaune'>Jaune</option>
            <option value='rose'>Rose</option>
            <option value='violet'>Violet</option>
            <option value='orange'>Orange</option>
            <input type="submit" name="validate" value="Valider" class="button">
    </select>
</form>
<hr>
<div class="cont_inline">
    <div class="cont_inline_center">
        <p>Casier</p>
        <hr>
        <p>
            <?php echo $data['total_criminal_record'];
            if($data['total_criminal_record'] > 1){
                echo " lignes";
            }else{
                echo " ligne";
            }?>
        </p>
        <hr>
        <p>
            <?php
                foreach($data['criminal_record'] as $crim_rec){
                    echo date('d/m/Y', strtotime($crim_rec['data']))." ".$crim_rec["heure"]." ".number_format($crim_rec['montant'], 0, ',', ' ');
                }
            ?>
        </p>
    </div>
</div>
<div class="cont_inline">
        <table>
            <tr>
                <th colspan="4">Total</th>
            </tr>
            <tr>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Total sale $</th>
                <th>Total propre $</th>
            </tr>
            <?php
                foreach($data['personal_gains'] as $personal_g){
                    echo "<tr><th>".$personal_g['nom']."</th><td>".number_format($personal_g['quantite'], 0, ',', ' ')."</td><td>".number_format($personal_g['valeur_sale'], 2, ',', ' ')."</td><td>".number_format($personal_g['valeur_propre'], 2, ',', ' ')."</td></tr>";
                }
                foreach($data['personal_expense'] as $personal_e){
                    echo "<tr><th>".$personal_e['nom']."</th><td>".number_format($personal_e['quantite'], 0, ',', ' ')."</td><td></td><td>".number_format($personal_e['valeur_propre'], 2, ',', ' ')."</td></tr>";
                }
                $expense = 0;
                foreach($data['all_personal_penalty'] as $all_personal_p){
                    $expense += $all_personal_p['amende'];
                }
                foreach($data['all_personal_expense'] as $all_personal_e){
                    $expense += $all_personal_e['valeur_propre'];
                }
                foreach($data['all_personal_gains'] as $all_personal_g){
                    echo "<tr><td></td><td></td><th>Total sale</th><td>".number_format($all_personal_g['valeur_sale'], 2, ',', ' ')."</td></tr>";
                    echo "<tr><td></td><td></td><th>Total dépense</th><td>".number_format($expense, 2, ',', ' ')."</td></tr>";
                    echo "<tr><td></td><td></td><th>Total propre</th><td>".number_format(($all_personal_g['valeur_propre']-$expense), 2, ',', ' ')."</td></tr>";
                }
            ?>
        </table>
        <div class='content'>
            <form method="post" action=''> 
                <?php 
                    echo "<input type='hidden' id='member_id' name='member_id' value='".$data['member_id']."'>";
                ?> 
                <h2>Modification</h2>
                <br/>  
                <label for="3">Liasse</label>
                <input type="number" name="liasse" id="3" required>
                <br/>
                <label for="4">Sac</label>
                <input type="number" name="sac" id="4" required>
                <br/>
                <label for="5">March</label>
                <input type="number" name="marchandise" id="5" required>
                <hr>
                <label for="01">Essence</label>
                <input type="number" name="essence" id="1" required>
                <br/>
                <label for="02">Radar</label>
                <input type="number" name="radar" id="2" required>
                <br/>
                <label for="02">Réparation</label>
                <input type="number" name="reparation" id="6" required>
            </form>
        </div>
        <table>
            <tr>
                <th colspan="4">Total Gains</th>
            </tr>
            <tr>
                <th>Item</th>
                <th>Quantité</th>
                <th>Date</th>
                <th>Supprimer</th>
            </tr>
            <?php foreach($data['day_gains'] as $day_g){
                switch($day_g['id_item']){
                    case 3:
                        $item = "Liasse";
                    break;
                    case 4:
                        $item = "Sac";
                    break;
                    case 5:
                        $item = "March";
                    break;
                }
                echo "<tr><td>".$item."</td><td>".number_format($day_g['quantite'], 0, ',', ' ')."</td><td>".date('d/m/Y', strtotime($day_g['data']))."</td><td><input type='button' id='delete_gains_".$day_g['id']."' value='X' class='button'></td></tr>";
                }?>
        </table>
        <table>
            <tr>
                <th colspan="4">Total Dépenses</th>
            </tr>
            <tr>
                <th>Item</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Supprimer</th>
            </tr>
            <?php foreach($data['day_expense'] as $day_e){
                switch($day_e['type']){
                    case 1:
                        $item = "Essence";
                    break;
                    case 2:
                        $item = "Radar";
                    break;
                    case 6:
                        $item = "Réparation";
                    break;
                }
                echo "<tr><td>".$item."</td><td>".number_format($day_e['montant'], 2, ',', ' ')."</td><td>".date('d/m/Y', strtotime($day_e['data']))."</td><td><input type='button' id='delete_expense_".$day_e['id']."' value='X' class='button'></td></tr>";
                }?>
        </table>
</div>
<script src="src/js/personnal.js"></script>