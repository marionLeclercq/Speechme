$(document).ready(function(){
    
    $('#header_icone').click(function(e){
        e.preventDefault();
        $('body').toggleClass('with_sidebar');
       })
});

