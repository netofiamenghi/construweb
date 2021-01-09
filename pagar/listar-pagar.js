 // De preferência em arquivo à parte

 $(".btnPesqPagar").on("click", function() {
     event.preventDefault();
     $.ajax({
         method: "GET",
         url: $(this).attr("href"),
         contentType: false,
         processData: false,
         success: function(retorna) {
             $(".md-id").val(retorna['pagar_id']);
             $(".md-id2").val(retorna['pagar_id']);
             $("#numero").html(retorna['pagar_numero'] +
                 ' - ' + retorna['pagar_sequencia']);
             $("#fornecedor").html(retorna['for_razaosocial']);
             $("#obra").html(retorna['obra_nome']);
             $("#dtVenc").html(retorna['vencimento']);
             $("#vlInicial").html('R$ ' + retorna['valor']);

             if (retorna['pagar_status'] == 'P') {
                 $('.formPagamento').hide();
                 $('.divPago').show();
                 $('#pagamento').html(retorna['pagamento']);
                 $('#final').html('R$ ' + retorna['final']);
                 $('#pghistorico').html(retorna['pagar_historico']);
             } else {
                 $('.formPagamento').show();
                 $('.divPago').hide();
                 $('#vlFinal').val(retorna['valor']);
                 $('#historico').text(retorna['pagar_historico']);
             }
             $('#pesqPagar').modal('show');
         }
     })
 });



 $(document).ready(function() {

     $(".fechar-modal").on("click", function() {
         location.reload();
     });

     $("#addPagamento").on("submit", function(event) {
         event.preventDefault();
         $.ajax({
             method: "POST",
             url: "./quitacao-pagar.php",
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

     $("#estornarPagamento").on("submit", function(event) {
         event.preventDefault();
         $.ajax({
             method: "POST",
             url: "./estornar-pagar.php",
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

     //  $(".btnPesqPagar").on("click", function() {
     //      event.preventDefault();
     //      $.ajax({
     //          method: "GET",
     //          url: $(this).attr("href"),
     //          contentType: false,
     //          processData: false,
     //          success: function(retorna) {
     //              $(".md-id").val(retorna['pagar_id']);
     //              $(".md-id2").val(retorna['pagar_id']);
     //              $("#numero").html(retorna['pagar_numero'] +
     //                  ' - ' + retorna['pagar_sequencia']);
     //              $("#fornecedor").html(retorna['for_razaosocial']);
     //              $("#obra").html(retorna['obra_nome']);
     //              $("#dtVenc").html(retorna['vencimento']);
     //              $("#vlInicial").html('R$ ' + retorna['valor']);

     //              if (retorna['pagar_status'] == 'P') {
     //                  $('.formPagamento').hide();
     //                  $('.divPago').show();
     //                  $('#pagamento').html(retorna['pagamento']);
     //                  $('#final').html('R$ ' + retorna['final']);
     //                  $('#pghistorico').html(retorna['pagar_historico']);
     //              } else {
     //                  $('.formPagamento').show();
     //                  $('.divPago').hide();
     //                  $('#vlFinal').val(retorna['valor']);
     //                  $('#historico').text(retorna['pagar_historico']);
     //              }
     //              $('#pesqPagar').modal('show');
     //          }
     //      })
     //  });

     $(".btnRecibo").on("click", function() {
         event.preventDefault();
         var id = $(".md-id").val();
         window.location.href = './config-recibo.php?id=' + id;
     });
 });