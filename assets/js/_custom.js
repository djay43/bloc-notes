$(document).ready(function() {
    initDateTimePicker();
    handleSwitchChange()
});

// Init Date Time Picker
function initDateTimePicker() {
    jQuery.datetimepicker.setLocale('fr');
    jQuery('.js-datetimepicker').datetimepicker({
        format: 'd-m-Y H:i',
        step  : 10,
    });
}

// Handle Switch Status Change -- Ajax Request to controller
function handleSwitchChange() {

    $('.custom-control-input').change(function() {

        const $this = $(this),
              slug    = $this.data('slug');

        $.ajax({
            url    : Routing.generate('change-task-status') + '/' + slug,
            type   : 'POST',
            data   : {
                'checked': $this.is(':checked')
            },
            success: function() {
                $('.js-tr' + slug).find('.spinner-border').removeClass('hidden')
                document.location.reload(true);
            }
        });

        return false;
    })
}

