<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=science" />

<style>

.material-symbols-outlined {
  font-variation-settings:
  'FILL' 1,
  'wght' 500,
  'GRAD' 0,
  'opsz' 48
}

</style>
<div class="dlabnav"  style="background-color: rgb(28, 39, 43);">
	<div class="dlabnav-scroll">	
		<ul class="metismenu" id="menu">
			<li> <a href="/dashboard">
                    <i class="bi bi-house-door-fill"></i> <span class="nav-text">Tableau de Bord</span>
				</a>
			</li>
			<?php if(Auth::user()->role === 'superadmin'){ ?>
			<li>
				<a href="/factory/all-factory" >
					<i class="bi bi-buildings-fill"></i>
					<span class="nav-text">Liste des Usines</span>
				</a>		
			</li>
			<?php }	if(Auth::user()->role === 'admin' || Auth::user()->role == 'user' ){  ?>		
			<li>
				<a href="/workshop/all-workshop/<?=IdEncryptor::encode(Auth::user()->idusine)?>" >
					<i class="bi bi-building-fill-gear"></i>
					<span class="nav-text">Liste des Ateliers</span>
				</a>		
			</li>
			<?php } ?>


			<?php if(Auth::user()->role === 'superadmin' ){ 	?>		
			<li>
				<a href="/workshop/all-workshop/" >
					<i class="bi bi-building-fill-gear"></i>
					<span class="nav-text">Liste des Ateliers</span>
				</a>		
			</li>
			<?php } ?>


			<?php if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' ){ ?>	
				
			<li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-watch"></i>
                    <span class="nav-text">Historique</span>
			    </a>
                <ul aria-expanded="false">
				<li><a href="#">Atelier</a></li>
                    <li><a href="/history/user">Utilisateurs</a></li>
                    <li><a href="#">Produits</a></li>
                </ul>
			</li>
			<?php } ?>
			<li>
				<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
					<!-- <i class="bi bi-virus2"></i> -->
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-test-tube-diagonal-icon lucide-test-tube-diagonal"><path d="M21 7 6.82 21.18a2.83 2.83 0 0 1-3.99-.01a2.83 2.83 0 0 1 0-4L17 3"/><path d="m16 2 6 6"/><path d="M12 16H4"/></svg>
					<span class="nav-text" >Produits</span>
				</a>
				<ul aria-expanded="false">
					<?php if($_SESSION['log']['type']=='admin'||$_SESSION['log']['type']=='superadmin'){ ?>		
						<li><a href="/product/new-product">Ajouter un produit</a></li>
					<?php } ?>

					<li><a href="/product/all-product">Liste des produits</a></li>
				</ul>
			</li>
			<?php if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' ){ ?>		
			<li>
				<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-person-fill"></i>
                    <span class="nav-text">Utilisateur</span> 
				</a>
				<ul aria-expanded="false">
					<li><a href="#">Liste des Utilisateurs</a></li>	
					<li><a href="/admin/new-user">Ajouter un etudiant</a></li>
				</ul>
			</li>
			<?php } ?>			
		</ul>

		<div class="copyright">
			<p><strong>Tableau de bord de ChemSafe</strong></p>
			<p class="fs-12">Developpé par </p>
		</div>
	</div>
</div>