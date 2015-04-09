/*
Javascript pour les templates de page de tutoriel

Directeur de la publication: Ian Smallwood

Contributeurs: Alexis Doyen, Elodie Dassance, Dan Gu, Aurélien Grimaud,
Justine Pinaud, Anne Astima, Yann Beduchaud,
Yingyin Zhang, Jiazhi Gao, Thibaud Sabathier

Librairies: JQuery, JQuery UI, Highlight.js

Développement front-end: Aurélien Grimaud
*/

// ensemble des scripts
imready = function() {
	cover();
	itemsRatio();
	centerTitle();
	smoothScroll();
	openRwdMenu();
	initSnippet();
}

// couverture adaptable
cover = function() {

	var innerHeight = (window.innerHeight);
	$('.adaptableCover').css('height', +innerHeight+"px");
	$(window).on('resize', function() {
		$('.adaptableCover').css('height', +innerHeight+"px");
	})

}

// avoir un carré peu importe la taille
itemsRatio = function() {
	var widthRef = $(".topicsWrapper li .urDesign").width();

	$('.flexMosaic li .urDesign').css('height', widthRef +'px');

	$(window).on('resize', function() {
		var widthRef = $(".flexMosaic li .urDesign").width();
		$('.flexMosaic li .urDesign').css('height', widthRef +'px');
	})
}

// centrer le titre
centerTitle = function() {
	var heightRef = ($(".flexMosaic li .urDesign").height())/4;

	$('.topicsWrapper li span h2').css({
									'transform': 'translateY('+heightRef +'px)',
									'-webkit-transform': 'translateY('+heightRef +'px)',
									'-moz-transform': 'translateY('+heightRef +'px)'
								});

	$('.topicsWrapper li span').on({
		mouseenter: function(event){
			var parent = $(event.target).parent();
			var title = parent.find("h2");
			title.css({
						'transform': 'translateY(0)',
						'-webkit-transform': 'translateY(0)',
						'-moz-transform': 'translateY(0)',
						'color': '#fff'
					})
		},
		mouseleave: function(event){
			var parent = $(event.target).parent();
			var title = parent.find("h2");
			title.css({
						'transform': 'translateY('+heightRef +'px)',
						'-webkit-transform': 'translateY('+heightRef +'px)',
						'-moz-transform': 'translateY('+heightRef +'px)',
						'color': '#5A9596'
					})
		}
	});
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

// défilement fluide
smoothScroll = function() {

	$('ol.contents a, .ttBottom a, nav a.snLink, #mainNav a').click(function() {
		var page = $(this).attr('href');
		var speed = 300;
		var headerHeight = $('header').height();
		var scroll = ($(page).offset().top) - headerHeight;

		$('html, body').animate({scrollTop: scroll}, speed);
		return false;
	});

	$('.ttTop').click(function() {
		$('html, body').animate({scrollTop: 0}, 300);
		return false;
	})

}

// ouvrir le menu en responsive
openRwdMenu = function() {

	$('#toggleMenu').click( function() {
		$('body, header').toggleClass('pushBody', 150, "linear");
		$('#rwdNav').toggleClass('pushMenu', 150, "linear");
		$('#toggleMenu i.burgerIcn').toggleClass('closeIcn');
	})

}

$(document).foundation().ready(imready);