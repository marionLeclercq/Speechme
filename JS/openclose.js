function openclose(elem,img) {
  let etat=document.getElementById(elem).style.display;
  let src=document.getElementById(img).src;
  if(etat=="none"){
      document.getElementById(elem).style.display="block";
      document.getElementById(img).src= "./images/moins.svg";
      
  } else {
      document.getElementById(elem).style.display="none";
      document.getElementById(img).src= "./images/plus.svg";
  }
}