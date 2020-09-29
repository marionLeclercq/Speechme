$(document).ready(function () {
    $(".sup_membre").click(function () {
        var button = $(this);
            if ( confirm( "Voulez-vous vraiment supprimer ce membre ?")){
                $.post("_suppression.php",
            { id: $(this).attr('data-id') },
                function(data,status){
                    console.log(data);
                    button.parents("tr").remove();   
                });
            }
    });

    $(".sup_photo").click(function () {
        var button = $(this);
            if ( confirm( "Voulez-vous vraiment supprimer cette photo ?")){
                $.post("_suppression.php",
            { id1: $(this).attr('data-id') },
                function(data,status){
                    button.parent("td").prev().children().remove();   
                });
            }
    });

    $(".sup_descr").click(function () {
        var button = $(this);
            if ( confirm( "Voulez-vous vraiment supprimer la description ?")){
                $.post("_suppression.php",
            { id2: $(this).attr('data-id') },
                function(data,status){
                    button.parent("td").prev().prev().children().remove();   
                });
            }
    });

});