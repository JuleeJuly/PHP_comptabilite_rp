<h1>Garage</h1>
<hr>
<div class="content">
    <h2>Liste des véhicules</h2>
	<?php
        $garage_list = $data['garage_list']->fetchAll();
        $members = $data['members']->fetchAll();
		foreach($data['car_list'] as $car){
			echo "<form method='post' action=''>
                    <label>Véhicule</label>
                    <input type='text' name='car_name' value='".$car['vehicule_nom']."'>
                    <label>Plaque</label>
                    <input type='text' name='car_plate' value='".$car['vehicule_plaque']."'>
                    <label>Garage</label>
                    <select name='garage'>";
                    foreach($garage_list as $garage){
                        if($garage['id'] == $car['garage_id']){
                            echo "<option selected value='".$garage['id']."'>".$garage['nom']."</option>";
                        }else{
                            echo "<option value='".$garage['id']."'>".$garage['nom']."</option>";
                        }
                    }
            echo "</select>
            <label>Proprio</label>
            <select name='member'>";
                foreach($members as $member){
                    if($member['id'] == $car['vehicule_membre_id']){
                        echo "<option selected value='".$member['id']."'>".$member['prenom']."</option>";
                    }else{
                        echo "<option value='".$member['id']."'>".$member['prenom']."</option>";
                    }
                }
            echo "<input type='hidden' name='car_id' value='".$car['vehicule_id']."'>
                <input type='submit' class='button' value='Modifier' name='update'>
                <input type='submit' class='button' value='Supprimer' name='delete'>
                </form>";
		}?>
        <hr>
        <h2>Ajouter un véhicule</h2>
        <form method='post' action=''>
            <label>Véhicule</label>
            <input type="text" name="name">
            <label>Plaque</label>
            <input type="text" name="plate">
            <label>Garage</label>
            <select name="garage">
                <?php foreach($garage_list as $garage){
                    echo "<option value='".$garage['id']."'>".$garage['nom']."</option>";
                }?>
            </select>
            <label>Proprio</label>
            <select name="member">
                 <?php foreach($members as $member){
                    echo "<option value='".$member['id']."'>".$member['prenom']."</option>";
                }?>
            </select>
            <input type="submit" class="button" value="Ajouter" name="add">
        </form>
</div>