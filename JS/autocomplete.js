
$(document).ready(function () {

	// on cherche des villes dès que l'utilisateur tape dans l'input d'id ville
	$("#ville").keyup(function () {
		if ($(this).val().trim().length == 0) { 
			$("#liste_ville").hide();           
		}                                       
		else {                                  
			$.get("_lireVille.php",  
				{prefix: $(this).val()}, 
				function (data, status) {  
					var cl = $("#liste_ville");
					var i =  $("#id_ville");
					cl.empty();                 
					var l = $.parseJSON(data);
  
                    $(l).each(function(){                   
						cl.append("<li data-id = '"+ this.id + "'>" + this.nom_ville + "</li>");
					});
					
					cl.children().click(function () {  
						$("#ville").val($(this).text());
						i.attr("value", $(this).data('id'));
						cl.hide();           
					});
					$("#liste_ville").show();
				}
			);
		}
	});
	// on cherche la langue dès que l'utilisateur tape des caractères dans l'input d'id speackLang
	$("#speakLang").keyup(function () {
		if ($(this).val().trim().length == 0) { 
			$("#liste_langues").hide();   
		}                                
		else {                                  
			$.get("_lireLangues.php",  
				{ prefix: $(this).val()}, 
				function (data, status) {  
					var cl = $("#liste_langues");
					var i =  $("#id_speakLang");
					cl.empty();                
					var l = $.parseJSON(data);
					
                    $(l).each(function(){                   
						cl.append("<li data-id = '"+ this.id + "'>" + this.nom_langue + "</li>");
					});
					
					cl.children().click(function () {  
						$("#speakLang").val($(this).text());
						i.attr("value", $(this).data('id'));
						cl.hide();         
					});

					$("#liste_langues").show();
				}
			);
		}
	});
	// on cherche la langue dès que l'utilisateur tape des caractères dans l'input d'id learnLang
	$("#learnLang").keyup(function () {
		if ($(this).val().trim().length == 0) { 
			$("#liste2_langues").hide();           
		}                                       
		else {                                  
			$.get("_lireLangues.php",  
				{ prefix: $(this).val()}, 
				function (data, status) {  
					var cl = $("#liste2_langues");
					var i =  $("#id_learnLang");
					cl.empty();                
					var l = $.parseJSON(data);
					
                    $(l).each(function(){                   
						cl.append("<li data-id = '"+ this.id + "'>" + this.nom_langue + "</li>");
					});
					
					cl.children().click(function () {  
						$("#learnLang").val($(this).text());
						i.attr("value", $(this).data('id'));
						cl.hide();           
					});
					$("#liste2_langues").show();
				}
			);
		}
	});
	//  on cherche le thème dès que l'utilisateur tape des caractères dans l'input d'id themes
	$("#themes").keyup(function () {
		if ($(this).val().trim().length == 0) { 
			$("#liste_themes").hide();           
		}                                       
		else {                                  
			$.get("_lireTheme.php",  
				{ prefix: $(this).val()}, 
				function (data, status) {  
					var lt = $("#liste_themes");
					var t1 =  $("#id_theme");
					var t2 =  $("#id_theme_2");
					lt.empty();                
					var l = $.parseJSON(data);
					
                    $(l).each(function(){                   
						lt.append("<li data-id = '"+ this.id + "'>" + this.theme + "</li>");
					});
					
					lt.children().click(function () {  
						$("#themes").val($(this).text());
						t1.attr("value", $(this).data('id'));
						if($('html').is(':lang(fr)')){
							t2.attr("value", ($(this).data('id'))+1);
						}
						if($('html').is(':lang(en)')) {
							t2.attr("value", ($(this).data('id'))-1);
						}
						lt.hide();           
					});
					$("#liste_themes").show();
				}
			);
		}
	});

});
