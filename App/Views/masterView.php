<section id="administration">

	<h2 class="mb-5">Administration du blog</h2>

	<button type="button" class="btn btn-link" id="newchapter"><strong>Nouveau chapitre</strong></button>


	<form class="d-flex  justify-content-center" method="post">
		<div class="form-row align-items-end">
			<div class="col-auto my-1">
				<label class="mr-sm-2" for="target">Lister: </label>
				<select class="custom-select mr-sm-2" id="target" name="target">
					<option selected>...</option>
					<option value="articles">Les chapitres</option>
					<option value="comments">Les commentaires</option>
					<option value="users">Les utilisateurs</option>
				</select>
			</div>
			<div class="col-auto my-1">
				<label class="mr-sm-2" for="orderBy">Trier par:</label>
				<select class="custom-select mr-sm-2" id="orderBy" name="orderBy">
					<option selected>...</option>
					<option value="id">Identifiants</option>
					<option value="creationDate">Date de création</option>
				</select>
			</div>
			<div class="col-auto my-1">
				<button type="submit" class="btn btn-primary" id="loadlist">Charger la liste</button>
			</div>
		</div>
	</form>

	<form class="mt-5 border text-left p-5 d-none" enctype="multipart/form-data" method="post" id="articleform">
		<div class="form-group">
			<label for="title">Titre du chapite</label>
			<input type="text" class="form-control" id="title" placeholder="Titre du chapitre" name="title" required>
		</div>
		<div class="form-group">
			<label for="chapternumber">Numéro de chapitre</label>
			<input type="number" class="form-control" id="chapternumber" name="chapternumber" min=1 max=100 required />
		</div>
		<div class="form-group">
			<label for="type">Type</label>
			<select class="form-control" id="type" name="type" required>
				<option value="draft">Brouillon</option>
				<option value="published">Publié</option>
			</select>
		</div>
		<div class="form-group">
			<label for="content">Contenu du chapitre</label>
			<textarea class="form-control" id="content" name ="content"  rows="25" required></textarea>
		</div>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-primary" id="savepost">Sauvegarder le chapitre</button>
		</div>
	</form>

	<table class="table mt-5 d-none" id="chaptertable">
		<thead class="thead-dark">
			<tr>
				<th scope="col">N° chapitre</th>
				<th scope="col">Titre</th>
				<th scope="col">extrait</th>
				<th scope="col">Mise à jour le</th>
				<th scope="col">Type</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row">1</th>
				<td>Mark</td>
				<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, illo saepe libero inventore quidem expedita, modi ipsa in. Quis, libero unde facilis, adipisci quisquam omnis fugit. Cum quos repudiandae culpa? </td>
				<td>Otto</td>
				<td>Mark</td>
				<td class="d-flex flex-column"><a href="" class="text-success">modifier</a><a href="" class="text-danger">supprimer</a></td>

			</tr>
			<tr>
				<th scope="row">2</th>
				<td>Jacob</td>
				<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, illo saepe libero inventore quidem expedita, modi ipsa in. Quis, libero unde facilis, adipisci quisquam omnis fugit. Cum quos repudiandae culpa? </td>
				<td>Thornton</td>
				<td>Mark</td>
				<td class="d-flex flex-column"><a href="" class="text-success">modifier</a><a href="" class="text-danger">supprimer</a></td>

			</tr>
			<tr>
				<th scope="row">3</th>
				<td>Larry</td>
				<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, illo saepe libero inventore quidem expedita, modi ipsa in. Quis, libero unde facilis, adipisci quisquam omnis fugit. Cum quos repudiandae culpa? </td>
				<td>the Bird</td>
				<td>Mark</td>
				<td class="d-flex flex-column"><a href="" class="text-success">modifier</a><a href="" class="text-danger">supprimer</a></td>

			</tr>
		</tbody>
	</table>



</section>