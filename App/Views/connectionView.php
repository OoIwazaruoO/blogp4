<section id="connection">
	
	<form action="users/connect" method="post" class="text-left">
		
		<div class="form-group" >
			<label for="pseudo" >Pseudo</label>
			<input type="text" class="form-control" id="pseudo" aria-describedby="pseudoHelp" placeholder="Pseudo" name="pseudo" minlength="3" maxlength="12">
			<small id="pseudoHelp" class="form-text text-muted">Entrez votre nom d'utilisateur</small>
		</div>		
		<div class="form-group">
			<label for="pass1">Mot de passe</label>
			<input type="password" class="form-control" id="pass1" name="pass1" placeholder="Saisir votre mot de passe" aria-describedby="pass1Help">
			<small id="pass1Help" class="form-text text-muted">Entrez votre mot de passe</small>
		</div>
			
		<div class="form-group text-center">
			<button type="submit" class="btn btn-primary" id="submitInscription">Submit</button>
		</div>
		


	</form>
</section>