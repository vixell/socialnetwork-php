<?php
  session_start();
  include('../modules/twitter/twitteroauth.php');
  include('twitter.inc.php');
  
  $isLoggedOnTwitter = false;

if (!empty($_SESSION['access_token']) && !empty($_SESSION['access_token']['oauth_token']) && !empty($_SESSION['access_token']['oauth_token_secret'])) {
	// On a les tokens d'accès, l'authentification est OK.

	$access_token = $_SESSION['access_token'];

	/* On créé la connexion avec twitter en donnant les tokens d'accès en paramètres.*/
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

	/* On récupère les informations sur le compte twitter du visiteur */
	$twitterInfos = $connection->get('account/verify_credentials');
	$isLoggedOnTwitter = true;
}
elseif(isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] === $_REQUEST['oauth_token']) {
	// Les tokens d'accès ne sont pas encore stockés, il faut vérifier l'authentification

	/* On créé la connexion avec twitter en donnant les tokens d'accès en paramètres.*/
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

	/* On vérifie les tokens et récupère le token d'accès */
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

	/* On stocke en session les token d'accès et on supprime ceux qui ne sont plus utiles. */
	$_SESSION['access_token'] = $access_token;
        echo "TOKEN : ".$_SESSION['oauth_token']."<br />";
        echo "TOKEN SECRET : ".$_SESSION['oauth_token_secret'];
        
}


?>