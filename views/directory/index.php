<h1>Annuaire</h1>
<hr>
<div class="cont_inline">
    <div class="cont_inline_center">
        <table>
            <tr>
                <th colspan="6">Groupe</th>
            </tr>
            <tr>
                <td>Groupe</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Rang</td>
                <td>Numéro</td>
                <td>X</td>
            </tr>
            <?php
                $i = 1;
                foreach($data['groupe_contact'] as $contact){
                    echo "<tr style='color:white;background: rgb(".$contact['couleur'].")'>
                    <td>".$contact['ngroupe']."</td>
                    <td>".$contact['nom']."</td>
                    <td>".$contact['prenom']."</td>
                    <td>".$contact['fonction']."</td>
                    <td>".$contact['num']."</td>
                    <td><input type='button' class='button' id='delete_".$contact['id']."' value='X'></td>
                    </tr>";
                }?>
        </table>
    </div>
    <div class="cont_inline_center">
        <table>
            <tr>
                <th colspan="6">Structure</th>
            </tr>
            <tr>
                <td>Structure</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Rang</td>
                <td>Numéro</td>
                <td>X</td>
            </tr>
            <?php
                $i = 1;
                foreach($data['structure_contact'] as $contact){
                    echo "<tr style='background: rgb(".$contact['couleur'].")'>
                    <td>".$contact['ngroupe']."</td>
                    <td>".$contact['nom']."</td>
                    <td>".$contact['prenom']."</td>
                    <td>".$contact['fonction']."</td>
                    <td>".$contact['num']."</td>
                    <td><input type='button' class='button' id='delete_".$contact['id']."' value='X'></td>
                    </tr>";
                }?>
        </table>
    </div>
    <div class="cont_inline_center">
        <table>
            <tr>
                <th colspan="4">Autres</th>
            </tr>
            <tr>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Numéro</td>
                <td>X</td>
            </tr>
            <?php
                $i = 1;
                foreach($data['other_contact'] as $contact){
                    echo "<tr>
                    <td>".$contact['nom']."</td>
                    <td>".$contact['prenom']."</td>
                    <td>".$contact['num']."</td>
                    <td><input type='button' class='button' id='delete_".$contact['id']."' value='X'></td>
                    </tr>";
                }?>
        </table>
    </div>
</div>
<script src="src/js/directory.js"></script>