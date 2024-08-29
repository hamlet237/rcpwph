(function($) {
	'use strict';

	$(document).on('click', '.wph-tab-links', function(e){
    e.preventDefault();
    var tab_link = $(this);
    var tab_wrapper = $(this).closest('.wph-tabs-wrapper');
    
    tab_wrapper.find('.wph-tab-links').each(function(index, element) {
      $(this).removeClass('active');
      $($(this).attr('data-wph-id')).addClass('wph-display-none');
    });

    tab_wrapper.find('.wph-tab-content').each(function(index, element) {
      $(this).addClass('wph-display-none');
    });
    
    tab_link.addClass('active');
    tab_wrapper.find('#' + tab_link.attr('data-wph-id')).removeClass('wph-display-none');
  });

  $(document).on('click', '.rcpwph-options-save-btn', function(e){
    e.preventDefault();
    var rcpwph_btn = $(this);
    rcpwph_btn.addClass('rcpwph-link-disabled').siblings('.rcpwph-waiting').fadeIn('slow');

    var ajax_url = rcpwph_ajax.ajax_url;

    var data = {
      action: 'rcpwph_ajax',
      ajax_nonce: rcpwph_ajax.ajax_nonce,
      rcpwph_ajax_type: 'rcpwph_options_save',
      ajax_keys: [],
    };

    if (!(typeof window['rcpwph_window_vars'] !== 'undefined')) {
      window['rcpwph_window_vars'] = [];
    }

    $('.rcpwph-options-fields input:not([type="submit"]), .rcpwph-options-fields select, .rcpwph-options-fields textarea').each(function(index, element) {
      if ($(this).attr('multiple') && $(this).parents('.rcpwph-html-multi-group').length) {
        if (!(typeof window['rcpwph_window_vars']['form_field_' + element.id] !== 'undefined')) {
          window['rcpwph_window_vars']['form_field_' + element.id] = [];
        }

        window['rcpwph_window_vars']['form_field_' + element.id].push($(element).val());

        data[element.id] = window['rcpwph_window_vars']['form_field_' + element.id];
      }else{
        if ($(this).is(':checkbox') || $(this).is(':radio')) {
          if ($(this).is(':checked')) {
            data[element.id] = $(element).val();
          }else{
            data[element.id] = '';
          }
        }else{
          data[element.id] = $(element).val();
        }
      }

      data.ajax_keys.push({
        id: element.id,
        node: element.nodeName,
        type: element.type,
      });
    });

    $.post(ajax_url, data, function(response) {
      console.log(data);console.log(response);
      if ($.parseJSON(response)['error_key'] != '') {
        rcpwph_get_main_message(rcpwph_i18n.an_error_has_occurred);
      }else {
        rcpwph_get_main_message(rcpwph_i18n.saved_successfully);
      }

      rcpwph_btn.removeClass('rcpwph-link-disabled').siblings('.rcpwph-waiting').fadeOut('slow');
    });

    delete window['rcpwph_window_vars'];
  });
})(jQuery);