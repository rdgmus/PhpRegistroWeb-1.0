<?php
/**
 * GESTIONE RUOLI UTENTI
 * 
 * PAG. userMenu.php
 * 
 * @author Roberto Della Grotta
 * @version phpVer.1.0
 * @copyright Roberto Della Grotta, 15 October, 2014
 * @package JQUERY_FUNCTIONS
 * @filesource
 * 
 */

/**
 * Class introdotta per tentare di inglobare le funzioni che 
 * gestiscono i ruoli assegnati agni utenti
 */
class RuoliUtentiActions {

    /**
     * Dati in input postati dalla pagina serializzati
     * @var object 
     */
    var $mydata;

    /**
     * Ruolo Utente
     * @var string 
     */
    var $ruolo;

    /**
     * Ha gi&agrave l'abilitazione oppure no al ruolo indicato
     * @var boolean 
     */
    var $hasRole;

    /**
     * Utente sul quale si sta operando
     * @var int 
     */
    var $selectedUtente;

    /**
     * Nome dell'utente
     * @var string 
     */
    var $userName;

    /**
     * Cambia il ruolo dell'utente nel senso che viene abilitato
     * o disabilitato dalla funzione
     * @param string $ruolo
     * @param boolean $hasRole
     * @param int $selectedUtente
     * @param string $userName
     * @param object $mydata
     */
    function cambiaRuoloInterno($ruolo, $hasRole, $selectedUtente, $userName, $mydata) {
        if ($hasRole) {
            $cambiare = "disabilitare";
        } else {
            $cambiare = "abilitare";
        }
        ?>
        <script>
            //$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
            $.prompt("<h3>Vuoi " + $('cambiare').val() + " i permessi per il ruolo di </h3><h2>" +
                    $('ruolo').val() + "</h2><h3> all'utente </h3><h2>"
                    + $('userName').val() + "</h2> <h3>(" + $('selectedUtente').val() + ") ? </h3>", {
                title: "<h1>Ruoli Utente</h1>",
                buttons: {"<h2>Si</h2>": true, "No": false},
                submit: function (e, v, m, f) {
                    // use e.preventDefault() to prevent closing when needed or return false. 
                    //e.preventDefault(); 

                    //alert("Value clicked was: "+ v);
                    if (v) {
                        $.ajax({
                            type: "POST",
                            url: 'ajax.php',
                            data: $('mydata').val(),
                            success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                //alert(response);

                                window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userMenu.php";
                            }
                        });
                    }

                }
            });
        </script>
        <?php
    }

}
?>
<link
    href="jquery/select2-3.5.1/select2.css" rel="stylesheet" />
<script
src="jquery/select2-3.5.1/select2.js"></script>

<script type="text/javascript">
<!--

    /**
     * Define DocBlock
     */

//-->


    var mydata;
    var ruolo;
    var hasRole;
    var selectedUtente;
    var userName;
    /**
     * Cambia Ruolo Utente
     * 
     * In base alla richiesta di cambiamento di ruolo, verifica se l'utente è abilitato o no
     * in tal caso procede all'abilitazione o disabilitazione del ruolo, nel database
     * 
     * @param {string} ruolo Ruolo da abilitare o disabilitare
     * @param {boolean} hasRole Ruolo da abilitare o disabilitare
     * @param {bigint} selectedUtente Ruolo da abilitare o disabilitare
     * @param {text} userName Ruolo da abilitare o disabilitare
     * @param {object} mydata Ruolo da abilitare o disabilitare
     * @returns {null}
     */
    function cambiaRuolo(ruolo, hasRole, selectedUtente, userName, mydata) {
        if (hasRole)
            cambiare = "disabilitare";
        else
            cambiare = "abilitare";


        /**
         * Disabilita la cookye per impedire la ricomparsa dei popup relativi
         * al messaggio di benvenuto
         */
        //$.cookie('firstLogin', 'false');
        //$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
        $.prompt("<h3>Vuoi " + cambiare + " i permessi per il ruolo di </h3><h2>" +
                ruolo + "</h2><h3> all'utente </h3><h2>"
                + userName + "</h2> <h3>(" + selectedUtente + ") ? </h3>", {
                    title: "<h1>Ruoli Utente</h1>",
                    buttons: {"<h2>Si</h2>": true, "No": false},
                    submit: function (e, v, m, f) {
                        // use e.preventDefault() to prevent closing when needed or return false. 
                        //e.preventDefault(); 

                        //alert("Value clicked was: "+ v);
                        if (v) {
                            $.ajax({
                                type: "POST",
                                url: 'ajax.php',
                                data: mydata,
                                success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                    //alert(response);
                                    location.reload();
                                }
                            });
                        }

                    }
                });
    }


    $(document).ready(function () {
        // Stuff to do as soon as the DOM is ready;

        /**
         * Gestisce la capacità degli amministratori, soltanto, di reimpostare
         * la password di altri utenti su richiesta degli stessi, in caso di smarrimento
         * delle credenziali.
         */
        /**
         *	TODO changeOthersPassword
         */

        $("#gotochangeOthersPassword").button();
        $("#gotochangeOthersPassword").click(function () {
            //alert('gotochangeOthersPassword');
            $.ajax({
                type: "POST",
                url: 'ajax.php',
                data: {"action": "gotochangeOthersPassword",
                    "page": "userMenu.php"},
                success: function (response) {//response is value returned from php (for your example it's "bye bye"
                    //alert(response);
                    window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/changeOthersPassword.php";
                }
            });

        });
        $(function () {
            $("#changeOthersPassword").button();

            $("#changeOthersPassword").click(function () {
                mydata = $("form#userMenuForm").serialize();
                mydata = mydata + "&page=" + "userMenu.php" + "&action=" + "changeOthersPassword";
                alert(mydata);
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: mydata,
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        alert(response);
                        window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/changeOthersPassword.php";
                    }
                });

            });


        });
        /**
         * $("#selectedUtenteId").select2()
         * 
         * Seleziona gli utenti nella ruoliUtentiFrame.php
         * 
         * @returns {undefined}
         */
        $(function () {
            function format(state) {
                var originalOption = state.element;
                if (!state.id)
                    return state.text; // optgroup
                if ($(originalOption).data('isadmin') == 1)
                    return "<img class='flag' src='images/administrator.jpeg' width='16' height='16'/>" +
                            state.text;
                else
                    return "<img class='flag' src='images/ruolo_utente.png' width='16' height='16'/>" +
                            state.text;
            }
            function retrieveRuoliUtente(selectedUtente) {
                //alert(selectedUtente);
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {"page": "userMenu.php",
                        "action": "changeUser",
                        "selectedUtente": selectedUtente},
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        //alert(response);
                        
                        location.reload();
                    }
                });
            }
            function selectUtente(state) {
                var originalOption = state.element;
                if ($.cookie('selectedUtente') != $(originalOption).val()) {
                    $.cookie('selectedUtente', $(originalOption).val());
                    //$.cookie('firstLogin', false);
                    var response = retrieveRuoliUtente($(originalOption).val());
                }

                if (!state.id)
                    return state.text; // optgroup
                if ($(originalOption).data('isadmin') == 1)
                    return "<img class='flag' src='images/administrator.jpeg' width='16' height='16'/>" +
                            state.text;
                else
                    return "<img class='flag' src='images/ruolo_utente.png' width='16' height='16'/>" +
                            state.text;
            }
            $("#selectedUtenteId").select2({
                formatResult: format,
                formatSelection: selectUtente,
                escapeMarkup: function (m) {
                    return m;
                }
            })

        });
        /**
         * gestione ruolo con id=1 AMMINISTRATORE
         */
        $(function () {
            $("#ruoloId1").button();

            $("#ruoloImage1").click(function () {
                $("#ruoloId1").click();
            });


        });
        /**
         * gestione ruolo con id=2 INSEGNANTE
         */
        $(function () {
            $("#ruoloId2").button();
            $("#ruoloImage2").click(function () {
                $("#ruoloId2").click();
            });
        });

        /**
         * gestione ruolo con id=3 ATA
         */
        $(function () {
            $("#ruoloId3").button();
            $("#ruoloImage3").click(function () {
                $("#ruoloId3").click();
            });
        });

        /**
         * gestione ruolo con id=4 SEGRETERIA
         */
        $(function () {
            $("#ruoloId4").button();
            $("#ruoloImage4").click(function () {
                $("#ruoloId4").click();
            });
        });


        $("#ruoloId1").click(function ()
        {
            mydata = $("form#userMenuForm").serialize();
            mydata = mydata + "&id_ruolo=" + "1" + "&page=" + "userMenu.php";
            //alert(mydata);

            ruolo = $('input[name=role1]').val();
            hasRole = $('input[name=hasRole1]').val();
            selectedUtente = $('select[name=selectedUtente]').val();
            userName = $('input[name=userName]').val();

            cambiaRuolo(ruolo, hasRole, selectedUtente, userName, mydata);
        });



        $("#ruoloId2").click(function ()
        {
            mydata = $("form#userMenuForm").serialize();
            mydata = mydata + "&id_ruolo=" + "2" + "&page=" + "userMenu.php";
            //alert(mydata);
            ruolo = $('input[name=role2]').val();
            hasRole = $('input[name=hasRole2]').val();
            selectedUtente = $('select[name=selectedUtente]').val();
            userName = $('input[name=userName]').val();

            cambiaRuolo(ruolo, hasRole, selectedUtente, userName, mydata);
        });


        $("#ruoloId3").click(function ()
        {
            mydata = $("form#userMenuForm").serialize();
            mydata = mydata + "&id_ruolo=" + "3" + "&page=" + "userMenu.php";
            //alert(mydata);
            ruolo = $('input[name=role3]').val();
            hasRole = $('input[name=hasRole3]').val();
            selectedUtente = $('select[name=selectedUtente]').val();
            userName = $('input[name=userName]').val();

            cambiaRuolo(ruolo, hasRole, selectedUtente, userName, mydata);
        });

        $("#ruoloId4").click(function ()
        {
            mydata = $("form#userMenuForm").serialize();
            mydata = mydata + "&id_ruolo=" + "4" + "&page=" + "userMenu.php";
            //alert(mydata);
            ruolo = $('input[name=role4]').val();
            hasRole = $('input[name=hasRole4]').val();
            selectedUtente = $('select[name=selectedUtente]').val();
            userName = $('input[name=userName]').val();

            cambiaRuolo(ruolo, hasRole, selectedUtente, userName, mydata);
        });
    });


</script>
