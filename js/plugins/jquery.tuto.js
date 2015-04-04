// Javascript pour les templates de page de tutoriel

// ensemble des scripts
imready = function() {
	cover();
	initSnippet();
	smoothScroll();
	openRwdMenu();
}

// couverture adaptable
cover = function() {

	var innerHeight = (window.innerHeight);
	$('.adaptableCover').css('height', +innerHeight+"px");
	$(window).on('resize', function() {
		$('.adaptableCover').css('height', +innerHeight+"px");
	})

}

// initialisation du style de snippets
initSnippet = function() {

	hljs.initHighlightingOnLoad();
	$('pre.snippet code').each(function(i, block) {
		hljs.highlightBlock(block);
	});

	hljs.configure({
		tabReplace: '    ',
		classPrefix: 'hljs',
		languages: 'html, css'
	})

}

smoothScroll = function() {

	$('ol.contents a, .ttBottom a, nav a.snLink').click(function() {
		var page = $(this).attr('href');
		var speed = 300;
		var scroll = ($(page).offset().top)-136;

		$('html, body').animate({scrollTop: scroll}, speed);
		return false;
	});

	$('.ttTop').click(function() {
		$('html, body').animate({scrollTop: 0}, 300);
		return false;
	})

}

openRwdMenu = function() {

	$('#toggleMenu').click( function() {
		$('body, header').toggleClass('pushBody', 150, "linear");
		$('#rwdNav').toggleClass('pushMenu', 150, "linear");
		$('#toggleMenu i.burgerIcn').toggleClass('closeIcn');
	})

}

$(document).foundation().ready(imready);