$(document).ready(imready);

function imready() {
	toggle();
}

function toggle() {
	$(".button").click(function() {
		$("#rotate2").toggleClass("rotation");
	});
}