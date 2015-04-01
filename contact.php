<?php
	define( 'MAIL_TO', 'aurelien.grimaud@ineedvitamins.fr' );
	define( 'MAIL_NAME', '' );
	define( 'MAIL_FROM', 'aurelien.grimaud@ineedvitamins.fr' );
	define( 'MAIL_OBJECT', '' );
	define( 'MAIL_MESSAGE', '' );

	$mailSent = false;
	$errors = array();
	$alert;
	
	if( filter_has_var( INPUT_POST, 'send' ) ) // le formulaire a été soumis avec le bouton [Envoyer]
	{

		$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW );
		if( $name === NULL OR empty( $name ) OR $name === MAIL_NAME )
		{
			$errors[] = 'Vous avez un nom, non ?';
		} 

		$from = filter_input( INPUT_POST, 'from', FILTER_VALIDATE_EMAIL );
		if( $from === NULL )
		{
			$errors[] = 'Il faudrait votre adresse mail.';
		}
		elseif( $from === false )
		{
			$errors[] = 'Dommage, il faudrait une adresse mail valide.';
			$from = filter_input( INPUT_POST, 'from', FILTER_SANITIZE_EMAIL );
		}

		$object = filter_input( INPUT_POST, 'object', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW );
		if( $object === NULL OR $object === false OR empty( $object ) OR $object === MAIL_OBJECT )
		{
			$errors[] = 'Vous devez renseigner le thème.';
		}

		$message = filter_input( INPUT_POST, 'message', FILTER_UNSAFE_RAW );
		if( $message === NULL OR $message === false OR empty( $message ) ) 
		{
			$errors[] = 'Vous devez écrire un message.';
		   
		}

		if( count( $errors ) === 0 ) // si il n'y a pas d'erreurs
		{
			if( mail( MAIL_TO, $object, $message, "De: $from\nRépondre à: $from\n" ) ) // tentative d'envoi du message
			{
				$mailSent = true;
			}
			else // échec de l'envoi
			{
				$errors[] = 'Votre message n\'a pas été envoyé.';
			}
		}
	}
	else // le formulaire est affiché pour la première fois, avec les valeurs par défaut
	{
		$name = MAIL_NAME;
		$from = MAIL_FROM;
		$object = MAIL_OBJECT;
		$message = MAIL_MESSAGE;
	}

	if( $mailSent === true ) // si le message a bien été envoyé, on affiche le récapitulatif
	{
?>
<!doctype html>
<html class="no-js" lang="fr">

	<head>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="author" content="Aurélien Grimaud" />
		<meta name="description" content="Page de contact, dans un contexte de réussite" />

		<title>Merci de votre message</title>

		<!--STYLE GENERAL-->
		<link rel="stylesheet" media="all" type="text/css" href="css/foundation.css" />
		<link rel="stylesheet" media="all" type="text/css" href="css/style.css" />
		<link rel="stylesheet" media="all" type="text/css" href="css/tomorrow-night.css" />


		<!--FONTE-->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,700,900' rel='stylesheet' type='text/css'>

		<!--SCRIPT-->
		<script type="text/javascript" src="js/vendor/modernizr.js"></script>

	</head>

	<body>

		<section class="blBG adaptableCover flex">

			<article class="row centerBlock card whBG"> 
				<h1 class="sectionTitle">Votre message a bien été envoyé.</h1>
				<div class="yourMail">
					<p><strong class="upCase">nom :</strong><br /><?php echo( $name ); ?></p> 
					<p><strong class="upCase">adresse email:</strong><br /><?php echo( $from ); ?></p>
					<p><strong class="upCase">thème :</strong><br /><?php echo( $object ); ?></p>
					<p><strong class="upCase">message :</strong><br /><?php echo( nl2br( htmlspecialchars( $message ) ) ); ?></p>
				</div>
				<div class="large-3 medium-3 small-3">
					<a href="javascript:history.go(-1)" class="button medium centerOrigin animation return blBut"><span class="animation">retour</span></a>
				</div>
			</article>

		</section>

		<script src="js/vendor/jquery.js" type="text/javascript"></script>
		<script src="js/foundation.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			// ensemble des scripts
			imready = function() {
				cover();
			}

			// couverture adaptable
			cover = function() {
				var innerHeight = (window.innerHeight);
				$('.adaptableCover').css('height', +innerHeight+"px");
				$(window).on('resize', function() {
					$('.adaptableCover').css('height', +innerHeight+"px");
				})
			}

			$(document).foundation().ready(imready);
		</script>

	</body>

</html>
<?php
	}
	else // le formulaire est affiché pour la première fois ou le formulaire a été soumis mais contenait des erreurs
	{ 
?>
	<!doctype html>
	<html class="no-js" lang="fr">

		<head>

			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<meta http-equiv="Content-Style-Type" content="text/css" />
			<meta name="author" content="Aurélien Grimaud" />
			<meta name="description" content="Page de contact, dans un contexte de réussite" />

			<title>Ouuups, petite erreur</title>

			<!--STYLE GENERAL-->
			<link rel="stylesheet" media="all" type="text/css" href="css/foundation.css" />
			<link rel="stylesheet" media="all" type="text/css" href="css/style.css" />
			<link rel="stylesheet" media="all" type="text/css" href="css/tomorrow-night.css" />


			<!--FONTE-->
			<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,700,900' rel='stylesheet' type='text/css'>

			<!--SCRIPT-->
			<script type="text/javascript" src="js/vendor/modernizr.js"></script>

		</head>

		<body>
			
			<section class="blBG adaptableCover flex">

				<article class="row centerBlock card whBG">

					<h1 class="sectionTitle">Ouuups, quelques petites erreurs...</h1>

					<?php
						if( count( $errors ) !== 0 )
						{
							echo( "\t\t<ul class=\"txtList errorList\">\n" );
							foreach( $errors as $error )
							{
								echo( "\t\t\t<li class=\"redColor\">$error</li>\n" );
							}
							echo( "\t\t</ul>\n" );
						}
						else
						{
							echo( "\t\t<p id=\"welcome\"><em>Tous les champs sont obligatoires</em></p>\n" );
						}
					?> 

					<form id="recupForm" class="row" method="post" action="contact.php">
						<div class="large-6 medium-6 small-6 columns">

							<label for="name" class="blkColor upCase level3">
								nom *
								<input id="name" type="text" name="name" value="<?php echo( $name ); ?>" />
							</label>
							<label for="from" class="blkColor upCase level3">
								adresse e-mail *
								<input id="from" type="text" name="from" value="<?php echo( $from ); ?>" />
							</label>
							<label for="object" class="blkColor upCase level3">
								thème *
								<input id="object" type="text" name="object" value="<?php echo( $object ); ?>" />
							</label>

						</div>

						<div class="large-6 medium-6 small-6 columns">

							<label for="message" class="blkColor upCase level3">
								message *
								<textarea id="message" type="text" name="message"><?php echo( $message ); ?></textarea>
							</label>
							<div class="sendBut">
								<button type="submit" name="send" class="button medium centerOrigin animation send blBut"><span class="animation">envoyer</span></button>
							</div>

						</div>
					</form>

				</article>

			</section>

			<script src="js/vendor/jquery.js" type="text/javascript"></script>
			<script src="js/foundation.min.js" type="text/javascript"></script>
			<script type="text/javascript">
				// ensemble des scripts
				imready = function() {
					cover();
					error();
				}

				// couverture adaptable
				cover = function() {
					var innerHeight = (window.innerHeight);
					$('.adaptableCover').css('height', +innerHeight+"px");
					$(window).on('resize', function() {
						$('.adaptableCover').css('height', +innerHeight+"px");
					})
				}

				// erreurs dans le formulaire
				error = function() {
					<?php 
					$alert = '#FF2744';
					if( $name === NULL OR $object === false OR empty( $name ) OR $name === MAIL_OBJECT )
					{
					?>
						$('input#name').css('border', '2px solid <?php echo $alert; ?>');
					<?php }; 

					if( $from === NULL OR $from === false OR empty( $from ) OR $from === MAIL_TO )
					{
					?>
						$('input#from').css('border', '2px solid <?php echo $alert; ?>');
					<?php };
					

                    if( $object === NULL OR $object === false OR empty( $object ) OR $object === MAIL_OBJECT )
					{
					?>
						$('input#object').css('border', '2px solid <?php echo $alert; ?>');
					<?php };

					if( $message === NULL OR $message === false OR empty( $message ) )
					{
					?>
						$('textarea#message').css('border', '2px solid <?php echo $alert; ?>');
					<?php }; ?>
					
				}

				$(document).foundation().ready(imready);
			</script>

		</body>

	</html>
<?php
	}
?>