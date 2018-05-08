var reloadModalHandlers = null;
$(document).ready(function() {

    reloadModalHandlers = function() {

        $("li[data-modal-container-id] > a, a[data-modal-container-id]").off('click').on("click", function(e) {
            e.stopPropagation();
            var container_id = undefined === $(this).attr('data-modal-container-id') ?
                                $(this).closest('li').attr('data-modal-container-id') : $(this).attr('data-modal-container-id');

            console.log('container_id=', container_id);

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
    }
    reloadModalHandlers();
});