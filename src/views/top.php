<header>
	<menu class="menu_desktop">
	  <li><button id="menu_journalier" onclick="self.location.href='<?php echo Tools::redirect("home") ?>'">Journalier</button></li>
	  <li><button id="menu_perso" onclick="self.location.href='<?php echo Tools::redirect("personal") ?>'">Perso</button></li>
	  <li><button id="menu_infos" onclick="self.location.href='<?php echo Tools::redirect("information") ?>'">Infos</button></li>
	  <li><button id="menu_comptabilite" onclick="self.location.href='<?php echo Tools::redirect("comptabilite") ?>'">Comptabilite</button></li>
	  <li><button id="menu_transaction" onclick="self.location.href='<?php echo Tools::redirect("transaction") ?>'">Transactions</button></li>
	  <li><button id="menu_divers" onclick="self.location.href='<?php echo Tools::redirect("divers") ?>'">Divers</button></li>
	  <li><button id="menu_pm" onclick="self.location.href='<?php echo Tools::redirect("pm") ?>'">PM</button></li>
	  <li><button id="menu_compte" onclick="self.location.href='<?php echo Tools::redirect("compte") ?>'">Compte</button></li>
	  <li><button id="menu_delits" onclick="self.location.href='<?php echo Tools::redirect("delit") ?>'">Délits</button></li>
	  <li><button id="menu_tarif_rachat" onclick="self.location.href='<?php echo Tools::redirect("tarifRachat") ?>'">Tarifs Rachat</button></li>
	  <li><button id="menu_tarif_groupe" onclick="self.location.href='<?php echo Tools::redirect("tarifGroupe") ?>'">Tarifs Groupe</button></li>
	  <li><button id="menu_stock" onclick="self.location.href='<?php echo Tools::redirect("stock") ?>'">Stock</button></li>
	  <li><button id="menu_garage" onclick="self.location.href='<?php echo Tools::redirect("garage") ?>'">Garage</button></li>
      <li><button id="menu_annuaire" onclick="self.location.href='<?php echo Tools::redirect("directory") ?>'">Annuaire</button></li>
	  <?php if($_SESSION['statut_comptatest'] == 1 || $_SESSION['statut_comptatest'] == 2){?>
	  	<li><button id="menu_admin" onclick="self.location.href='<?php echo Tools::redirect("admin") ?>'">Admin</button></li>
	    <?php } if($_SESSION['statut_comptatest'] == 1){ ?>	
	  	<?php } ?> 
	  <li><button id="menu_deconnexion" onclick="self.location.href='<?php echo Tools::redirect("index") ?>'">Déconnexion</button></li>
	</menu>
	<div class="menu_mobile">
		<div id="mySidenav" class="sidenav">
		  <a id="closeBtn" href="#" class="close">×</a>
		  <ul>
		  	<li><a href="index">Déconnexion</a></li>
		    <li><a href="home">Journalier</a></li>
		    <li><a href="personal">Perso</a></li>
		    <li><a href="information">Infos</a></li>
		     <?php 
	  		if($_SESSION['statut_comptatest'] == 1 || $_SESSION['statut_comptatest'] == 2){?>
		    	<li><a href="admin">Admin</a></li>
		    <?php }
	  		if($_SESSION['statut_comptatest'] == 1){?>
	  			
	  		<?php } ?>
			  <li><a href="comptabilite">Comptabilite</a></li>
			  <li><a href="transaction">Transaction</a></li>
			  <li><a href="divers">Divers</a></li>
			  <li><a href="pm">PM</a></li>
			  <li><a href="compte">Compte</a></li>
			  <li><a href="delit">Délits</a></li>
			  <li><a href="tarifRachat">Tarifs Rachat</a></li>
			  <li><a href="tarifGroupe">Tarifs Groupe</a></li>
			  <li><a href="stock">Stock</a></li>
              <li><a href="garage">Garage</a></li>
			  <li><a href="directory">Annuaire</a></li>			  
		  </ul>
		</div>

		<a href="#" id="openBtn">
		  <span class="burger-icon">
		    <span></span>
		    <span></span>
		    <span></span>
		  </span>
		</a>
	</div>
</header>
<script src="src/js/menu.js"></script>