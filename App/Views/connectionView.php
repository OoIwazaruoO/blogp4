<section id="connection">

	<h1>Billet simple pour l'Alaska</h1>
	<h2>Connection</h2>

	<form action="/users/connect" method="post" class="text-left">

		<div class="form-group" >
			<label for="login" >Pseudo</label>
			<input type="text" class="form-control" id="login" aria-describedby="pseudoHelp" placeholder="Pseudo" name="login" minlength="3" maxlength="12" required>
			<small id="pseudoHelp" class="form-text text-muted">Entrez votre nom d'utilisateur</small>
		</div>
		<div class="form-group">
			<label for="password">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Saisir votre mot de passe" aria-describedby="pass1Help" required>
			<small id="pass1Help" class="form-text text-muted">Entrez votre mot de passe</small>
		</div>
		<span>Pas encore inscrit? <a href="/users/inscriptionForm">s'inscrire</a></span>

		<div class="form-group text-center">

			<button type="submit" class="btn btn-primary" id="submitInscription">Submit</button>
		</div>



	</form>
</section>
