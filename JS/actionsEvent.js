$(document).ready(function () {
    $("#participer").click(function () {
            $.post("_actionsEvent.php",
            { idEvent: $("#id_event").val(), idUser: $("#id_user_session").val() },
                function(data,status){
                    $("#participer").css("display", "none");
                    $("#annuler_part").css("display", "block");
                });   
    });
    $("#annuler_part").click(function () {
            $.post("_actionsEvent.php",
            { idEvent2: $("#id_event").val(), idUser2: $("#id_user_session").val() },
                function(data,status){
                    $("#participer").css("display", "block");
                    $("#annuler_part").css("display", "none");
                });   
    });
    $("#annuler_event").click(function () {
        if ( confirm( "Voulez-vous supprimer DEFINITIVEMENT cet événement ? Do you DEFINITELY want to delete this event?")){

            $.post("_stockage.php",
                    { message: $("#alert").val(), id_user1: $("#id_organisateur").val(), prenom_user1: $('#prenom_orga').text(), id_user2: $("#json_id_participants").val() , nom_event: $("#nom_event").text() },
                        function(data,status){
                            window.location.replace("user.php");
                    });
            
            $.post("_actionsEvent.php",
            { idEvent3: $("#id_event").val() },
                function(data,status){
                    window.location.replace("user.php");
                    });      
          
        }   
    });
    $(".suppr_notif").click(function () {
        var button = $(this);
        if ( confirm( "Voulez-vous supprimer ce message ? Do you  want to delete this message?")){
            $.post("_actionsEvent.php",
            { idMsg: $(this).data('id') },
                function(data,status){
                    button.parents("tr").remove();   
                    });      
        }   
    });

});