<section id="inscription">

	<h1>Billet simple pour l'Alaska</h1>
	<h2>Inscription</h2>
	
	<form action="/users/register" method="post" id="inscription-form">
		
		<div class="form-group" >
			<label for="login">Pseudo</label>
			<input type="text" class="form-control" id="login" aria-describedby="pseudoHelp" placeholder="Saisir votre pseudo" name="login" minlength="3" maxlength="12" required>
			<small id="pseudoHelp" class="form-text text-muted">3 à 12 caractères; Caractères alphanumériques uniquement.</small>
		</div>		
		<div class="form-group">
			<label for="mail">Adresse email</label>
			<input type="email" class="form-control" id="mail" aria-describedby="emailHelp" placeholder="Saisir votre Email" name="mail" required>
			<small id="emailHelp" class="form-text text-muted">Un email de vérification vous sera envoyé.</small>
		</div>
		<div class="form-group">
			<label for="pass1">Mot de passe</label>
			<input type="password" class="form-control" id="pass1" name="pass1" placeholder="Saisir votre mot de passe" aria-describedby="pass1Help" minlength="8" required>
			<small id="pass1Help" class="form-text text-muted">Au moins 8 caractères</small>
		</div>
		<div class="form-group">
			<label for="pass2">Mot de passe</label>
			<input type="password" class="form-control" id="pass2" name="pass2" placeholder="Resaisir votre mot de passe" aria-describedby="pass2Help" minlength="8" required>
			<small id="pass2Help" class="form-text text-muted">Resaisir le mot de passe.</small>
		</div>
		
		<div class="alert alert-info" role="alert" id="form-info">

		</div>
		<button type="submit" class="btn btn-primary" id="submitInscription">Submit</button>

	</form>

</section>

