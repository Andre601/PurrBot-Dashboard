<?php
	// Composer
	require_once 'vendor/autoload.php';

	// Session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}


	if(isset($_COOKIE['discord_token'])) {
		header('Location: server.php');
	}

	require_once 'inc/header.php'; ?>

		<div class="container text-center">
			<p class="lead">In order to access the Purr dashboard, you must first login with your Discord account.</p>
			<a class="btn btn-outline-dark" href="discord.php"><i class="fab fa-discord"></i>  Login to Discord</a>
		</div>


<?php require_once 'inc/footer.php'; ?>