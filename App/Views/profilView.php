<section id="profil">

	<h1>Billet simple pour l'Alaska</h1>
	<h2 class="mb-3">Profil</h2>


	<div class="container mt-5 d-flex justify-content-center align-items-center">
		<div class="card mb-3 " style="max-width: 54rem;">
			<div class="row no-gutters">
				<div class="col-md-12">
					<img src="/Public/images/wolf.jpg" class="card-img" alt="Votre image de profil">
				</div>
				<div class="col-md-12">
					<div class="card-body">
						<h5 class="card-title">Pseudo: <?=$user->login()?></h5>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">Role: <?=$user->role()?></li>
							<li class="list-group-item">3 chapitres lus</li>
							<li class="list-group-item">5 Commentaires postés</li>

						</ul>
						<p class="card-text"><small class="text-muted">Inscrit depuis le <?=$user->inscriptionDate()?></small></p>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>