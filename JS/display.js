function display(elem){
    let etat=document.getElementById(elem).style.display;
    document.getElementById(elem).style.display= "block";   
}

function display_input(elem1, elem2, elem3){
    let el1= document.getElementById(elem1);
    let el2= document.getElementById(elem2);
    let el3= document.getElementById(elem3);
    el1.addEventListener("change", function(){
        el2.style.display= "block";
    })
    el2.addEventListener("change", function(){
        el3.style.display= "block";
    })
}
