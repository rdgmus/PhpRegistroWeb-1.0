
<script type="text/javascript">
<!--
/**
 * GESTIONE RUOLI UTENTI
 * PAG. userMenu.php
 * @author Roberto Della Grotta
 * @version $Id$
 * @copyright , 15 October, 2014
 * @package default
 */

/**
 * Define DocBlock
 */

//-->

$(document).ready(function() {
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
	  $("#gotochangeOthersPassword").click(function(){
		//alert('gotochangeOthersPassword');
 		$.ajax({
      		type: "POST",
       	   url: 'ajax.php',
       	 	data: {"action":"gotochangeOthersPassword",
           	 	"page":"userMenu.php"},
      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
      	     //alert(response);
      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/changeOthersPassword.php";
      	   }
      	});

	  });
	$(function() {
		  $("#changeOthersPassword").button();
		 
		  $("#changeOthersPassword").click(function(){
		       	 var mydata = $("form#userMenuForm").serialize();
		       	 mydata = mydata+"&page="+"userMenu.php"+"&action="+"changeOthersPassword";
		 			alert(mydata);
		 		$.ajax({
		      		type: "POST",
		       	   url: 'ajax.php',
		       	 	data: mydata,
		      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
		      	     alert(response);
		      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/changeOthersPassword.php";
		      	   }
		      	});
			  
		  });
		
		  
	  });
/**
 * richiamata quando si seleziona un utente del quale si vogliono
 * gestire i permessi.
 */
		  $(function() {
		  $("#selectedUtenteId").click( function()
		    {
	        	
	       	 var mydata = $("form#userMenuForm").serialize();
	          	mydata = mydata+"&page="+"userMenu.php";
	 		//alert(mydata);
	 		$.ajax({
	      		type: "POST",
	       	   url: 'ajax.php',
	       	 	data: mydata,
	      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
	      	     //alert(response);
	      	   window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/userMenu.php";	      	   }
	      	});
	        	
	        }
	     );
	  });
	  
	  /**
	   * gestione ruolo con id=1 AMMINISTRATORE
	   */
	  $(function() {
		  $("#ruoloId1").button();
		 
		  $("#ruoloImage1").click(function(){
			  $("#ruoloId1").click();
		  });
		
			  
	  });
	  /**
	   * gestione ruolo con id=2 INSEGNANTE
	   */
	  $(function() {
		  $("#ruoloId2").button();
		  $("#ruoloImage2").click(function(){
			  $("#ruoloId2").click();
		  });
	  });
	  
	  /**
	   * gestione ruolo con id=3 ATA
	   */
	  $(function() {
		  $("#ruoloId3").button();
		  $("#ruoloImage3").click(function(){
			  $("#ruoloId3").click();
		  });
	  });
	  
	  /**
	   * gestione ruolo con id=4 SEGRETERIA
	   */	  
	  $(function() {
		  $("#ruoloId4").button();
		  $("#ruoloImage4").click(function(){
			  $("#ruoloId4").click();
		  });
	  });
	  
	  
	  $("#ruoloId1").click( function()
				{
					  var mydata = $("form#userMenuForm").serialize();
			       	 mydata = mydata+"&id_ruolo="+"1"+"&page="+"userMenu.php";
			 			//alert(mydata);

			 			var ruolo = $('input[name=role1]').val();
			 			var hasRole = $('input[name=hasRole1]').val();
			 			var selectedUtente = $('select[name=selectedUtente]').val();
			 			var userName = $('input[name=userName]').val();
			 			if(hasRole)
			 	 			cambiare = "disabilitare";
			 			else
			 	 			cambiare = "abilitare";
			 			//$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
				       	$.prompt("Vuoi "+cambiare+" i permessi per il ruolo = "+ruolo+", all'utente "+userName+"("+selectedUtente+") ?" , {
						title: "<h2>Ruoli Utente</h2>",
						buttons: { "<h2>Si</h2>": true, "No": false },
						submit: function(e,v,m,f){
							// use e.preventDefault() to prevent closing when needed or return false. 
							//e.preventDefault(); 
							
							//alert("Value clicked was: "+ v);
							if(v){
								$.ajax({
						      		type: "POST",
						       	   url: 'ajax.php',
						       	 	data: mydata,
						      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
						      	    //alert(response);
						      	    
						      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/userMenu.php";
						      	   }
						      	});
							}
							   	
						}
					});	
				});


		
	  $("#ruoloId2").click( function()
				{
					  var mydata = $("form#userMenuForm").serialize();
			       	 mydata = mydata+"&id_ruolo="+"2"+"&page="+"userMenu.php";
			 			//alert(mydata);
			       	var ruolo = $('input[name=role2]').val();
		 			var hasRole = $('input[name=hasRole2]').val();
		 			var selectedUtente = $('select[name=selectedUtente]').val();
		 			var userName = $('input[name=userName]').val();
		 			if(hasRole)
		 	 			cambiare = "disabilitare";
		 			else
		 	 			cambiare = "abilitare";
		 			//$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
		       	$.prompt("Vuoi "+cambiare+" i permessi per il ruolo = "+ruolo+", all'utente "+userName+"("+selectedUtente+") ?" , {
					title: "<h2>Ruoli Utente</h2>",
					buttons: { "Si": true, "No": false },
					submit: function(e,v,m,f){
						// use e.preventDefault() to prevent closing when needed or return false. 
						//e.preventDefault(); 
						
						//alert("Value clicked was: "+ v);
						if(v){
							$.ajax({
					      		type: "POST",
					       	   url: 'ajax.php',
					       	 	data: mydata,
					      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
					      	    //alert(response);
					      	    
					      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/userMenu.php";
					      	   }
					      	});
						}
						   	
					}
				});
				});
	  $("#ruoloId3").click( function()
				{
					  var mydata = $("form#userMenuForm").serialize();
			       	 mydata = mydata+"&id_ruolo="+"3"+"&page="+"userMenu.php";
			 			//alert(mydata);
			       	var ruolo = $('input[name=role3]').val();
		 			var hasRole = $('input[name=hasRole3]').val();
		 			var selectedUtente = $('select[name=selectedUtente]').val();
		 			var userName = $('input[name=userName]').val();
		 			if(hasRole)
		 	 			cambiare = "disabilitare";
		 			else
		 	 			cambiare = "abilitare";
		 			//$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
		       	$.prompt("Vuoi "+cambiare+" i permessi per il ruolo = "+ruolo+", all'utente "+userName+"("+selectedUtente+") ?" , {
					title: "<h2>Ruoli Utente</h2>",
					buttons: { "Si": true, "No": false },
					submit: function(e,v,m,f){
						// use e.preventDefault() to prevent closing when needed or return false. 
						//e.preventDefault(); 
						
						//alert("Value clicked was: "+ v);
						if(v){
							$.ajax({
					      		type: "POST",
					       	   url: 'ajax.php',
					       	 	data: mydata,
					      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
					      	    //alert(response);
					      	    
					      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/userMenu.php";
					      	   }
					      	});
						}
						   	
					}
				});
				});
	  $("#ruoloId4").click( function()
				{
					  var mydata = $("form#userMenuForm").serialize();
			       	 mydata = mydata+"&id_ruolo="+"4"+"&page="+"userMenu.php";
			 			//alert(mydata);
			       	var ruolo = $('input[name=role4]').val();
		 			var hasRole = $('input[name=hasRole4]').val();
		 			var selectedUtente = $('select[name=selectedUtente]').val();
		 			var userName = $('input[name=userName]').val();
		 			if(hasRole)
		 	 			cambiare = "disabilitare";
		 			else
		 	 			cambiare = "abilitare";
		 			//$.cookye('hasRoleSelectedUtente'), $.coockye('selectedUtente'));
		       	$.prompt("Vuoi "+cambiare+" i permessi per il ruolo = "+ruolo+", all'utente "+userName+"("+selectedUtente+") ?" , {
					title: "<h2>Ruoli Utente</h2>",
					buttons: { "Si": true, "No": false },
					submit: function(e,v,m,f){
						// use e.preventDefault() to prevent closing when needed or return false. 
						//e.preventDefault(); 
						
						//alert("Value clicked was: "+ v);
						if(v){
							$.ajax({
					      		type: "POST",
					       	   url: 'ajax.php',
					       	 	data: mydata,
					      	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
					      	    //alert(response);
					      	    
					      	   	window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/userMenu.php";
					      	   }
					      	});
						}
						   	
					}
				});
				});
		  });
		
		  
		  </script>
