$(document).ready(function () {
    
    // Affiche l'image suivante en fondu-enchaîné
	function suivante() {
		// l'image au sommet de la pile, c'est
		// à dire l'image actuellement visible
		var active = $('#slideshow .slideshowactive');
		
		// la prochaine image dans la liste ou bien la première
		// si l'image active était la dernière de la liste
		var next;
		if (active.next().length > 0)
			next = active.next();
		else
			next = $('#slideshow img:first');
		
		// next devient la seconde image dans la pile
		next.css('z-index', 2);
		
		// fait un fade-out sur l'image actuellement visible
		// et next devient l'image au sommet de la pile
		active.fadeOut(1500, function() {
			// l'image active redevient "visible" et n'est plus l'image active
			active.css('z-index', 1).show().removeClass('slideshowactive');
			
			// next devient l'image active
			next.css('z-index', 3).addClass('slideshowactive');
		});
	}

	// on change d'image toutes les 6 secondes
	setInterval(suivante, 6000);

});