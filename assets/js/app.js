const $ = require('jquery');

require('jquery-datetimepicker/build/jquery.datetimepicker.full');

jQuery.datetimepicker.setLocale('fr');


jQuery('.js-datetimepicker').datetimepicker({
    format: 'd-m-Y H:i',
    step  : 10
});
$('.custom-control-input').change(function() {

    const $this = $(this),
          id    = $this.data('id');

    $.ajax({
        url    : Routing.generate('handle-task') + '/' + id,
        type   : 'POST',
        data   : {
            'checked': $this.is(':checked')
        },
        success: function() {
            $('.js-tr' + id).find('.spinner-border').removeClass('hidden')
            document.location.reload(true);
        }
    })
    return false;

})