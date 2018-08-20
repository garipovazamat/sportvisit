
$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 5;

    $('#w0').on('click', '#add_phone', function () {
        var $template = $('#orgphones-0-number'),
            $clone = $template
                .clone()
                .removeAttr('id')
                .val('')
                .insertAfter($template),
            $option = $clone.find('[name="option[]"]');

        // Add new field
        //$('#surveyForm').formValidation('addField', $option);
    });
})