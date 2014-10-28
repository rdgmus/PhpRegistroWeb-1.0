<!DOCTYPE table PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
if (!isset($utentiScuola)) {
	//Nella finestra changeOthersPassword.php non si vogliono utenti con password a null
	if ($GLOBALS['container'] == 1) {//CHANGE OTHERS PASSWORD
		//$utentiScuola = listaUtentiScuola(TRUE, TRUE);
		$utentiScuola = listaUtentiToChangePassword();
	}else
	$utentiScuola = listaUtentiScuola();
}

?>
<html>
<head></head>
<body>
	<form method="post" id="utentiSelectFrameForm"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"">
		<table>
		<?php if (isset($GLOBALS['utentiTitle'])) {
			if ($GLOBALS['utentiTitle']) {?>
			<tr>
				<th colspan="3">Utenti della Scuola</th>
			</tr>
			<?php }
			;
		}
		?>
			<tr>
				<td colspan="3"><?php echo (countPasswordToChangePending(1,1) == 0 ? '<span class="error">' : '')?>
				<select name="selectedRecipient"
					title="Utenti registrati"
					id="selectedRecipientId<?php echo $GLOBALS['container']?>">
					<?php
					while ($row = mysql_fetch_assoc($utentiScuola)) {
						$cognome = $row['cognome'];
						$nome = $row['nome'];
						$id_utente = $row['id_utente'];
						$email = $row['email'];
						if (!isset($_COOKIE['selectedRecipient'] )) {
							setcookie('selectedRecipient', $id_utente);
						}

						if (isset($row['request_date'])) {
							$request_date = $row['request_date'];
							$id_request =  $row['id_request'];
						}
						?>
						<option value="<?php echo $id_utente ?>"
						<?php if (isset($_COOKIE['selectedRecipient'])) {
							if ($_COOKIE['selectedRecipient'] == $id_utente) {
								echo 'selected="selected"';
							}
						}
						?>>
						<?php
						if ($GLOBALS['container'] == 1){
							echo $id_utente.'-'.$cognome.' '.$nome.' ['.$email.'] - '.$request_date;
						}else{
							echo $id_utente.'-'.$cognome.' '.$nome.' ['.$email.']';
						} ?>
						</option>
						<?php
					}
					if (countPasswordToChangePending(1,1) == 0 && $GLOBALS['container'] == 1) {?>
						<option>NESSUN RICHIESTA PENDENTE e CONFERMATA</option>
						<?php
					}
					?>

				</select>
				<?php echo (countPasswordToChangePending(1,1) == 0 ? '</span>' : '')?>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
