 // De preferência em arquivo à parte


 $(".btnPesqReceber").on("click", function() {
     event.preventDefault();
     $.ajax({
         method: "GET",
         url: $(this).attr("href"),
         contentType: false,
         processData: false,
         success: function(retorna) {
             $(".md-id").val(retorna['receber_id']);
             $(".md-id2").val(retorna['receber_id']);
             $("#numero").html(retorna['receber_numero'] +
                 ' - ' + retorna['receber_sequencia']);
             $("#cliente").html(retorna['cli_nome']);
             $("#obra").html(retorna['obra_nome']);
             $("#dtVenc").html(retorna['vencimento']);
             $("#vlInicial").html('R$ ' + retorna['valor']);

             if (retorna['receber_status'] == 'P') {
                 $('.formPagamento').hide();
                 $('.divPago').show();
                 $('#pagamento').html(retorna['pagamento']);
                 $('#final').html('R$ ' + retorna['final']);
                 $('#pghistorico').html(retorna['receber_historico']);
             } else {
                 $('.formPagamento').show();
                 $('.divPago').hide();
                 $('#vlFinal').val(retorna['valor']);
                 $('#historico').text(retorna['receber_historico']);
             }
             $('#pesqReceber').modal('show');
         }
     })
 });



 $(document).ready(function() {

     $(".fechar-modal").on("click", function() {
         location.reload();
     });

     $("#addRecebimento").on("submit", function(event) {
         event.preventDefault();
         $.ajax({
             method: "POST",
             url: "./quitacao-receber.php",
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

     $("#estornarRecebimento").on("submit", function(event) {
         event.preventDefault();
         $.ajax({
             method: "POST",
             url: "./estornar-receber.php",
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



     //  $(".btnRecibo").on("click", function() {
     //      event.preventDefault();
     //      var id = $(".md-id").val();
     //      window.location.href = './config-recibo.php?id=' + id;
     //  });
 });