<section  id="blog">

	<h1>Billet simple pour l'Alaska</h1>
	<h2>Blog</h2>

	<div class="d-flex flex-wrap justify-content-center">
		<?php

		if(!empty($articles)):

			while($article = $articles->fetch()):
				if($article->type() == "published"):
					?>

					<div class="card ml-5 mt-3" style="width: 20rem;" >

						<h5 class="card-title"><?= $article->title();?></h5>
						<img class="card-img-bottom" src="/Public/images/<?= $article->pictureName();?>" alt="Card image cap">
						<div class="card-body">

							<span class="card-text">Chapitre <?= $article->chapterNumber(); ?></span>
							<p class="card-text"><?= $article->contentExcerpt(125)?></p>
							<a href="/articles/read/id/<?= $article->id() ?>" class="btn btn-primary">Lire le chapite</a>

						</div>
						<div class="card-footer text-right">

							<small class="text-muted"><?= $article->getformatedUpdateDate()  ?> </small>

						</div>
					</div>


					<?php
				endif;
			endwhile;
		else: 
			?>
			<div class="alert alert-info" role="alert">
				Aucun article disponible pour le moment
			</div>
			<?php
		endif;
		?>

	</div>
</section>