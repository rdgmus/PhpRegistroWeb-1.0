<?php
global $pageTitle;
global $logoHref, $logoSrc, $logoAlt;

?>
<html>
<head>
<?php include 'jquery/jquery.php';
?>
</head>
<table id="logoTitleFrameTable">
	<tr>
		<td valign="top"><table id="logoTitleFrameTable">
				<tr>
					<td valign="top"><input
						src="<?php echo userIsAdministrator($_COOKIE['id_utente']) ? 'images/administrator.jpeg' : 'images/ruolo_utente.png'?>"
						width="64" height="64" title="Torna al Men utente"
						id="backToUserMenu" type="image" />
					</td>
					<td valign="top">
						<table id="logoTitleFrameTable">
							<tr>
								<td><?php echo 'PhpRegistroWeb 1.0';?></td>
							</tr>
							<tr>
								<td><?php echo userIsAdministrator($_COOKIE['id_utente']) ? 'Administrator:':'User:' ?>

								<?php echo  $_COOKIE['cognome_user'] . " " . $_COOKIE['nome_user'].
							"(".$_COOKIE['id_utente'].")"?>
								</td>
							</tr>
							<tr>
								<td><?php
								echo 'MYSQL_SERVER:'.$_COOKIE['MYSQL_SERVER']?>
								</td>
							</tr>
							<tr>
								<td colspan="2"><h1>
								<?php echo $pageTitle ?>
									</h1></td>
							</tr>
						</table>
					</td>

				</tr>
				<tr>
				<?php if (isset($GLOBALS['logoHref'])) {?>
					<td valign="top" colspan="2" align="center"><a
						href="<?php echo $GLOBALS['logoHref'];?>"> <img
							src="<?php echo $GLOBALS['logoSrc'];?>"
							alt="<?php echo $GLOBALS['logoAlt'];?>"
							title="<?php echo $GLOBALS['logoAlt'];?>" /> </a>
					</td>
				<?php 					
				}?>
				</tr>
			</table></td>
		<td><div id="datepicker"></div></td>
	</tr>
</table>
<hr>
</html>
