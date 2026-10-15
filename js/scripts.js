/*
$(function(){

	//your scripts
	//alert('jquery');
	$('body').on('click','.menu-trigger', function(){
	//	console.log($('#menu-header'));
	$('#menu-principal').toggleClass('visible-md');
	$(this).closest('.menu-mobile').toggleClass('menu-open');
	$(this).toggleClass('trigger-open');
	return false;
});

*/
/*

$('#street_lightbox_trigger').on('click', function(){
const street_lightbox = lity();
street_lightbox('#street_lightbox');
init_street_view('gstreet_lightbox');
return false;
street_lightbox.opener();
});
$('#map_lightbox_trigger').on('click', function(){
const map_lightbox = lity();
map_lightbox('#map_lightbox');
init_map('gmap_lightbox');
return false;
map_lightbox.opener();
});
*/
/*
$('#map_lightbox').on('shown.bs.modal', function () {
	init_map('gmap_lightbox');
	//console.log('map');
});
$('#street_lightbox').on('shown.bs.modal', function () {
	init_street_view('gstreet_lightbox');
	//console.log('street');
});
});
*/

$(function(){
    $('.modal-button').on('click',function() {
        el = ($(this).attr('data-target'));
        $(el).addClass('is-active');

        if(el == '#modal-lightbox'){
            init_map('gmap_lightbox');
        }
        if(el == '#modal-streetview'){
            init_street_view('gstreet_lightbox');
        }
    });
    $('.delete').add('.modal-background').on('click',function() {
        $('.modal').removeClass('is-active');
    });
    $('#closebtn').on('click',function() {
        $('.modal').removeClass('is-active');
    });
});

/*
var nav = document.querySelector('nav');
//var navHeight = nav.offsetHeight;

window.addEventListener('scroll', function () {
if (window.pageYOffset > 90) {
nav.classList.add('fixed-top')
//nav.classList.remove('navbar-dark')
//nav.classList.add('bg-light','navbar-light')
} else {
nav.classList.remove('fixed-top')
//nav.classList.remove('bg-light','navbar-light')
//nav.classList.add('navbar-dark')
}
});
*/
/*
var nav = document.querySelector('nav');
//var navHeight = nav.offsetHeight;

window.addEventListener('scroll', function () {
    if (window.pageYOffset > 90) {
        nav.classList.remove('is-transparent')
    } else {
        nav.classList.add('is-transparent')
    }
});
*/





document.addEventListener('DOMContentLoaded', () => {
	// Get all "navbar-burger" elements
	const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
	// Check if there are any navbar burgers
	if ($navbarBurgers.length > 0) {

		// Add a click event on each of them
		$navbarBurgers.forEach( el => {
			el.addEventListener('click', () => {

				// Get the target from the "data-target" attribute
				const target = el.dataset.target;
				const $target = document.getElementById(target);

				// Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
				el.classList.toggle('is-active');
				$target.classList.toggle('is-active');
			});
		});
	}
});
