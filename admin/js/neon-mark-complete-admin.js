jQuery(document).ready(function($) {
    // Toggle switches
    $('.switch input[type="checkbox"]').change(function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $this.closest('.switch').addClass('on');
        } else {
            $this.closest('.switch').removeClass('on');
        }
    });

    // Handle checkboxes
    $('.settings-checkbox input[type="checkbox"]').change(function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $this.closest('.settings-checkbox').addClass('checked');
        } else {
            $this.closest('.settings-checkbox').removeClass('checked');
        }
    });
});
