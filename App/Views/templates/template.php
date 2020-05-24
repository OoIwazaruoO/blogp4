<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/Public/css/style.css">

    <title><?=$title ?? 'Jean forteroche'?></title>
  </head>
  <body>
  	<?php include __DIR__ . "/../inc/header.php";?>
  	<main>

      <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['flash']['success'])): ?>

          <div class="alert alert-success mt-3 w-50" role="alert" id="success-info">
            <?php
foreach ($_SESSION['flash']['success'] as $message):
	echo $message . '<br/>';
endforeach;
$_SESSION['flash']['success'] = [];
?>
          </div>

      <?php endif;?>

       <?php if (!empty($_SESSION['flash']) && !empty($_SESSION['flash']['error'])): ?>

          <div class="alert alert-danger mt-3 w-50" role="alert" id="error-info">
            <?php
foreach ($_SESSION['flash']['error'] as $message):
	echo $message . '<br/>';
endforeach;
$_SESSION['flash']['error'] = [];
?>
          </div>

      <?php endif;?>

  		<?=$content?>
  	</main>

	<?php include __DIR__ . "/../inc/footer.php";?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Public/js/index.js"></script>

    <?php
foreach ($script as $value): ?>
        <script type="text/javascript" src="Public/js/<?=$value?>.js"></script>

        <?php
endforeach;
?>
  </body>
</html>