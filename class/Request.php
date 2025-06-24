<?php
    class Request{
        /***********PARAMETRAGE***********/
        public function select_settings(){
            $req = Bdd::Cbdd()->prepare('SELECT * FROM new_parametrage');
			$req->execute();
			return $req;
        }
        /***********CONNEXION***********/
        public function select_identifiers($login){
            $req = Bdd::Cbdd()->prepare('SELECT login,password,id_statut,couleur 
            FROM new_connexion 
            INNER JOIN new_membre ON new_connexion.id_membre = new_membre.id 
            WHERE login=:login and new_membre.archive = 0');
			$req->execute(array('login'=>$login));
			return $req;
        }
        /***********INFORMATION***********/
        public function recover_group(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_structure 
            WHERE new_structure.archive = 0');
			$req->execute();
			return $req;
        }
        public function recover_member_id_by_login($login){
            $req = Bdd::Cbdd()->prepare('SELECT id_membre 
            FROM new_connexion 
            WHERE login=:login');
			$req->execute(array('login'=>$login));
			return $req;
        }
        public function add_information($id_author,$title,$group,$content){
            $day_date = date('Y-m-d');
            $hour = date( "H:i:s", time());
            $req = Bdd::Cbdd()->prepare('INSERT INTO new_infos (id_createur,titre,id_groupe,contenu,data,heure) VALUES (:id_author,:title,:id_group,:content,:data,:heure)');
			$req->execute(array('id_author'=>$id_author,'title'=>$title,'id_group'=>$group,'content'=>$content,'data'=>$day_date,'heure'=>$hour));
        }
        public function update_information($id,$title,$content){
            $req = Bdd::Cbdd()->prepare('UPDATE new_infos SET titre=:title,contenu=:content WHERE id=:id');
			$req->execute(array('title'=>$title,'content'=>$content,'id'=>$id));
        }
        public function delete_information($id){
            $req = Bdd::Cbdd()->prepare('UPDATE new_infos SET archive=1 WHERE id=:id');
			$req->execute(array('id'=>$id));
        }
        public function recover_list_information(){
            $req = Bdd::Cbdd()->prepare('SELECT new_infos.*,new_structure.nom as "nom",new_membre.prenom as "createur" 
            FROM new_membre
            JOIN new_infos ON new_membre.id=new_infos.id_createur
            LEFT JOIN new_structure ON new_structure.id = new_infos.id_groupe 
            WHERE new_infos.archive = 0 
            ORDER BY new_infos.data,new_infos.heure DESC');
			$req->execute();
			return $req;
        }
        /***********PERSONNEL***********/
        public function recover_member_by_id($id){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_membre 
            WHERE id=:id');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_total_criminal_record($id,$day_date){
            $req = Bdd::Cbdd()->prepare('SELECT COUNT(id) as "total" 
            FROM `new_amende` 
            WHERE data BETWEEN DATE_ADD(:data, INTERVAL -1 MONTH) AND :data 
            AND id_membre=:id and archive = 0');
			$req->execute(array('id'=>$id,'data'=>$day_date));
			return $req;
        }
        public function recover_criminal_record($id,$day_date){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM `new_amende` 
            WHERE data BETWEEN DATE_ADD(:data, INTERVAL -1 MONTH) AND :data 
            AND id_membre=:id and archive = 0');
			$req->execute(array('id'=>$id,'data'=>$day_date));
			return $req;
        }
        public function update_color($color,$member_id){
            $req = Bdd::Cbdd()->prepare('UPDATE new_membre SET couleur=:color WHERE new_membre.id=:id');
			$req->execute(array('id'=>$member_id,'color'=>$color));
        }
        public function recover_personal_gains($id){
            $req = Bdd::Cbdd()->prepare('SELECT new_item.nom,SUM(quantite) as "quantite",id_item,SUM(quantite*valeur_propre) as "valeur_propre",SUM(quantite*valeur_sale) as "valeur_sale" 
            FROM new_recel_perso
            JOIN new_item ON new_recel_perso.id_item = new_item.id
            WHERE id_membre=:id 
            and new_recel_perso.archive=0 
            GROUP BY id_item');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_all_personal_gains($id){
            $req = Bdd::Cbdd()->prepare('SELECT SUM(quantite*valeur_propre) as "valeur_propre",SUM(quantite*valeur_sale) as "valeur_sale" 
            FROM new_recel_perso
            JOIN new_item ON new_recel_perso.id_item = new_item.id
            WHERE id_membre=:id
            and new_recel_perso.archive=0');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_personal_expense($id){
            $req = Bdd::Cbdd()->prepare('SELECT 
            CASE 
                WHEN type=1 THEN "Essence" 
                WHEN type=2 THEN "Radar" 
                WHEN type=6 THEN  "Réparation"   
            END as "nom",COUNT(id) as "quantite", SUM(montant) as "valeur_propre" 
            FROM new_depense_perso 
            WHERE archive = 0 and id_membre =:id 
            GROUP BY type');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_all_personal_expense($id){
            $req = Bdd::Cbdd()->prepare('SELECT SUM(montant) as "valeur_propre" 
            FROM new_depense_perso 
            WHERE archive = 0 and id_membre =:id');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_all_personal_penalty($id){
            $req = Bdd::Cbdd()->prepare('SELECT SUM(montant) as "amende" 
            FROM new_amende 
            WHERE archive = 0 and id_membre =:id and (DATEDIFF(data, "2024-11-04")) > 0 ');
			$req->execute(array('id'=>$id));
			return $req;
        }
        public function recover_day_gains($date,$id){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_recel_perso 
            WHERE id_membre=:id 
            AND data=:data AND archive = 0 AND HOUR(heure)>=3 
            UNION 
            SELECT * 
            FROM new_recel_perso 
            WHERE id_membre=:id AND data=DATE_ADD(:data,INTERVAL 1 DAY) AND archive = 0 AND HOUR(heure)<3');
			$req->execute(array('id'=>$id,'data'=>$date));
			return $req;
        }
        public function recover_day_expense($date,$id){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_depense_perso 
            WHERE id_membre=:id 
            AND data=:data and archive = 0 AND HOUR(heure)>=3 
            UNION 
            SELECT * 
            FROM new_depense_perso 
            WHERE id_membre=:id AND data=DATE_ADD(:data,INTERVAL 1 DAY) AND archive = 0 AND HOUR(heure)<3');
			$req->execute(array('id'=>$id,'data'=>$date));
			return $req;
        }
        /***********TRANSACTION***********/
        public function recover_number_of_transactions(){
            $req = Bdd::Cbdd()->prepare('SELECT COUNT(*) as total FROM new_transaction WHERE new_transaction.archive = 0');
			$req->execute();
			return $req;
        }
        public function recover_transactions_by_date($first, $per_page){
            $req = Bdd::Cbdd()->prepare('SELECT new_transaction.*,new_membre.prenom,new_structure.couleur 
				FROM new_transaction,new_membre,new_structure 
				WHERE new_structure.nom = new_transaction.client 
				and new_transaction.archive = 0  
				and new_transaction.id_membre_payeur = new_membre.id 
				ORDER BY new_transaction.data DESC, new_transaction.heure DESC 
				LIMIT :premier, :par_page');
    		$req->bindValue('premier',$first,PDO::PARAM_INT);
    		$req->bindValue('par_page',$per_page,PDO::PARAM_INT);
    		$req->execute();
			return $req;
        }
        public function recover_transactions_by_group($first, $per_page){
            $req = Bdd::Cbdd()->prepare('SELECT new_transaction.*,new_membre.prenom,new_structure.couleur 
				FROM new_transaction,new_membre,new_structure 
				WHERE new_structure.nom = new_transaction.client 
				and new_transaction.archive = 0  
				and new_transaction.id_membre_payeur = new_membre.id 
				ORDER BY new_transaction.client, new_transaction.data DESC,new_transaction.heure DESC 
				LIMIT :premier, :par_page');
    		$req->bindValue('premier',$first,PDO::PARAM_INT);
    		$req->bindValue('par_page',$per_page,PDO::PARAM_INT);
    		$req->execute();
			return $req;
        }
        public function recover_transaction_details($id){
            $req = Bdd::Cbdd()->prepare('SELECT new_transaction_item.* FROM new_transaction_item WHERE new_transaction_item.archive = 0  and new_transaction_item.id_transaction=:ida ');
			$req->execute(array('ida'=>$id));
			return $req;
        }
         public function recover_items(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_item 
            WHERE new_item.archive = 0
            ORDER BY id_type');
			$req->execute();
			return $req;
        }
        public function delete_pocket(){
            $requete = Bdd::Cbdd()->prepare('UPDATE new_poche_item_membre SET quantite = 0');
			$requete->execute();
			$requete = Bdd::Cbdd()->prepare('UPDATE new_poche_item_vehicule SET quantite = 0');
			$requete->execute();
        }
        public function recover_pocket_item_name(){
            $req = Bdd::Cbdd()->prepare('SELECT * FROM new_poche_item ORDER BY id');
			$req->execute();
			return $req;
        }
        public function recover_pocket_item_member(){
            $req = Bdd::Cbdd()->prepare("SELECT m.prenom,m.id, 
            (SELECT new_poche_item_membre.quantite 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=1 AND new_membre.id=m.id) as 'liasse',
            (SELECT new_poche_item_membre.id 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=1 AND new_membre.id=m.id) as 'id_liasse',
            (SELECT new_poche_item_membre.quantite 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=2 and new_membre.id=m.id) as 'sac',
            (SELECT new_poche_item_membre.id 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=2 and new_membre.id=m.id) as 'id_sac',
            (SELECT new_poche_item_membre.quantite 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=3 and new_membre.id=m.id) as 'march',
            (SELECT new_poche_item_membre.id 
            FROM new_poche_item_membre 
            JOIN new_membre ON new_membre.id=new_poche_item_membre.id_membre 
            WHERE new_poche_item_membre.id_poche_item=3 and new_membre.id=m.id) as 'id_march'
            FROM new_membre as m
            WHERE m.archive =0");
			$req->execute();
			return $req;
        }
        public function recover_pocket_item_vehicle(){
            $req = Bdd::Cbdd()->prepare("SELECT DISTINCT iv.id_vehicule,
			(SELECT new_poche_item_vehicule.quantite 
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=1 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'liasse',
            (SELECT new_poche_item_vehicule.id
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=1 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'id_liasse',
            (SELECT new_poche_item_vehicule.quantite 
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=2 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'sac',
            (SELECT new_poche_item_vehicule.id
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=2 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'id_sac',
            (SELECT new_poche_item_vehicule.quantite 
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=3 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'march',
            (SELECT new_poche_item_vehicule.id
            FROM new_poche_item_vehicule  
            WHERE new_poche_item_vehicule.id_poche_item=3 AND new_poche_item_vehicule.id_vehicule=iv.id_vehicule) as 'id_march'
            FROM new_poche_item_vehicule as iv");
            $req->execute();
            return $req;
        }

        
        
        
        /***********ANNUAIRE***********/
        public function recover_group_contact(){
            $req = Bdd::Cbdd()->prepare('SELECT new_contact.*,new_structure.couleur, new_structure.nom as ngroupe,new_fonction.nom as fonction 
            FROM new_contact
            JOIN new_structure ON new_contact.id_structure = new_structure.id
            JOIN new_fonction ON new_fonction.id = new_contact.id_fonction
            WHERE new_structure.groupe = 1 AND new_contact.archive = 0 
            ORDER BY new_structure.nom, new_fonction.id');
			$req->execute();
			return $req;  
        }
        public function recover_structure_contact(){
            $req = Bdd::Cbdd()->prepare('SELECT new_contact.*,new_structure.couleur, new_structure.nom as ngroupe,new_fonction.nom as fonction 
            FROM new_contact
            JOIN new_structure ON new_contact.id_structure = new_structure.id
            JOIN new_fonction ON new_fonction.id = new_contact.id_fonction
            WHERE new_structure.groupe = 0 AND new_contact.archive = 0 
            ORDER BY new_structure.nom, new_fonction.id');
			$req->execute();
			return $req;  
        }
        public function recover_other_contact(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_contact 
            WHERE id_structure = 0 AND new_contact.archive = 0');
			$req->execute();
			return $req;  
        }
        /***********GARAGE***********/
        public function recover_car_list(){
            $req = Bdd::Cbdd()->prepare('SELECT new_garage.id as garage_id,new_garage.nom as garage_nom,new_garage.zip as garage_zip,new_vehicule.id as vehicule_id,new_vehicule.id_membre as vehicule_membre_id,new_vehicule.nom as vehicule_nom,new_vehicule.plaque as vehicule_plaque,new_membre.prenom as membre_prenom
				FROM new_vehicule
				JOIN new_garage ON new_vehicule.id_garage = new_garage.id
				JOIN new_membre ON new_vehicule.id_membre = new_membre.id
				WHERE new_vehicule.archive = 0
				AND new_garage.archive = 0
				AND new_membre.archive = 0
				ORDER BY new_garage.id ASC');
			$req->execute();
			return $req;  
        }
        public function recover_car_by_id($id){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_vehicule 
            WHERE id=:id AND archive = 0');
            $req->execute(array('id'=>$id));
            return $req;
        }
        public function recover_garage(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_garage 
            WHERE archive = 0');
			$req->execute();
			return $req;  
        }
        public function update_car($id,$name,$plate,$member,$garage){
			$req = Bdd::Cbdd()->prepare('UPDATE new_vehicule SET nom=:name,plaque=:plate,id_garage=:garage,id_membre=:member WHERE id=:id');
			$req->execute(array('name'=>$name,'plate'=>$plate,'garage'=>$garage,'member'=>$member,'id'=>$id));
		}
		public function delete_car($id){
			$req = Bdd::Cbdd()->prepare('UPDATE new_vehicule SET archive=1 WHERE id=:id');
			$req->execute(array('id'=>$id));
		}
		public function add_car($nom,$plate,$garage,$member){
			$req = Bdd::Cbdd()->prepare('INSERT INTO new_vehicule (nom,plaque,id_garage,id_membre) VALUES (:nom,:plate,:garage,:member)');
			$req->execute(array('nom'=>$nom,'plate'=>$plate,'garage'=>$garage,'member'=>$member));
		}
        /***********HOME***********/
        public function recover_black_box(){
            $req = Bdd::Cbdd()->prepare('SELECT SUM(caisse_noir) as total, new_groupe_compta.seuil_caisse_noir 
				FROM new_membre
                JOIN new_groupe_compta
				WHERE new_membre.archive = 0');
			$req->execute();
			return $req;
        }
        public function recover_detail_black_box(){
            $req = Bdd::Cbdd()->prepare('SELECT new_membre.id,prenom, nom,caisse_noir,new_grade.name as "grade",id_grade,seuil_caisse_noir,affiche_caisse_accueil 
            FROM new_membre
            JOIN new_grade ON new_grade.id = new_membre.id_grade 
            WHERE new_membre.archive = 0 ORDER BY id_grade,prenom');
			$req->execute();
			return $req;
        }
        public function recover_members(){
            $req = Bdd::Cbdd()->prepare('SELECT new_membre.*, new_grade.name,new_connexion.id_statut 
			FROM new_membre
			JOIN new_grade ON new_membre.id_grade = new_grade.id
			JOIN new_connexion ON new_connexion.id_membre= new_membre.id
			WHERE new_membre.archive = 0 ORDER BY new_membre.id_grade ASC, new_membre.prenom');
			$req->execute();
			return $req;
        }
        public function recover_nb_members(){
            $req = Bdd::Cbdd()->prepare('SELECT max(id) FROM new_membre');
			$req->execute();
			return $req->fetch();
        }
        public function recover_payment_contract($enterprise){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_contrat_semaine 
            WHERE new_contrat_semaine.entreprise=:enterprise 
            ORDER BY id DESC 
            LIMIT 1');
			$req->execute(array('enterprise'=>$enterprise));
			return $req;
        }
        public function recover_blanchi(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_blanchi_journalier 
            ORDER BY id DESC 
            LIMIT 1');
			$req->execute();
			return $req;
        }
        public function recover_payment_cartel(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_paiement_cartel 
            ORDER BY id DESC 
            LIMIT 1');
			$req->execute();
			return $req;
        }
        public function recover_all_sun($day_date){
            $req = Bdd::Cbdd()->prepare('SELECT COUNT(soleil) as "total" 
            FROM `new_soleil` 
            WHERE data BETWEEN DATE_ADD(:day_date, INTERVAL -1 MONTH) 
            AND :day_date');
			$req->execute(array('day_date'=>$day_date));
			return $req;
        }
        public function recover_sun($day_date){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM `new_soleil` 
            WHERE data BETWEEN DATE_ADD(:day_date, INTERVAL -1 MONTH) 
            AND :day_date');
			$req->execute(array('day_date'=>$day_date));
			return $req;
        }
        public function add_sun($sun,$sun_date,$hour,$reason){
            $req = Bdd::Cbdd()->prepare('INSERT INTO new_soleil(soleil,data,heure,motif) VALUES (:sun,:sun_date,:heure,:reason)');
			$req->execute(array('sun'=>$sun,'sun_date'=>$sun_date,'heure'=>$hour,'reason'=>$reason));
			return $req;
        }
        public function payment_contract($id_bennys){
            $req = Bdd::Cbdd()->prepare('UPDATE new_contrat_semaine SET valide=1 WHERE new_contrat_semaine.id=:id');
			$req->execute(array('id'=>$id_bennys));
			return $req;
        }
        public function payment_cartel($id_cartel){
            $req = Bdd::Cbdd()->prepare('UPDATE new_paiement_cartel SET valide=1 WHERE new_paiement_cartel.id=:id');
			$req->execute(array('id'=>$id_cartel));
			return $req;
        }
        public function payment_blanchi($id_blanchi){
            $req = Bdd::Cbdd()->prepare('UPDATE new_blanchi_journalier SET valide=1 WHERE new_blanchi_journalier.id=:id');
			$req->execute(array('id'=>$id_blanchi));
			return $req;
        }
        public function recover_operation(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_operation');
			$req->execute();
			return $req;
        }
        public function recover_days_war(){
            $req = Bdd::Cbdd()->prepare('SELECT * 
            FROM new_jour_presence_nom 
            ORDER BY new_jour_presence_nom.id ASC');
			$req->execute();
			return $req;
        }
        public function recover_days_war_members(){
			$req = Bdd::Cbdd()->prepare('SELECT new_jour_presence.*,new_membre.prenom as "prenom_membre" 
			FROM new_jour_presence
			JOIN new_membre ON new_jour_presence.id_membre=new_membre.id
			WHERE new_membre.archive = 0 ORDER BY new_jour_presence.id ASC');
			$req->execute();
			return $req;
		}
        public function recover_total_days_war(){
            $req = Bdd::Cbdd()->prepare('SELECT SUM(apres_midi) as "apres_midi", SUM(soir) as "soir",new_jour_presence.id_jour as "id_jour" 
            FROM new_jour_presence 
            GROUP BY new_jour_presence.id_jour 
            ORDER BY new_jour_presence.id_jour ASC');
			$req->execute();
			return $req;
        }
    }
?>