$(document).ready(function() {
  $('#galleries_dropdown').hide();

    $('#galleries_toggle').click(function() {
    $('#galleries_dropdown').toggle("fast");
    return false;
 });

  $('body').click(function(event) {
    if (!$(event.target).closest('#galleries_dropdown').length) {
    $('#galleries_dropdown').hide("fast");
  };
});

});