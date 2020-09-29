$(document).ready(function () {
  var para = $(".langues");

  // Pour page `création` et `profil`
  
  para.click(function() {
    if ( confirm( "Supprimer la langue suivante / Delete this language: ? " + $(this).text() ) ){
      $.post("_getLangues.php",  
      {idUser: $(".id_user").val(), idSpeak: $(this).find('input').val(), idLearn: $(this).find('input').val()}, 
      function (data, status) {});
      $(this).remove();
    } 
  });

  // Pour page `profil`

  $("#ajout_speak").click(function () {
    var l = $("#speakLang").val();
    var i = $("#id_speakLang").val();
    var p = $(`<p class = "langues">${l} <img src='./images/moins.svg' alt='icone_suppression' width='15'><input type='hidden' name = 'id_speakLang[]' value ='${i}'></p>`);
    $("#speak").append(p);
    if($(".langues").click(function() {
      confirm( "Supprimer la langue suivante / Delete this language: ? " + $(this).text() + "?" ) 
        $(this).remove();
    })); 
  });
  $("#ajout_learn").click(function () {
    var l = $("#learnLang").val();
    var i = $("#id_learnLang").val();
    var p = $(`<p class = "langues">${l} <img src='./images/moins.svg' alt='icone_suppression' width='15'><input type='hidden' name = 'id_learnLang[]' value ='${i}'></p>`);
    $("#learn").append(p);
    if($(".langues").click(function() {
      confirm( "Supprimer la langue suivante / Delete this language: ? " + $(this).text() + "?" ) 
        $(this).remove();
    })); 
  });

      // Pour page `création`

	$("#add_speak").click(function () {
      $("#speakLang").focus(); 
      var l = $("#speakLang").val();
      if($('html').is(':lang(fr)')){
        var i = $("#id_speakLang").val();
        var p = $(`<p class = "langues">${l} <img src='./images/moins.svg' alt='icone_suppression' width='15'><input type='hidden' name = 'id_speakLang[]' value ='${i}'><input type='hidden' name = 'id_speakLang[]' value ='${++i}'></p>`);
      }
      if($('html').is(':lang(en)')) {
        var i = $("#id_speakLang").val();
        var p = $(`<p class = "langues">${l} <img src='./images/moins.svg' alt='icone_suppression' width='15'><input type='hidden' name = 'id_speakLang[]' value ='${i}'><input type='hidden' name = 'id_speakLang[]' value ='${--i}'></p>`);
      }
      $("#speak").append(p);
      if($(".langues").click(function() {
        confirm( "Supprimer la langue suivante / Delete this language: ? " + $(this).text() + "?" ) 
          $(this).remove();
      }));   
    });

});