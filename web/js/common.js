$(document).ready(function() {
       
    $("li[data-modal-container-id] > a").on("click", function(e) {
        e.stopPropagation();
        var container_id = $(this).closest('li').attr('data-modal-container-id');

        $.ajax({
            url: $(this).attr('href'),
            success: function(data) {
                if ($(container_id).length) {
                    $(container_id).modal('show').html(data);
                }
            }
        });

        return false;
    });
});