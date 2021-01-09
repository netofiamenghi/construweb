$(document).ready(function() {

    $("#btnPagamento").on("click", function() {
        event.preventDefault();
        $('#pesqPgto').modal('show');
    });

    $("#btn-close-modal").on("click", function(event) {
        location.reload();
    });

    $("#addTitulos").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            method: "POST",
            url: "./incluir-titulos.php",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(retorna) {
                if (retorna['sit']) {
                    $("#msg-cad").html(retorna['msg']);
                } else {
                    $("#msg-cad").html(retorna['msg']);
                }
            }
        });
    });

});