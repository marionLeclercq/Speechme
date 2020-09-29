$(document).ready(function () {
    $("#depart").change(function () {
        
        $.get("_selectPhotosDep.php",  
                {dep: $(this).val()}, 
                    function (data, status) {
                        var l = $.parseJSON(data);
                        var cl = $("#img_events");
                        cl.empty();
                        if(l.length>0){
                            $(l).each(function(){                   
                                cl.append("<form action='descriptif_pop.php' method='post'><div><input type='image' name='voir' src='"+ this.photo1 +"'alt='Event_photo'/></div><input type='hidden' name ='id_event' value='"+ this.id +"'></form>");
                            });
                        }
                        else{
                           
                            cl.append("<h4>Il n'y a pas encore d'évènements ici...</h4>"); 
                       
                        }  
                }
        );
    });
}); 
