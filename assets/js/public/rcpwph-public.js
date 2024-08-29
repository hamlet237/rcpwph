(function($) {
	'use strict';

	function rcpwph_timer(step) {
		var step_timer = $('.rcpwph-player-step[data-rcpwph-step="' + step + '"] .rcpwph-player-timer');
		var step_icon = $('.rcpwph-player-step[data-rcpwph-step="' + step + '"] .rcpwph-player-timer-icon');
		
		if (!step_timer.hasClass('timing')) {
			step_timer.addClass('timing');

      setInterval(function() {
      	step_icon.fadeOut('fast').fadeIn('slow').fadeOut('fast').fadeIn('slow');
      }, 5000);

      setInterval(function() {
      	step_timer.text(Math.max(0, parseInt(step_timer.text()) - 1)).fadeOut('fast').fadeIn('slow').fadeOut('fast').fadeIn('slow');
      }, 60000);
		}
	}

	$(document).on('click', '.rcpwph-popup-player-btn', function(e){
  	rcpwph_timer(1);
	});

  $(document).on('click', '.rcpwph-steps-prev', function(e){
    e.preventDefault();

    var steps_count = $('#rcpwph-recipe-wrapper').attr('data-rcpwph-steps-count');
    var current_step = $('#rcpwph-popup-steps').attr('data-rcpwph-current-step');
    var next_step = Math.max(0, (parseInt(current_step) - 1));
    
    $('.rcpwph-player-step').addClass('rcpwph-display-none-soft');
    $('#rcpwph-popup-steps').attr('data-rcpwph-current-step', next_step);
    $('.rcpwph-player-step[data-rcpwph-step=' + next_step + ']').removeClass('rcpwph-display-none-soft');

    if (current_step <= steps_count) {
    	$('.rcpwph-steps-next').removeClass('rcpwph-display-none');
    }

    if (current_step <= 2) {
    	$(this).addClass('rcpwph-display-none');
    }

    rcpwph_timer(next_step);
	});

	$(document).on('click', '.rcpwph-steps-next', function(e){
    e.preventDefault();

    var steps_count = $('#rcpwph-recipe-wrapper').attr('data-rcpwph-steps-count');
    var current_step = $('#rcpwph-popup-steps').attr('data-rcpwph-current-step');
    var next_step = Math.min(steps_count, (parseInt(current_step) + 1));

    $('.rcpwph-player-step').addClass('rcpwph-display-none-soft');
    $('#rcpwph-popup-steps').attr('data-rcpwph-current-step', next_step);
    $('.rcpwph-player-step[data-rcpwph-step=' + next_step + ']').removeClass('rcpwph-display-none-soft');

    if (current_step >= 1) {
    	$('.rcpwph-steps-prev').removeClass('rcpwph-display-none');
    }

    if (current_step >= (steps_count - 1)) {
    	$(this).addClass('rcpwph-display-none');
    }

    rcpwph_timer(next_step);
	});

	$(document).on('click', '.rcpwph-ingredient-checkbox', function(e){
    e.preventDefault();

    if ($(this).text() == 'radio_button_unchecked') {
    	$(this).text('task_alt');
    }else{
    	$(this).text('radio_button_unchecked');
    }
	});

	$('.rcpwph-carousel-main-images .owl-carousel').owlCarousel({
    margin: 10,
    center: true,
    nav: false, 
    autoplay: true, 
    autoplayTimeout: 5000, 
    autoplaySpeed: 2000, 
    pagination: true, 
    responsive:{
      0:{
        items: 2,
      },
      600:{
        items: 3,
      },
      1000:{
        items: 4,
      }
    }, 
  });
})(jQuery);
