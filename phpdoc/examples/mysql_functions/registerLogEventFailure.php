<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    /**
     * Registra evento relativo ad accesso fallito! nella tabella utenti_logger
     * 
     * @example functions/mysql_functions.php description
     * @param text $msgType - Corta descrizione dell'evento loggato
     * @param text $msgBody - Corpo del messaggio legato all'evento
     * @param bigint $id_utente - id dell'utente che ha lanciato l'evento
     * @param email $user_email - email dell'utente
     * @param password $password - password dell'utente
     * @param ip $ip - ip dal quale è stato effettuato il tentativo di accesso
     * @return boolean
     */
    function registerLogEventFailure($msgType, $msgBody, $id_utente, $user_email, $password, $ip) {
        if ($id_utente == null) {
            $query = sprintf("INSERT INTO scuola.utenti_logger " .
                    "(id_utente, message, msg_type, when_registered, msg_to_utente, msg_sent_time, errata_email, errata_password, ip_client)" .
                    " VALUES (NULL,'%s','%s',now(),0,null, '%s', '%s', '%s')", $msgBody, $msgType, mysql_real_escape_string($user_email), mysql_real_escape_string($password), $ip);
        } else {
            $msg = "RICHIESTA DI REGISTRAZIONE EVENTO FALLITO ERRATA!";
            setcookie('message', $msg);

            return FALSE;
        }
        if (connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {

            $result = mysql_query($query);

            if (!$result) {

                $msg = mysql_error();
                setcookie('message', mysql_error());
                //mysql_freeresult();
                closeConnection();
                return FALSE;
            }

            //mysql_freeresult();
            closeConnection();
            return FALSE;
        }
        return FALSE;
    }
