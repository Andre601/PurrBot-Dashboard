<?php
// Config
require_once __DIR__ . '/../config.php';
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
		<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<title>Purr Dashboard</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" href="<?=createPath('')?>"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="<?=config('github_url')?>"><i class="fab fa-github"></i> GitHub</a>
      </li>
    </ul>

    <ul class="navbar-nav my-2 my-lg-0">
<?php if(isset($user)) { ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$user->getUsername();?>#<?=$user->getDiscriminator();?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=createPath('logout.php')?>">Logout</a>
        </div>
      </li>

   <?php } else { ?>

      <li class="nav-item dropdown">
        <a class="nav-link" href="<?=createPath('discord.php')?>">Login</a>
      </li>
   <?php } ?>
    </ul>
  </div>
</div>
</nav>
		<div class="jumbotron">
			<div class="container">
				<h1>Purr Dashboard</h1>
			</div>
		</div>