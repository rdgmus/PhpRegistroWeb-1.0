
<td>
    <table id="userMenuTable">
        <?php
        /**
         * 	QUESTO FRAME SI OCCUPA DI MOSTRARE LA LISTA DEGLI UTENTI DELLA SCUOLA
         * 	E DEI RISPETTIVI RUOLI RICOPERTI AL SUO INTERNO. AD OGNI RUOLO SARANNO
         * 	ASSOCIATE DELLE PAGINE VISUALIZZABILI E ALTRE NO.
         * 	IL FRAME SI OCCUPA ANCHE DI SETTARE O RIMUOVERE TALI RUOLI TRAMITE AJAX
         * 	QUESTO FRAME E' VISIBILE SOLO AGLI AMMINISTRATORI DEL DATABASE CHE 
         * 	HANNO `utenti_scuola`.'user_is_admin' = '1'
         *  SONO ESCLUSI DALLA LISTA QUEGLI UTENTI CHE NON HANNO PASSWORD MA SOLO EMAIL PER
         *  L'AGENDA EMAIL
         *
         * @author Roberto Della Grotta
         * @version 1.0
         * @copyright , 10 October, 2014
         * @package default
         */
        /*
          Se non esiste $_COOKIE['selectedUtente']
          imposta l'utente selezionato alla prima $row
          della listaUtentiScuola();
         */
        $mySqlFunctions = new MySqlFunctionsClass();

        if (NULL == filter_input(INPUT_COOKIE, 'selectedUtente')) {
            $utentiScuola = $mySqlFunctions->listaUtentiScuola(TRUE, FALSE);
            $row = mysql_fetch_assoc($utentiScuola);
            $selectedUtente = $row['id_utente'];
        } else {
            $selectedUtente = filter_input(INPUT_COOKIE, 'selectedUtente');
        }


        $utentiScuola = $mySqlFunctions->listaUtentiScuola(TRUE, FALSE);
        ?>

        <tr>
            <th><select name="selectedUtente" title="Utenti della Scuola"
                        id="selectedUtenteId" >
                            <?php
                            while ($row = mysql_fetch_assoc($utentiScuola)) {
                                $cognome = $row['cognome'];
                                $nome = $row['nome'];
                                $id_utente = $row['id_utente'];
                                ?>
                    <option value="<?php echo $id_utente ?>" data-isadmin="<?php echo $mySqlFunctions->userIsAdministrator($id_utente);?>"
                        <?php
                        if (NULL != filter_input(INPUT_COOKIE, 'selectedUtente')) {
                            if (filter_input(INPUT_COOKIE, 'selectedUtente') == $id_utente) {
                                echo 'selected="selected"';
                            }
                        }
                        ?>>
                                    <?php echo $cognome . ' ' . $nome . ' ' . $id_utente ?>

                        </option>

                    <?php }
                    ?>
                </select></th>
        </tr>
        <tr><td>
                <input type="hidden" name="userName" value="<?php echo $mySqlFunctions->getUserName($selectedUtente) ?>">
            </td></tr>

        <?php
        $result = $mySqlFunctions->getAdmittedRolesArray();


        while ($row = mysql_fetch_assoc($result)) {
            $id_ruolo = $row['id_ruolo'];
            $ruolo = $row['ruolo'];

            if (NULL != filter_input(INPUT_COOKIE, 'selectedUtente')) {
                $selectedUtente = filter_input(INPUT_COOKIE, 'selectedUtente');
                $hasRole = $mySqlFunctions->userHasRole($selectedUtente, $id_ruolo);
            }
            ?>


            <tr>
                <td><img alt="" id='ruoloId<?php echo $id_ruolo ?>'
                         src="<?php
                         echo ($hasRole ?
                                 'images/accept_icon.png' : 'images/dialog_close_icon.png');
                         ?>"
                         width="16" height="16" id="ruoloImage<?php echo $id_ruolo ?>"
                         
                         > 
                         <?php echo '<strong> - ' . $ruolo . '</strong>'; ?>
                    <input type="hidden" name="hasRole<?php echo $id_ruolo ?>" value="<?php echo $hasRole ?>">
                    <input type="hidden" name="role<?php echo $id_ruolo ?>" value="<?php echo $ruolo ?>">

                </td>
            </tr>
        <?php }
        ?>
    </table>
    <?php if (NULL != filter_input(INPUT_COOKIE, 'message')) { ?>
        <div id="dialogSuccess" title="Gestione Ruoli Utenti">
            <p>
                <?php echo '<h2>Query:</h2><hr> ' . filter_input(INPUT_COOKIE, 'message') ?>
            </p>
        </div>
        <?php
    }
    ?>
</td>
