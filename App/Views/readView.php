<section id="article" class="container">
	<div id="read" class="mt-5">
		<?php 
		if(!empty($article) && $article = $article->fetch()):
			if($article->type() == "published"):
				?>
				<h1>Chapitre <?= $article->chapterNumber() ?>: <?= $article->title() ?></h1>

				<figure class="figure">
					<img src="/Public/images/<?= $article->pictureName()?>" class="figure-img img-fluid rounded" alt="Photo de Jean Forteroche ?" >
					<figcaption class="figure-caption text-right"><?= $article->getFormatedUpdateDate() ?></figcaption>
				</figure>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi laudantium quibusdam fuga itaque ipsa nulla, dolore cumque quidem, sint distinctio architecto nobis aspernatur repellat pariatur, mollitia consectetur hic cupiditate velit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam itaque asperiores natus quis, ducimus, doloribus quasi ipsum nam magni, sapiente est nobis earum recusandae praesentium non cumque rem labore quod? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo cum libero rerum voluptates, quo repellendus. Amet voluptatibus veritatis voluptatem dicta odio doloribus, natus voluptate quasi similique omnis, nihil vero quis! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, soluta, accusamus. Itaque vero excepturi iste vitae unde amet, dolor ab, aut eos blanditiis voluptatibus repellat beatae minima distinctio fugiat et.
				</p>


				<?php
			else:
				?>
				<div class="alert alert-warning" role="alert">
					Cette article n'existe pas.
				</div>
				<?php
			endif;
		else:
			?>
			<div class="alert alert-warning" role="alert">
				Cette article n'existe pas.
			</div>
			<?php
		endif;

		?>
	</div>
</section>