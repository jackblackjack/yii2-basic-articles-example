$(document).ready(function() {
    $.pjax.defaults.timeout = 10000;
    initTogglers();
    $(document).on('pjax:complete', initTogglers);
});

function initTogglers() {
    $("a[data-model-id]").on("click", function(e) {
        e.stopPropagation();  

        if (confirm($(this).attr("data-confirm-text"))) {
            var container_id = $(this).attr("data-container-id");

            $.ajax(
                $(this).attr("data-url"), 
                { 
                    type: "POST" 
                })
                .done(function(data) {
                    $.pjax.reload({ container: container_id, timeout: false });
                });
        }
    });
}
