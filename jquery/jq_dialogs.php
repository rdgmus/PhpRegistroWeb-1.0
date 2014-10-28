<html>
<script type="text/javascript">

/**
 * DIALOGS JQUERY
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

$(function() {
    $( "#dialogEmail" ).dialog({
    	modal: true,
    	  dialogClass: "no-close",
    	  buttons: [
    	    {
    	      text: "OK",
  	    	    icons: { primary: " ui-icon-person", secondary: "ui-icon-mail-closed" },		    	      
    	      click: function() {
    	        $( this ).dialog( "close" );
    	        callBackDialogEmail(true);
    	        
    	      }
    	    }
    	  ]
    	});
  });

function callBackDialogEmail(value){
	// Deleting the message cookie:
	   $.removeCookie("message");
	   $.removeCookie("status");
 }
  
  
$(function() {
  $('#dialogSuccess').dialog({
	    modal: true,
	    resizable: true,
	    dialogClass: 'no-close',
    	buttons: [
  	    	    {
  	    	      text: "OK",
  	    	    icons: { primary: " ui-icon-person", secondary: "ui-icon-info" },
  	    	      click: function() {
  	    	        $( this ).dialog( "close" );
  	    	        callBackDialogSuccess(true);
  	    	      }
  	    	    }
  	    	  ]
	});
  });

function callBackDialogSuccess(value){
// Deleting the message cookie:
	   $.removeCookie("message");
	   $.removeCookie("status");
}

$(function() {
$("#modal").dialog({
  buttons: {
      Yes: {
          text: 'Yeeees!',
          click: function() {
              alert('I clicked yes!');
          }
      },
      No: {
          text: 'Hell no!',
          click: function() {
              alert('I clicked no!');
          }
      }
  }
});
});

});

</script>

</html>