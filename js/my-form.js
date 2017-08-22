$(document).ready(function() {

  $("#contact_form").submit(function() {
    var $this = $(this);

    $.ajax({
      type: "POST",
      url: "mail.php",
      data: $this.serialize(),
      beforeSend: function() {
        $this.find('button[type="submit"]').prop("disabled");
      }
    }).done(function( data ) {
      $this.find('input[type="submit"]').prop("disabled", false);
      var jsondata = JSON.parse(data);

      if ( jsondata.status == "spam" ) {
        $this.reset();
      }
      else if ( jsondata.status == "ok" ) {   
        $this[0].reset();
      }
    }).fail(function() {  
      $this.find('input[type="submit"]').prop("disabled", false);    
    });
    return false;
  });
});

