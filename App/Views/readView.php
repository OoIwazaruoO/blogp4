<section id="article" class="container">
	<div id="read" class="mt-5">

	<?php if (!empty($article) && $article = $article->fetch()): ?>
		<?php if ($article->type() == "published"): ?>

			<h1>Chapitre <?=$article->chapterNumber()?>: <?=$article->title()?></h1>

			<figure class="figure">
				<img src="/Public/images/<?=$article->pictureName()?>" class="figure-img img-fluid rounded" alt="Photo de Jean Forteroche ?" >
				<figcaption class="figure-caption text-right"><?=$article->getFormatedUpdateDate()?></figcaption>
			</figure>

			<p> <?=$article->content()?> </p>


			<?php if ($authentified): ?>

				<section id="articleComments">

					<form class="mt-5 border text-left p-5 " method="post" action="/comments/add" id="articleform">

						<div class="form-group">
							<label for="content">Commentaire</label>
							<textarea class="form-control" id="content" name ="content"  rows="5" minlength="4" maxlength="255" required></textarea>
						</div>
						<div class="form-group">
							<input type="hidden" id="id" name="id" value="<?=$article->id()?>">
						</div>
						<div class="form-group text-center">
							<button type="submit" class="btn btn-primary" id="savecomment">Ajouter le commentaire</button>
						</div>
					</form>

				</section>

				<?php if (!empty($comments)): ?>

					<?php while ($comment = $comments->fetch()): ?>

						<div class="card">
	  						<h5 class="card-header"><?=$comment->author()?></h5>
	  						<div class="card-body">
	    						<em><?=$comment->getFormatedDate()?></em>
	    						<p class="card-text">

	    							<?php if ($comment->status() == "Ok"): ?>
	    						    <?=$comment->content()?>
	    						    <?php elseif ($comment->status() == "EDITED"): ?>
	    						    <?=$comment->content() . " <em class=\"text-info\">Modifié par l'administrateur</em>"?>
	    							<?php else: ?>
	    							<?="Commentaire supprimé"?>
	    							<?php endif;?>


	    							</p>

	  						</div>
						</div>

					<?php endwhile;?>

				<?php endif;?>

			<?php else: ?>
			<?php endif;?>


		<?php else: ?>

				<div class="alert alert-warning" role="alert">
					Cette article n'existe pas.
				</div>

		<?php endif;?>
	<?php else: ?>

				<div class="alert alert-warning" role="alert">
					Cette article n'existe pas.
				</div>

	<?php endif;?>

	</div>
</section>