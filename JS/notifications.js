
function getRow(){
    $.get("_notifications.php",
    {  },
        function(data,status){
              
            if(data>0)
            document.getElementById("image_alarme").src= "./images/notification.svg";
        });   
}

setInterval(getRow, 5000);

function no_notif(){
    document.getElementById("image_alarme").src= "./images/alarme.svg";
}



