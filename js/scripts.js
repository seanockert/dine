var mobile = true;
var index = 1;
var docWidth = $(document).width();
var docHeight = $(document).height();


$(document).ready(function ($) {

    $('html').removeClass('no-js').addClass('js');

    $(window).resize(function() {
    	var docWidth = $(document).width(); 
        checkWidth(); 
    });

    // Smooth scroll to top of page
    $('.totop').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 600);
      return false;
    });    



    // Toggle the main navigation menu button for small screens  
    var $menu = $('#menu'),
    $menulink = $('.menu-link');     
    $menulink.click(function() {
      $menulink.toggleClass('active');
      $menu.toggleClass('active');
      return false;
    });
    
    $('#content').click(function() {
      if ($menulink.hasClass('active')) {
        $menulink.removeClass('active');
        $menu.removeClass('active');
      }
    });

	// Start slide at 0 on load
	/*
  var beginSlide = 0;
	$('#slider').find("[data-slide='" + beginSlide + "']").addClass('active');
	
	// Swipe JS slider
	window.slider = new Swipe(document.getElementById('slider'), {
	  continuous: true,
	  auto: 8000,
	  speed : 200,
	  startSlide : beginSlide,
	  callback: function(index, elem) { 
		var currentSlide = this.slides[index];
		$('.swipe-wrap div, .swipe-nav button').removeClass('active');
		$('.swipe-nav button[data-slide="'+index+'"]').addClass('active');
		$(currentSlide).addClass('active');
	  }
	});

	// Slider controls
	$('.swipe-nav button').click(function (e) {
		e.preventDefault();
		if (!$(this).hasClass('active')) {
			index = parseInt($(this).attr('data-slide'));
			slider.slide(index);
		}
	}) 

	$('.swipe-wrap>div').click(function (e) {
		e.stopPropagation();
		if (!$(this).hasClass('active')) {
			e.preventDefault();
			index = parseInt($(this).attr('data-slide'));
			slider.slide(index);
		}
	}) 
  */  

	// Load social buttons
	//Socialite.load();
	
    checkWidth();
	
});


// Toggle mobile variable 
var checkWidth = function() {
    if (docWidth > 767) {
        mobile = false;    
    } else {
        // Is mobile
        mobile = true;    
    }  	
}

// Enable fastclick plugin to remove click delay on mobiles - more responsive feel
if (!$.browser.msie) {
    window.addEventListener('load', function() {
        new FastClick(document.body);
    }, false);
}

// Form Validation
$('form input, form textarea').bind('blur', validateField);


// Form Validation
var validForm = false; // Global so we can disable the form submit if not valid
function validateEmail(email) {   
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}       

function validateField(){
    var isValid = false;        
    var elemID = '#' + $(this).attr('id');
    var elem = $(elemID);
   
    if (elemID == '#email') {
      // Validate the email address 
      if (validateEmail($(elem).val())) {
        isValid = true;
      } else {
        isValid = false;
      }             
      
    } else {
      // Check if not empty 
      if ($(elem).val()) {
        isValid = true;                 
      } else {
        isValid = false;
      } 
    }
    
    // Apply validation styles
    if (isValid) {
        $(elem).next('abbr').removeClass().addClass('icon-check').prop('title', 'Completed this field');     
    } else {
        $(elem).next('abbr').removeClass().addClass('icon-cancel').prop('title', 'Please complete this field');
    }
}



