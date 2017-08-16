$(document).ready(function () {
    $('#add_modal').on('shown.bs.modal', function (e) {
        $("#input_title").focus();
    });
    
    $('[data-toggle="popover"]').popover({
    //Установление направления отображения popover
    trigger: 'click',    
    html: 'true'
    
  });
});




