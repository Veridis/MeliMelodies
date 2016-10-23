jQuery(document).ready(function() {
    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    $('body').popover({
        selector: '[data-toggle="popover"]',
        html : true,
        trigger: 'click focus'
    });
});
