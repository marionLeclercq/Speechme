$(document).ready(function () {
    $("#supprimer").click(function () {
        var button = $(this);
            if ( confirm( "Voulez-vous vraiment supprimer cet événement ?")){
                $.post("_actionsEvents.php",
                    { message: $("#alert_sup").val(), id_user1: $("#organisateur").data('id'), prenom_user1: $('#organisateur').text(), id_user2: $("#organisateur").data('id'), nom_event: $("#descriptif_BO h1").text() },
                        function(data,status){
                    });
                $.post("_actionsEvents.php",
                    { id: $(this).attr('data-id') },
                        function(data,status){
                            window.location.replace("events_BO.php");
                });
            }
    });
    $("#valider").click(function () {
        var button = $(this);
            if ( confirm( "Voulez-vous valider cet événement ?")){
                $.post("_actionsEvents.php",
                    { message: $("#alert_valid").val(), id_user1: $("#organisateur").data('id'), prenom_user1: $('#organisateur').text(), id_user2:  $("#organisateur").data('id'), nom_event: $("#descriptif_BO h1").text() },
                        function(data,status){
                    });
                $.post("_actionsEvents.php",
                    { id1: $(this).attr('data-id') },
                        function(data,status){
                            button.replaceWith("<p style='color:red; font-weight:bold'>Evénement validé!</p>");
                });
            }
    });

});