<header id="header">
	<div class="navbar navbar-dark bg-dark shadow-sm">
		<div class="container d-flex justify-content-between">
			<img src="/Public/images/logo-menu.png" alt="logo Jean Forteroche">
			<nav class="navbar navbar-expand-lg navbar-light main-navigation">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="/home">Accueil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/articles">Blog</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/users">Mon espace</a>
					</li>
				</ul>
			</nav>

		<?php if (!empty($_SESSION['auth'])): ?>
			<a href="/users/logout" id="logout" class="icon-exit"></a>
		<?php endif;?>

		</div>

	</div>
</header>