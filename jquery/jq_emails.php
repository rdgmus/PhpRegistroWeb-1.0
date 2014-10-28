
<html>

<script type="text/javascript">

/**
 * PHPMAILER GESTIONE DELLE EMAIL
 *
 * @author Roberto Della Grotta
 * @version $Id$
 * @copyright , 15 October, 2014
 * @package default
 */

/**
 * Define DocBlock
 */

$(document).ready(function() {
	// Stuff to do as soon as the DOM is ready;
	
/**
 * TINYMCE #textareaTo
 */
	$(function() {
		tinymce.init({
		    selector: "#textareaTo",
		    toolbar:  "Undo Clear",
		    menubar:false,
		    statusbar:false,
		    setup: function(editor) {
		        editor.addButton('Undo', {
			           title : 'Cancella ultimo destinatario',
			           image : 'images/undo.png',
			           onclick : function() {
			              //editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
					    	$.ajax({
							    url: 'ajax.php',
							    type: 'post',
							    data: { "callUndoToLastRecipient": "1" },
							    success: function(response) { 
								    //alert(response);
					           	   	tinymce.get('textareaTo').setContent(response);
								}
							});				              
			           }
			        });
		        editor.addButton('Clear', {
			           title : 'Cancella tutti i destinatari',
			           image : 'images/Clear-64.png',
			           onclick : function() {
			              editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
			           }
			        });
		        editor.on('undo', function(e) {
		            //alert('undo event', e);
		        });
		        editor.on('change', function(e) {
		            //alert('change event', e);
		        });
		        editor.on('SaveContent', function(e) {
		            alert('SaveContent event', e);
		        });
		        editor.on('AddUndo', function(e) {
		            //alert('AddUndo event', e);
		        });
		    }
		 });
		
	});
	
	$(function() {
		tinymce.init({
		    selector: "#textareaCc",
		    toolbar:  "Undo Clear",
		    menubar:false,
		    statusbar:false,
		    setup: function(editor) {
		        editor.addButton('Undo', {
			           title : 'Cancella ultimo destinatario',
			           image : 'images/undo.png',
			           onclick : function() {
			              //editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
					    	$.ajax({
							    url: 'ajax.php',
							    type: 'post',
							    data: { "callUndoCcLastRecipient": "1" },
							    success: function(response) { 
								    //alert(response);
					           	   	tinymce.get('textareaCc').setContent(response);
								}
							});				              
			           }
			        });
		        editor.addButton('Clear', {
			           title : 'Cancella tutti i destinatari',
			           image : 'images/Clear-64.png',
			           onclick : function() {
			              editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
			           }
			        });
		        editor.on('undo', function(e) {
		            //alert('undo event', e);
		        });
		        editor.on('change', function(e) {
		            //alert('change event', e);
		        });
		        editor.on('SaveContent', function(e) {
		            alert('SaveContent event', e);
		        });
		        editor.on('AddUndo', function(e) {
		            //alert('AddUndo event', e);
		        });
		    }
	    		 });
	});
	
	$(function() {
		tinymce.init({
		    selector: "#textareaBcc",
		    toolbar:  "Undo Clear",
		    menubar:false,
		    statusbar:false,
		    setup: function(editor) {
		        editor.addButton('Undo', {
			           title : 'Cancella ultimo destinatario',
			           image : 'images/undo.png',
			           onclick : function() {
			              //editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
					    	$.ajax({
							    url: 'ajax.php',
							    type: 'post',
							    data: { "callUndoBccLastRecipient": "1" },
							    success: function(response) { 
								    //alert(response);
					           	   	tinymce.get('textareaBcc').setContent(response);
								}
							});				              
			           }
			        });
		        editor.addButton('Clear', {
			           title : 'Cancella tutti i destinatari',
			           image : 'images/Clear-64.png',
			           onclick : function() {
			              editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
			           }
			        });
	 	        editor.on('undo', function(e) {
		            //alert('undo event', e);
		        });
		        editor.on('change', function(e) {
		            //alert('change event', e);
		        });
		        editor.on('SaveContent', function(e) {
		            alert('SaveContent event', e);
		        });
		        editor.on('AddUndo', function(e) {
		            //alert('AddUndo event', e);
		        });
		    }
	    		 });
	});

	
	
	
$(function() {
	  $("#sendPHPMailerEmail").button(); 	
});
$(function() {
$("#sendPHPMailerEmail").click( function()
  {
 	 var mydata = $("form#mailUserForm").serialize();
    	mydata = mydata+"&page="+"emailToUser.php"+"&actionEmail="+"Send Email";
		//alert(mydata);
		$("#sendPHPMailerEmail").button('disable');
	$.ajax({
		type: "POST",
 	   url: 'PHPMailer.php',
 	 	data: mydata,
	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
	     //alert(response);
			$("#sendPHPMailerEmail").button('enable');
			
	   		window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/emailToUser.php";	      	   
  	   }
	});
	
  }
);
});

$(function() {
$("#createPdf").button();
	
});
$(function() {
$("#createPdf").click( function()
  {
 	 var mydata = $("form#mailUserForm").serialize();
    	mydata = mydata+"&page="+"emailToUser.php"+"&actionEmail="+"Send Email";
	//alert(mydata);
	$.ajax({
		type: "POST",
 	   url: 'createPdf.php',
 	 	data: mydata,
	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
	     //alert(response);
	   window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/tcpdf/examples/pdf_functions.php";	      	   
  	   }
	});
	
  }
);
});

$(function() {
	$("#subjectArea").jqte(
			{				
				focus: function(){ //alert("The editor is focused");
				    	var subject = $("#subjectArea").val();
				    	if(subject == "<NO SUBJECT>"){
							$(this).html("");
				    	}
				 },
				blur: function(){ //alert("The editor is blured"); 
				    	var subject = $("#subjectArea").val();
				    	//alert(subject);
				    	$.ajax({
						    url: 'ajax.php',
						    type: 'post',
						    data: { "callGetEmailSubject": "1",
							    "emailSubject": subject},
						    success: function(response) { 
							    //alert(response);
						    	$("#subjectArea").html(response); 
							}
						});
				},
				change: function(){ 
					//alert("The editor is changed"); 
				}
					
			}
			);
	$("#bodyArea").jqte(

			{
				focus: function(){ //alert("The editor is focused");
			    	var body = $("#bodyArea").val();
			    	if(body == "<NO BODY>"){
						$(this).html("");
			    	}
				 },
				blur: function(){ //alert("The editor is blured"); 
			    	var body = $("#bodyArea").val();
			    	//alert(body);
			    	$.ajax({
					    url: 'ajax.php',
					    type: 'post',
					    data: { "callGetEmailBody": "1",
						    "emailBody": body},
					    success: function(response) { 
						    //alert(response);
					    	$("#bodyArea").html(response); 
						}
					});
				},
				change: function(){ 
					//alert("The editor is changed"); 


				}
					
			}
			);
});


/**
*	BOTTONE SCRIVI EMAIL IN TEXTAREA TO
*/
$(function() {
	  $(function() {
		  $("#textareaTo").resizable({ animate: true,autoHide: true });
	  });
	  $("#emailTo").click( function()
	    {
        	
        	 var mydata = $("form#mailUserForm").serialize();
        	 mydata = mydata+"&emailButton="+"To"
        	 +"&page="+"emailToUser.php";
  			//alert(mydata);
        	$.ajax({
        		type: "POST",
         	   url: 'ajax.php',
         	 	data: mydata,
        	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
        	     //alert(response);
           	   	tinymce.get('textareaTo').setContent(response);
        	   }
        	});
        	//window.location = "http://localhost/PhpRegistroScuolaNetBeans/emailToUser.php";
      	
      }
   );
});

/**
 *	BOTTONE SCRIVI EMAIL IN TEXTAREA CC
 */
$(function() {
	  $(function() {
		  $("#textareaCc").resizable({ animate: true,autoHide: true });
	  });
	  
	  $("#emailCc").click( function()
	    {
        	
        	 var mydata = $("form#mailUserForm").serialize();
        	mydata = mydata+"&emailButton="+"Cc"+"&page="+"emailToUser.php";
  			//alert(mydata);
        	
        	$.ajax({
        		type: "POST",
         	   url: 'ajax.php',
         	 	data: mydata,
        	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
        	     //alert(response);
        		   tinymce.get('textareaCc').setContent(response);	
        	   }
        	});
        	//window.location = "http://localhost/PhpRegistroScuolaNetBeans/emailToUser.php";
      	
      }
   );
});

/**
 *	BOTTONE SCRIVI EMAIL IN TEXTAREA BCC
 */
$(function() {
	  $(function() {
		  $("#textareaBcc").resizable({ animate: true,autoHide: true });
	  });

		  $("#emailBcc").click( function()
	    {
        	
        	 var mydata = $("form#mailUserForm").serialize();
        	mydata = mydata+"&emailButton="+"Bcc"+"&page="+"emailToUser.php";
  			//alert(mydata);
        	
        	$.ajax({
        		type: "POST",
         	   url: 'ajax.php',
         	 	data: mydata,
        	   success: function (response) {//response is value returned from php (for your example it's "bye bye"
        	     //alert(response);
        		   tinymce.get('textareaBcc').setContent(response);	
        	   }
        	});
        	//window.location = "http://localhost/PhpRegistroScuolaNetBeans/emailToUser.php";
      	
      }
   );
});


});

</script>


</html>
