<?php

/*
 * Copyright (C) 2014 rdgmus
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of MySqlFunctionsClass
 *
 * @author rdgmus
 * @filesource
 */
class MySqlFunctionsClass {
    //put your code here

    /**
     * Registra evento relativo ad accesso fallito! nella tabella utenti_logger
     * 
     * @example phpdoc/examples/mysql_functions/registerLogEventFailure.php description
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
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {

            $result = mysql_query($query);

            if (!$result) {

                $msg = mysql_error();
                setcookie('message', mysql_error());
                //mysql_freeresult();
                $this->closeConnection();
                return FALSE;
            }

            //mysql_freeresult();
            $this->closeConnection();
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Registra eventi nella tabella utenti_logger
     * @param string $msgType
     * @param text $msgBody
     * @param bigint $id_utente
     * @param ip $ip IP dal quale è stato lanciato l'evento da loggare
     */
    function registerLogEvent($msgType, $msgBody, $id_utente, $ip) {
        if ($id_utente != null) {
            $query = sprintf("INSERT INTO scuola.utenti_logger " .
                    "(id_utente, message, msg_type, when_registered, msg_to_utente, msg_sent_time, ip_client)" .
                    " VALUES (%s,'%s','%s',now(),0,null, '%s')", $id_utente, $msgBody, $msgType, $ip);
        } else {
            $query = sprintf("INSERT INTO scuola.utenti_logger " .
                    "(id_utente, message, msg_type, when_registered, msg_to_utente, msg_sent_time, ip_client)" .
                    " VALUES (NULL,'%s','%s',now(),0,null, '%s')", $msgBody, $msgType, $ip);
        }

        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            $result = mysql_query($query);

            if (!$result) {

                $msg = mysql_error();
                setcookie('message', mysql_error());
                //mysql_freeresult();
                $this->closeConnection();
                return FALSE;
            }

            //mysql_freeresult();
            $this->closeConnection();
            return FALSE;
        }
        return FALSE;
    }

    /**
     *
     * Enter description here ...
     * @param bigint $id_request
     * @param string $hash
     * @param string $cognome
     * @param string $nome
     * @param rmail $email
     */
    function existRequestPendingFor($id_request, $hash, $cognome, $nome, $email) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA id_request dalla tabella
            $query = sprintf("SELECT * FROM scuola.change_password_request AS a, scuola.utenti_scuola AS b" .
                    " WHERE a.id_request = %s AND a.hash = '%s' AND  a.pending = 1 AND" .
                    " a.confirmed = 0 AND a.user_email = '%s' AND  b.cognome = '%s' AND  b.nome = '%s' AND a.user_email = b.email " .
                    " AND a.from_user = b.id_utente", $id_request, $hash, $email, strtoupper($cognome), strtoupper($nome));

            $result = mysql_query($query);

            if (!$result) {

                $msg = mysql_error();
                $this->closeConnection();
                return FALSE;
            }
            if (mysql_num_rows($result) == 1) {
                $this->closeConnection();
                return TRUE;
            }
            $this->closeConnection();
            return FALSE;
        }
        return FALSE;
    }

    /**
     *
     * Conferma la richiesta di cambiamento password in modo che un amministratore
     * possa operare il cambiamento ed inviare una email di conferma con le nuove
     * generalit&agrave; all'utente.
     * @param string $hash
     * @param bigint $id_request
     * @return boolean
     */
    function setRequestConfirmedFor($hash, $id_request) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA id_request dalla tabella
            $query = sprintf("UPDATE scuola.change_password_request" .
                    " SET confirmed = 1 WHERE id_request = %s AND hash = '%s'", $id_request, $hash);

            $result = mysql_query($query);

            $this->closeConnection();
            return $result;
        }
        return FALSE;
    }

    /**
     * 
     * Cancellazione della richiesta di cambiamento password.
     * @param string $hash
     * @param bigint $id_request
     * @return boolean
     */
    function confirmCancelRequestFor($hash, $id_request) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA id_request dalla tabella
            $query = sprintf("DELETE FROM scuola.change_password_request" .
                    " WHERE id_request = %s AND hash = '%s'", $id_request, $hash);

            $result = mysql_query($query);

            $this->closeConnection();
            return $result;
        }
        return FALSE;
    }

    /**
     * Recupera l'id della richiesta di cambio password effettuata dall'utente
     * tramite un hash generato
     *             $query = sprintf("SELECT id_request FROM scuola.change_password_request" .
     *               " WHERE hash = '%s'", $hash);
     * 
     * @param text $hash
     * @return bigint
     */
    function retrieveIdRequest($hash) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA id_request dalla tabella
            $query = sprintf("SELECT id_request FROM scuola.change_password_request" .
                    " WHERE hash = '%s'", $hash);

            $result = mysql_query($query);
            if (mysql_num_rows($result) != 1) {
                setcookie('message', mysql_error());
                $this->closeConnection();
                return NULL;
            } else {
                $row = mysql_fetch_row($result);
                $id_request = $row[0];
                $this->closeConnection();
                return $id_request;
            }
        }
        return NULL;
    }

    /**
     * Controlla se gi&agrave; &egrave; stata inoltrata una richiesta di
     * cambiamento di password per l'utente in oggetto. 
     * 
     * @param string $cognome
     * @param string $nome
     * @param email $email
     * @return boolean
     */
    function alreadyExistsPasswordRequestFor($cognome, $nome, $email) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA l'id_utente
            $query = sprintf("SELECT id_utente FROM scuola.utenti_scuola" .
                    " WHERE cognome = upper('%s') AND nome = upper('%s') AND email = '%s'", $cognome, $nome, $email);

            $result = mysql_query($query);
            if (mysql_numrows($result) != 1) {
                setcookie('message', mysql_error());
                $this->closeConnection();
                return FALSE;
            } else {
                $row = mysql_fetch_row($result);
                $id_utente = $row[0];
                //Registra la richiesta
                $query = sprintf("SELECT  * FROM scuola.change_password_request"
                        . " WHERE from_user = %s AND pending = 1", $id_utente);

                // Perform Query
                $result = mysql_query($query);
                if (!$result) {
                    setcookie('message', mysql_error());
                    $this->closeConnection();
                    return FALSE;
                } else {
                    if (mysql_num_rows($result) > 0) {
                        $this->closeConnection();
                        return TRUE;
                    }
                    $this->closeConnection();
                    return FALSE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Su richiesta di un utente che ha dimenticato la password,
     * fornendo cognome, nome ed email, viene recuperato dalla tabella utenti_scuola, l'id_utente
     * relativo alle credenziali fornite e quindi inserito un nuovo record
     * di richiesta per cambio password, nella tabella change_password_request.
     * 
     * @param text $cognome
     * @param text $nome
     * @param email $email
     * @param hash $hash
     * @return boolean
     */
    function postChangePasswordRequest($cognome, $nome, $email, $hash) {

        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            //RECUPERA l'id_utente
            $query = sprintf("SELECT id_utente FROM scuola.utenti_scuola" .
                    " WHERE cognome = upper('%s') AND nome = upper('%s') AND email = '%s'", $cognome, $nome, $email);

            $result = mysql_query($query);
            if (mysql_numrows($result) != 1) {
                setcookie('message', mysql_error());
                $this->closeConnection();
                return FALSE;
            } else {
                $row = mysql_fetch_row($result);
                $id_utente = $row[0];
                //Registra la richiesta
                $query = sprintf("INSERT INTO scuola.change_password_request(
		from_user, hash) VALUES(%s, '%s')", $id_utente, $hash);

                // Perform Query
                $result = mysql_query($query);
                if (!$result) {
                    setcookie('message', mysql_error());
                    $this->closeConnection();
                    return FALSE;
                } else {
                    $this->closeConnection();
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * SETTA A 1 IL CAMPO Has_To_Change_Password in utenti_scuola
     * questa funzione viene utilizzata dagli amministratori: nel momento che
     * cambiano la password su richiesta di un utente, settano = 1 il campo
     * in modo che l'utente riceva l'invito a cambiare la password.
     * Un'altro caso in cui viene utilizzata � quando l'utente,
     * dopo aver ricevuto la password dall'admin esegue il cambio di password;
     * allora il campo viene riportato = 0.
     * 
     * @param bigint $user - id_utente
     * @param password $value
     * @return boolean
     */
    function setUserHasToChangePassword($user, $value) {
        if ($this->connectToMySql()) {
            $query = sprintf("UPDATE scuola.utenti_scuola
		SET has_to_change_password = %s WHERE id_utente = %s", $value, $user);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Verifica se l'utente $user ha un invito a cambiare la propria password;
     * questo si verifica quando viene richiesta una nuova password perch� persa
     * o dimenticata, allora l'utente che entra per la prima volta con le nuove
     * credenziali, dopo la presente verifica ricever� un invito ossessivo,
     * a cambiare la propria password.
     *
     * @param bigint $user
     * @return boolean
     */
    function hasUserToChangePassword($user) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT has_to_change_password FROM scuola.utenti_scuola
		 WHERE id_utente = %s", $user);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
            $row = mysql_fetch_assoc($result);
            $has_to_change_password = $row['has_to_change_password'];
            return $has_to_change_password;
        }
    }

    /**
     * Recupera la password dell'utente in chiaro.
     * @param bigint $id_utente
     */
    function retrievePassword($id_utente) {

        $query = sprintf("SELECT password FROM scuola.utenti_scuola WHERE id_utente = %s", $id_utente);

        // Perform Query
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)) {
            $password = $row['password'];
        }

        return base64_decode(base64_decode($password));
    }

    /**
     * Ritorna il massimo id_recipient ovvero l'id ultimo con il quale
     * il destinatario di una email , inserito nella casella TO, CC o BCC,
     * � stato registrato nella tabella email_recipients. Questo id serve per
     * l'operazione di cancellazione del destinatario ultimo inserito.
     * @param email $id_email
     * @param string $param - to, cc, bcc
     */
    function getMaxIdRecipient($id_email, $param) {
        $query = "SELECT max(id_recipient) as max_id_recipient FROM scuola.email_recipients" +
                " WHERE id_email = %s";
        if ($param == 'to') {
            $query+=" AND to_recipient = '1'";
        } elseif ($param == 'cc') {
            $query+=" AND cc_recipient = '1'";
        } elseif ($param == 'bcc') {
            $query+=" AND bcc_recipient = '1'";
        }
        $queryWithParameters = sprintf($query, $id_email);
        if ($this->connectToMySql()) {
            // Perform Query
            $result = mysql_query($queryWithParameters);
            if (!$result) {
                setcookie('message', mysql_error());
            }
            $row = mysql_fetch_assoc($result);
        }
        $this->closeConnection();
        return $row['max_id_recipient'];
    }

    /**
     * Cancella ultimo destinatario inserito nella casella $param (i.e. TO, CC, BCC)
     * @param bigint $id_email
     * @param string $param - to, cc, bcc
     */
    function undoLastRecipient($id_email, $param) {
        if ($param == 'to') {
            $id_recipient = getMaxIdRecipient($id_email, $param);
            if ($id_recipient != null) {
                if ($this->connectToMySql()) {
                    $query = sprintf("DELETE FROM scuola.email_recipients
			WHERE id_email = %s 
			AND to_recipient = '1' 
			AND id_recipient = %s", $id_email, $id_recipient);


                    // Perform Query
                    $result = mysql_query($query);
                    if (!$result) {
                        setcookie('message', mysql_error());
                    }
                }
                $this->closeConnection();
                return $result;
            }
        } elseif ($param == 'cc') {
            $id_recipient = getMaxIdRecipient($id_email, $param);
            if ($id_recipient != null) {
                if ($this->connectToMySql()) {
                    $query = sprintf("DELETE FROM scuola.email_recipients
			WHERE id_email = %s 
			AND cc_recipient = '1' 
			AND id_recipient = %s", $id_email, $id_recipient);


                    // Perform Query
                    $result = mysql_query($query);
                    if (!$result) {
                        setcookie('message', mysql_error());
                    }
                }
                $this->closeConnection();
                return $result;
            }
        } elseif ($param == 'bcc') {
            $id_recipient = getMaxIdRecipient($id_email, $param);
            if ($id_recipient != null) {
                if ($this->connectToMySql()) {
                    $query = sprintf("DELETE FROM scuola.email_recipients
			WHERE id_email = %s 
			AND bcc_recipient = '1' 
			AND id_recipient = %s", $id_email, $id_recipient);


                    // Perform Query
                    $result = mysql_query($query);
                    if (!$result) {
                        setcookie('message', mysql_error());
                    }
                }
                $this->closeConnection();
                return $result;
            }
        } else
            return false;
    }

    /**
     * Aggiunge un destinatario dell'email o chi la invia, nella tabella
     * scuola.email_recipients
     * @param bigint $id_email
     * @param email $recip_email
     * @param string $recip_name
     * @param tinyint $to
     * @param tinyint $cc
     * @param tinyint $bcc
     */
    function addRecipientToEmail($id_email, $recip_email, $recip_name, $to, $cc, $bcc) {
        if ($this->connectToMySql()) {
            $query = sprintf("INSERT INTO scuola.email_recipients(
		id_email, email, name, to_recipient, cc_recipient, bcc_recipient)" .
                    "VALUES (%s,'%s','%s',%s,%s,%s)", $id_email, $recip_email, $recip_name, $to, $cc, $bcc);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Test if recipient for email already exists into scuola.email_recipients
     * @param bigint $id_email
     * @param email $recip_email
     * @param string $recip_name
     * @param tinyint $to
     * @param tinyint $cc
     * @param tinyint $bcc
     */
    function recipientExists($id_email, $recip_email, $recip_name) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_recipients WHERE
		id_email = %s AND
		email = '%s' AND
		name = '%s'", $id_email, $recip_email, $recip_name);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return mysql_num_rows($result) == 1;
    }

    /**
     * scuola.mysql_servers_groups
     * Raggruppamento dei server in classi contenenti i parametri
     * per la connessione via port o socket
     */
    function getMySqlServerGroups() {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            $query = sprintf("SELECT * FROM scuola.mysql_servers_groups");

            // Perform Query
            $result = mysql_query($query);
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * scuola.mysql_server_params
     * Parametri della connessione dei server appartenenti ad un gruppo.
     * @param $serverGroup
     * @return server del gruppo
     */
    function getMySqlServerParams($serverGroup) {
        if ($this->connectToMySqlWithParams('localhost:3307', 'root', 'myzconun')) {
            $query = sprintf("SELECT * FROM scuola.mysql_server_params WHERE  id_server_group = %s ", $serverGroup);

            // Perform Query
            $result = mysql_query($query);
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * id dell'emails create con data ancora = null
     * appartenenti all'utente indicato
     * @param $id_user
     * @return mail dell'utente con data_email = null
     */
    function getNewEmailId($id_user) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_store WHERE isnull(data_email)" .
                    " AND id_user = %s", $id_user);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error($GLOBALS['link']));
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Info Email da tabella email_store
     *
     * @param bigint $id_email
     * @return  una descrizione della email per mostrarla all'utente
     */
    function getInfoEmail($id_email) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_store WHERE id_email = %s", $id_email);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error($GLOBALS['link']));
                $info = 'NO INFO!';
            } else {
                $row = mysql_fetch_assoc($result);
                $info = 'Email:' . $id_email . ' from:' . $row['from_name'] . '<' . $row['from_email'] . '>';
            }
        }
        $this->closeConnection();
        return $info;
    }

    /**
     * Cancella una email dalla tabella email_store
     * @param bigint $id_user
     * @param bigint $id_email
     */
    function deleteNullEmail($id_user, $id_email) {
        if ($this->connectToMySql()) {
            $query = sprintf("DELETE FROM scuola.email_store WHERE id_user = '%s'" .
                    " AND id_email = '%s'" .
                    " AND isnull(data_email)", $id_user, $id_email);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }//else
            //setcookie('message','Creata nuova Email');
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Crea un record di email in scuola.email_store
     * con data = null
     * @param email $from_email
     * @param string $from_name
     * @param bigint $id_user
     */
    function createEmail($from_email, $from_name, $id_user) {
        $result = getNewEmailId($id_user); //Contiene le email dell'utente con data a null
        if (mysql_num_rows($result) > 0) {//Se vi sono email pregresse ritorna la lista delle email pregresse
            return $result;
        }
        if ($this->connectToMySql()) {
            $query = sprintf("INSERT INTO scuola.email_store(from_email, from_name, id_user, subject, body) VALUES ('%s','%s', '%s', '<NO SUBJECT>', '<NO BODY>')", $from_email, $from_name, $id_user);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }//else
            //setcookie('message','Creata nuova Email');
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Array dei recipient nelle varie mailbox
     * @param bigint $emailId
     * @param string $mailbox - to, cc, bcc
     */
    function getArrayOfRecipientsInMailBox($emailId, $mailbox) {
        if ($this->connectToMySql()) {
            if ($mailbox == 'to') {
                $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND to_recipient = 1", $emailId);
            } elseif ($mailbox == 'cc') {
                $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND cc_recipient = 1", $emailId);
            } elseif ($mailbox == 'bcc') {
                $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND bcc_recipient = 1", $emailId);
            }

            $recipients = array();
            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            } else {
                if (mysql_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysql_fetch_assoc($result)) {
                        $recipients[$i] = array('name' => $row['name'], 'email' => $row['email']);
                        $i++;
                    }
                }
            }
        }
        $this->closeConnection();
        return $recipients;
    }

    /**
     * Lista dei recipienti dell'email indicata nella casella To
     * @param bigint $emailId
     * @return string
     */
    function getToRecipients($emailId) {
        // SELECT * FROM `email_recipients` WHERE `id_email` = %s AND `to_recipient` = 1
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND to_recipient = 1", $emailId);

            $recipients = '';
            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            } else {
                //$recipients = array();
                //$i=0;
                if (mysql_num_rows($result) > 0) {
                    while ($row = mysql_fetch_assoc($result)) {
                        //$recipients = array_fill($i, 1, $row['email'].';');
                        //$i++;
                        $recipients .= $row['name'] . '<' . $row['email'] . '>;';
                    }
                }
            }
        }
        $this->closeConnection();
        return $recipients;
    }

    /**
     * Lista dei recipienti dell'email indicata nella casella Cc
     * @param bigint $emailId
     * @return string
     */
    function getCcRecipients($emailId) {
        // SELECT * FROM `email_recipients` WHERE `id_email` = %s AND `to_recipient` = 1
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND cc_recipient = 1", $emailId);

            $recipients = '';
            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            } else {
                //$recipients = array();
                //$i=0;
                if (mysql_num_rows($result) > 0) {
                    while ($row = mysql_fetch_assoc($result)) {
                        //$recipients = array_fill($i, 1, $row['email'].';');
                        //$i++;
                        $recipients .= $row['name'] . '<' . $row['email'] . '>;';
                    }
                }
            }
        }
        $this->closeConnection();
        return $recipients;
    }

    /**
     * Lista dei recipienti dell'email indicata nella casella Bcc
     * 
     * @param bigint $emailId
     * @return string
     */
    function getBccRecipients($emailId) {
        // SELECT * FROM `email_recipients` WHERE `id_email` = %s AND `to_recipient` = 1
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT * FROM scuola.email_recipients WHERE id_email = %s AND bcc_recipient = 1", $emailId);

            $recipients = '';
            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            } else {
                //$recipients = array();
                //$i=0;
                if (mysql_num_rows($result) > 0) {
                    while ($row = mysql_fetch_assoc($result)) {
                        //$recipients = array_fill($i, 1, $row['email'].';');
                        //$i++;
                        $recipients .= $row['name'] . '<' . $row['email'] . '>;';
                    }
                }
            }
        }
        $this->closeConnection();
        return $recipients;
    }

    /**
     * Enter description here ...
     * @param bigint $emailId
     * @param text $subject
     * @param text $body
     */
    function saveEmailDraft($emailId, $subject, $body) {
        if ($this->connectToMySql()) {
            $query = sprintf("UPDATE scuola.email_store
		SET subject = \"%s\", body = \"%s\" WHERE id_email = %s", mysql_real_escape_string($subject), mysql_real_escape_string($body), ($emailId));

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Enter description here ...
     * @param bigint $emailId
     */
    function getEmailSubject($emailId) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT subject FROM scuola.email_store WHERE id_email = %s", $emailId);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
            $row = mysql_fetch_assoc($result);
            $subject = $row['subject'];
        }
        $this->closeConnection();
        return ($subject == null || strlen($subject) == 0) ? '<NO SUBJECT>' : test_input($subject);
    }

    /**
     * Enter description here ...
     * @param unknown_type $emailId
     * @param unknown_type $subject
     */
    function setEmailSubject($emailId, $subject) {
        if ($this->connectToMySql()) {
            $query = sprintf("UPDATE scuola.email_store
		SET subject = \"%s\" WHERE id_email = %s", mysql_real_escape_string($subject), ($emailId));

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Enter description here ...
     * @param unknown_type $emailId
     */
    function getEmailBody($emailId) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT body FROM scuola.email_store WHERE id_email = %s", $emailId);

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
            $row = mysql_fetch_assoc($result);
            $body = $row['body'];
        }
        $this->closeConnection();
        return ($body == null || strlen($body) == 0) ? '<NO BODY>' : test_input($body);
    }

    /**
     * Enter description here ...
     * @param unknown_type $emailId
     * @param unknown_type $body
     */
    function setEmailBody($emailId, $body) {
        if ($this->connectToMySql()) {
            $query = sprintf("UPDATE scuola.email_store
		SET body = \"%s\" WHERE id_email = %s", mysql_real_escape_string($body), ($emailId));

            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                setcookie('message', mysql_error());
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Controlla che l'utente sia AMMINISTRATORE
     * @param  $id_utente
     * @return boolean
     */
    function userIsAdministrator($id_utente) {

        $query = sprintf("SELECT user_is_admin FROM scuola.utenti_scuola WHERE id_utente = %s", $id_utente);

        // Perform Query
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)) {
            $user_is_admin = $row['user_is_admin'];
        }
        if ($user_is_admin == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Setta il record in change_password_request,
     * con request_served, pending = 0 (non more pending)
     * 
     * @param bigint $user
     * @param bigint $admin
     * @return boolean
     */
    function removePendingFromUserRequest($user, $admin) {

        $query = sprintf("UPDATE scuola.change_password_request " .
                " SET pending = 0, request_done = 1 , email_sent = 1, " .
                " id_admin = %s, request_done_date = now() WHERE from_user = %s AND pending = 1", $admin, $user);

        // Perform Query
        $result = mysql_query($query);

        return $result;
    }

    /**
     * Registra nel database l'orario di invio dell'email e mette a inviato il flag email_inviata
     * @param unknown_type $emailId
     */
    function registerEmailInviata($emailId) {
        //echo $emailId;
        if ($this->connectToMySql()) {
            $query = sprintf("UPDATE scuola.email_store
			 SET email_inviata = 1 WHERE id_email = %s ", $emailId);


            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                //die('<span class="error">'.mysql_error().'</span>');
                setcookie("message", mysql_error());
            }
            //setcookie("message",$query );
            $this->closeConnection();
            return $result;
        }
        return FALSE;
    }

    /**
     * Ottiene l'id dell'utente con le date credenziali
     * 
     * @param email $user_email
     * @param password $password
     * @return bigint
     */
    function getUserId($user_email, $password) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT id_utente FROM scuola.utenti_scuola WHERE email = '%s'
		 AND password = '%s'", mysql_real_escape_string($user_email), mysql_real_escape_string(base64_encode(base64_encode($password))));

            // Perform Query
            $result = mysql_query($query);

            while ($row = mysql_fetch_assoc($result)) {
                $id_utente = $row['id_utente'];
            }
            $this->closeConnection();
            return $id_utente;
        }
    }

    /**
     * Ritorna l'email dell'utente fornito come parametro
     * @param $id_utente bigint
     * @return string
     */
    function getUserEmail($id_utente) {

        $query = sprintf("SELECT email FROM scuola.utenti_scuola WHERE id_utente = %s", $id_utente);

        // Perform Query
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)) {
            $email = $row['email'];
        }
        return $email;
    }

    /**
     * Enter description here ...
     * @param bigint $id_utente
     */
    function getUserName($id_utente) {

        $query = sprintf("SELECT cognome, nome FROM scuola.utenti_scuola WHERE id_utente = %s", $id_utente);

        // Perform Query
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)) {
            $name = $row['cognome'] . ' ' . $row['nome'];
        }
        return $name;
    }

    /**
     * Carica i ruoli e le abilitazioni agli stessi dell'utente
     * 
     * @param bigint $id_utente
     * @return array
     */
    function getUserRoles($id_utente) {
        $userRoles = array();
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT id_ruoli_granted, id_utente, id_ruolo, ruolo "
                    . "FROM scuola.ruoli_granted_to_utenti WHERE id_utente = %s", $id_utente);

            // Perform Query
            $result = mysql_query($query);

            $i = 1;
            while ($row = mysql_fetch_assoc($result)) {
                $userRoles[$i] = array('id_utente' => $row['id_utente'],
                    'id_ruolo' => $row['id_ruolo'], 'ruolo' => $row['ruolo']);
                $i++;
            }
            $this->closeConnection();
        }
        return $userRoles;
    }

    /**
     * Abilita o disabilita ruoli per gli utenti
     * @param bigint $id_utente
     * @param bigint $id_ruolo
     * @return boolean
     */
    function setUnsetRuoloUtente($id_utente, $id_ruolo) {

        if ($this->connectToMySql()) {
            if ($this->userHasRole($id_utente, $id_ruolo)) {
                $query = sprintf("DELETE FROM scuola.ruoli_granted_to_utenti
		WHERE id_utente = %s and id_ruolo = %s", $id_utente, $id_ruolo);
            } else {

                $query = sprintf("INSERT INTO scuola.ruoli_granted_to_utenti ( id_utente ,  id_ruolo )
			VALUES (%s,%s)", $id_utente, $id_ruolo);
            }


            // Perform Query
            $result = mysql_query($query);
            if (!$result) {
                //die('<span class="error">'.mysql_error().'</span>');
                setcookie("message", mysql_error());
            }
            //setcookie("message",$query );
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * La funzione ritorna TRUE or FALSE in base al fatto che l'utente contrassegnato dall'$id_utente
     * sia abilitato nella tabella ruoli_granted_to_utenti
     * al ruolo contrassegnato $id_ruolo
     *
     * @param  $id_utente
     * @param  $id_ruolo
     * @return boolean
     */
    function userHasRole($id_utente, $id_ruolo) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT id_ruoli_granted, id_utente, id_ruolo, ruolo FROM scuola.ruoli_granted_to_utenti
		WHERE id_utente= '%s' and id_ruolo = '%s'", mysql_real_escape_string($id_utente, $GLOBALS['link']), mysql_real_escape_string($id_ruolo, $GLOBALS['link']));

            // Perform Query
            $result = mysql_query($query);
            //$array = mysql_fetch_assoc($result);
        }
        $this->closeConnection();
        return mysql_num_rows($result) == 1;
    }

    /**
     * Lista degli utenti della scuola.
     * @param  $passordIsNull [OPTIONAL DEFAULT FALSE]- se TRUE SELECT...WHERE NOT isnull(password) =>
     * SONO ESCLUSI DALLA LISTA QUEGLI UTENTI CHE NON HANNO PASSWORD
     * @param  $userNotVisible [OPTIONAL DEFAULT FALSE] - se TRUE SELECT...WHERE id_utente != $_COOKIE['id_utente'] =>
     * ESCLUDE DALLA LISTA L' UTENTE AMMINISTRATORE CHE E' ANCHE L'UTENTE ATTIVO E HA id_utente = $_COOKIE['id_utente']
     */
    function listaUtentiScuola($passordIsNull = FALSE, $userNotVisible = FALSE) {
        if ($this->connectToMySql()) {
            $query = "SELECT  id_utente ,  cognome ,  nome ,  email ,  password ,
	 user_is_admin  FROM  scuola.utenti_scuola ";
            if ($passordIsNull && !$userNotVisible) {//$passordIsNull TRUE
                $query .= " WHERE NOT isnull(password) ";
            } elseif (!$passordIsNull && $userNotVisible) {//$userNotVisible TRUE
                $query .= "WHERE id_utente != " . $_COOKIE['id_utente'];
            } elseif ($passordIsNull && $userNotVisible) {
                $query .= " WHERE NOT isnull(password) AND id_utente != " . $_COOKIE['id_utente'];
            }
            $query .= " ORDER BY cognome ,  nome";
            // Perform Query
            $result = mysql_query($query);
            //$array = mysql_fetch_assoc($result);
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Conta il numero di utenti con richieste di cambion password pendenti
     * @return numero di richieste pendenti e confermate
     */

    /**
     * Conta il numero di utenti con richieste di cambio password pendenti e/o confermate
     * @param tinyint $pending [DEFAULT TRUE]
     * @param tinyint $confirmed [DEFAULT TRUE]
     */
    function countPasswordToChangePending($pending = 1, $confirmed = 1) {
        $result = $this->listaUtentiToChangePassword($pending, $confirmed);
        return mysql_num_rows($result);
    }

    /**
     * Lista delle richieste pendenti ($pending = 1) e/o confermate ($confirmed = 1)
     * @param tinyint $pending [DEFAULT TRUE]
     * @param tinyint $confirmed [DEFAULT TRUE]
     */
    function listaUtentiToChangePassword($pending = 1, $confirmed = 1) {
        if ($this->connectToMySql()) {
            $query = sprintf("SELECT a.id_utente, a.cognome, a.nome, a.email, b.request_date, b.id_request "
                    . " FROM scuola.utenti_scuola as a,"
                    . " scuola.change_password_request as b "
                    . " WHERE b.pending = %s AND b.confirmed = %s AND a.id_utente = b.from_user"
                    . " ORDER BY b.request_date, a.cognome, a.nome ", $pending, $confirmed);

            // Perform Query
            $result = mysql_query($query);
            //$array = mysql_fetch_assoc($result);
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Elenco dei  ruoli utente ammessi dal database.
     *
     * @return resource
     */
    function getAdmittedRolesArray() {

        if ($this->connectToMySql()) {
            $query = sprintf("SELECT id_ruolo, ruolo FROM scuola.ruoli_utenti ORDER BY id_ruolo");

            // Perform Query
            $result = mysql_query($query);
            //$array = mysql_fetch_assoc($result);
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Ottiene le informazioni sul server Apache
     * 	@return object containing server information
     */
    function getServerInfo() {
        $serverInfo = mysql_get_server_info();
        return $serverInfo;
    }

    /**
     * Recupera i parametri di connessione al server MySql
     * in base alle scelte fatte dall'utente nella pagina iniziale.<br>
     * Questa feature dovr� essere disabilitata ?!
     * @return Ambigous <string, multitype:string >
     */
    function getServerConnectionParameters() {
        $paramsArray = array("", "", "");
        $MYSQL_SERVER = $_COOKIE['MYSQL_SERVER'];
        if ($MYSQL_SERVER == 'PORT:3306') {
            //MySql SERVER DEL MACBOOK su PORTA 3306
            $paramsArray[0] = 'localhost:3306';
            $paramsArray[1] = "root";
            $paramsArray[2] = "iw3072ylA";

            //$link = mysql_connect($server, $server_user, $server_passwd);
        } elseif ($MYSQL_SERVER == 'SOCKET:3306') {
            //MySql SERVER DEL MACBOOK su PORTA 3306 con SOCKET
            $paramsArray[0] = ':/tmp/mysql.sock';
            $paramsArray[1] = "root";
            $paramsArray[2] = "iw3072ylA";

            //$link = mysql_connect($socket, $socket_user, $socket_passwd);
        } elseif ($MYSQL_SERVER == 'PORT:3307') {
            //MySql SERVER IMPLEMENTATO IN XAmpp su PORTA 3307
            $paramsArray[0] = 'localhost:3307';
            $paramsArray[1] = "root";
            $paramsArray[2] = "myzconun";

            //$link = mysql_connect($server, $server_user, $server_passwd);
        } elseif ($MYSQL_SERVER == 'SOCKET:3307') {
            //MySql SERVER IMPLEMENTATO IN XAmpp su PORTA 3307 con SOCKET
            $paramsArray[0] = ':/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
            $paramsArray[1] = "root";
            $paramsArray[2] = "myzconun";
        }
        $link = mysql_connect($paramsArray[0], $paramsArray[1], $paramsArray[2]);
        return $paramsArray;
    }

    /**
     * Effettua la connessione al database MySql
     * @return boolean
     */
    function connectToMySql() {
        global $link;


        $paramsArray = $this->getServerConnectionParameters();
        if (!isset($paramsArray)) {
            die("Non ho potuto risalire ai parametri di connessione al server MySql");
        }
        $link = mysql_connect($paramsArray[0], $paramsArray[1], $paramsArray[2]);



        if (!$link) {
            $msg = 'Could not connect: ' . mysql_error();
            setcookie('message', "<span class='message'>$msg</span><br>");
            //echo "<span class='message'>$msg</span><br>" ;
            return FALSE;
        }
        $msg = "<span class='message'>Connected successfully to $paramsArray[0] </span><br>";
        //setcookie('message', "<span class='message'>$msg</span><br>");
        return TRUE;
    }

    /**
     * Effettua la connessione al database MySql con i parametri indicato
     * @param string $server
     * @param string $username
     * @param password $password
     */
    function connectToMySqlWithParams($server, $username, $password) {

        $link = mysql_connect($server, $username, $password);

        if (!$link) {
            $msg = 'Could not connect: ' . mysql_error();
            setcookie('message', "<span class='message'>$msg</span><br>");
            //echo "<span class='message'>$msg</span><br>" ;
            return FALSE;
        }
        $msg = "<span class='message'>Connected successfully to $server </span><br>";
        //setcookie('message', "<span class='message'>$msg</span><br>");
        return TRUE;
    }

    /**
     * Chiude la connessione al database MySql
     * @return boolean
     */
    function closeConnection() {
        return mysql_close();
    }

    /**
     * Crea il record per l'utente che si sta registrando all'applicazione
     * @param  $name
     * @param  $surname
     * @param  $user_email
     * @param  $password
     * @return resource
     */
    function createUtenteScuola($name, $surname, $user_email, $password) {
        // This could be supplied by a user, for example
        // Formulate Query
        // This is the best way to perform an SQL query
        // For more examples, see mysql_real_escape_string()
        $query = sprintf("INSERT INTO scuola.utenti_scuola(cognome, nome, email, password)" .
                "VALUES ('%s','%s','%s','%s')", mysql_real_escape_string(strtoupper($surname), $GLOBALS['link']), mysql_real_escape_string(strtoupper($name), $GLOBALS['link']), mysql_real_escape_string($user_email, $GLOBALS['link']), mysql_real_escape_string(base64_encode(base64_encode($password)), $GLOBALS['link']));

        // Perform Query
        $result = mysql_query($query);
        if ($result) {
            $msg = "Utente Scuola creato: " . $surname . " " . $name;
            setcookie("message", $msg);
        }
        return $result;
    }

    /**
     * Autenticazione utente per l'accesso all'applicazione
     * 
     * @param email $user_email
     * @param password $password
     * @param boolean $isLogin
     * @return boolean
     */
    function authenticateUser($user_email, $password, $isLogin) {
        // This could be supplied by a user, for example
        // Formulate Query
        // This is the best way to perform an SQL query
        // For more examples, see mysql_real_escape_string()
        $query = sprintf("SELECT * FROM scuola.utenti_scuola WHERE email='%s' AND password='%s'", mysql_real_escape_string($user_email, $GLOBALS['link']), mysql_real_escape_string(base64_encode(base64_encode($password)), $GLOBALS['link']));

        // Perform Query
        $result = mysql_query($query);

        // Check result
        // This shows the actual query sent to MySQL, and the error. Useful for debugging.
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "<br>";
            $message .= 'Whole query: ' . $query . "<br>";
            echo($message);
            mysql_free_result($result);
            return FALSE;
        }
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 1) {
            if ($isLogin) {//SE SIAMO AL LOGIN REGISTRA LE CREDENZIALI DELL'UTENTE NELL COOKYES
                $row = mysql_fetch_assoc($result);
                setcookie("cognome_user", $row['cognome']);
                setcookie("nome_user", $row['nome']);
                setcookie("email_user", $row['email']);
                setcookie("id_utente", $row['id_utente']);
            }
        } else {
            mysql_free_result($result);
            return FALSE;
        }
        mysql_free_result($result);
        return TRUE;
    }

    /**
     * Cambio password utente scuola
     * @param bigint $id_utente
     * @param email $user_email
     * @param password $oldpassword
     * @param password $newpassword
     */
    function changeUtenteScuolaPassword($id_utente, $user_email, $oldpassword, $newpassword) {
        if ($this->authenticateUser($user_email, $oldpassword, FALSE)) {
            // This could be supplied by a user, for example

            $query = sprintf("UPDATE scuola.utenti_scuola SET password='%s' " .
                    "WHERE id_utente = '%s'", mysql_real_escape_string(base64_encode(base64_encode($newpassword)), $GLOBALS['link']), $id_utente);

            // Perform Query
            $result = mysql_query($query);
            if ($result) {
                $msg = '<span class="error">PASSWORD cambiata per l\'utente: <h2>' . $this->getUserName($id_utente) . '</h2> email: <h3>' . $user_email . '</h3></span>';
                setcookie("message", $msg);
            } else {
                $msg = '<span class="error">Non � stato possibile cambiare la PASSWORD per ' .
                        $user_email . ': ' . mysql_error($GLOBALS['link']) . '</span>';
                setcookie("message", $msg);
            }
            return $result;
        }
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $selectedRecipient
     * @param unknown_type $user_email
     * @param unknown_type $oldpassword
     * @param unknown_type $password
     */
    function changePassword($selectedRecipient, $user_email, $oldpassword, $password) {
        if ($this->connectToMySql()) {
            //QUERY FOR USER ACCOUNT HERE
            if ($this->authenticateUser($user_email, $oldpassword, FALSE)) {
                //QUI CAMBIA LA PASSWORD
                $this->changeUtenteScuolaPassword($selectedRecipient, $user_email, $oldpassword, $password);
                $this->closeConnection();
                return TRUE;
            } else {
                $msg = '<span class="error">L\'utente selezionato non ha i permessi di accesso!</span>';
                setcookie("message", $msg);
                $this->closeConnection();
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $password
     */
    function testPasswordErr($password) {
        if (empty($password)) {
            $passwordErr = 'Password required';
        } else {
            $password = test_input($password);
            //VALIDATE PASSWORD
            if (!filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,10})")))) {
                //da 4 a 10 caratteri, deve contenere maiuscole, minuscole e numeri
                $passwordErr = "Invalid Password format";
            } else
                $passwordErr = "*";
        }
        return $passwordErr;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $password
     * @param unknown_type $password_one
     */
    function testPasswordsAreEqual($password, $password_one) {
        if (empty($password_one)) {
            $passwordErr = 'Password required';
        } elseif (strlen($password) > 0 && strlen($password_one) > 0 && $password == $password_one) {
            //QUERY FOR DATABASE CONNECTION HERE
            if (!filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,10})")))) {
                //da 4 a 10 caratteri, deve contenere maiuscole, minuscole e numeri
                $passwordErr = "Invalid Password format";
            } else
                $passwordErr = "*";
        }else {
            $passwordErr = 'Passwords do not match!';
        }
        return $passwordErr;
    }

}
