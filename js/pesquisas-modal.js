$(document).ready(function() {

    $('#pesquisa-cliente').keyup(function() {
        var pesquisa = $(this).val();

        if (pesquisa != '') {
            var dados = {
                palavra: pesquisa
            }
            $.post('../cliente/pesquisa-cliente.php', dados, function(retorno) {
                $('.cliente').html(retorno);
            });
        } else {
            $('.cliente').html("Nenhum cliente encontrado!");
        }
    });

    $('#pesquisa-tecnico').keyup(function() {
        var pesquisa = $(this).val();

        if (pesquisa != '') {
            var dados = {
                palavra: pesquisa
            }
            $.post('../funcionario/pesquisa-tecnico.php', dados, function(retorno) {
                $('.tecnico').html(retorno);
            });
        } else {
            $('.tecnico').html("Nenhum funcionário encontrado!");
        }
    });

    $('#pesquisa-projeto').keyup(function() {
        var pesquisa = $(this).val();

        if (pesquisa != '') {
            var dados = {
                palavra: pesquisa
            }
            $.post('../funcionario/pesquisa-projeto.php', dados, function(retorno) {
                $('.projeto').html(retorno);
            });
        } else {
            $('.projeto').html("Nenhum funcionário encontrado!");
        }
    });

    $('#pesquisa-fornecedor').keyup(function() {
        var pesquisa = $(this).val();

        if (pesquisa != '') {
            var dados = {
                palavra: pesquisa
            }
            $.post('../fornecedor/pesquisa-fornecedor.php', dados, function(retorno) {
                $('.fornecedor').html(retorno);
            });
        } else {
            $('.fornecedor').html("Nenhum fornecedor encontrado!");
        }
    });

    $('#pesquisa-produto').keyup(function() {
        var pesquisa = $(this).val();

        if (pesquisa != '') {
            var dados = {
                palavra: pesquisa
            }
            $.post('../produto/pesquisa-produto.php', dados, function(retorno) {
                $('.produto').html(retorno);
            });
        } else {
            $('.produto').html("Nenhum produto encontrado!");
        }
    });

    $('#pesquisa-obra').keyup(function() {

        var pesquisa = $(this).val();
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra.php', dados, function(retorno) {
            $('.obra').html(retorno);
        });
    });

    $('#pesqObra').on('shown.bs.modal', function(e) {
        var pesquisa = '';
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra.php', dados, function(retorno) {
            $('.obra').html(retorno);
        });
    });

    $('#pesquisa-obra-padrao').keyup(function() {

        var pesquisa = $(this).val();
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra-padrao.php', dados, function(retorno) {
            $('.obrapadrao').html(retorno);
        });
    });

    $('#pesqObraPadrao').on('shown.bs.modal', function(e) {
        var pesquisa = '';
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra-padrao.php', dados, function(retorno) {
            $('.obrapadrao').html(retorno);
        });
    });

    $('#pesquisa-obra-cliente').keyup(function() {

        var pesquisa = $(this).val();
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra-cliente.php', dados, function(retorno) {
            $('.obracliente').html(retorno);
        });
    });

    $('#pesqObraCliente').on('shown.bs.modal', function(e) {
        var pesquisa = '';
        var dados = {
            palavra: pesquisa
        }
        $.post('../obra/pesquisa-obra-cliente.php', dados, function(retorno) {
            $('.obracliente').html(retorno);
        });
    });



    $(document).on('click', '.item-cliente', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#cliente').val(txt[2]);
        $('#nomecliente').val(txt[0]);
    });

    $(document).on('click', '.item-tecnico', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#resp_tecnico').val(txt[2]);
        $('#nometecnico').val(txt[0]);
    });

    $(document).on('click', '.item-projeto', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#resp_projeto').val(txt[2]);
        $('#nomeprojeto').val(txt[0]);
    });

    $(document).on('click', '.item-fornecedor', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#fornecedor').val(txt[2]);
        $('#nomefornecedor').val(txt[0]);
    });

    $(document).on('click', '.item-produto', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#produto').val(txt[2]);
        $('#nomeproduto').val(txt[0]);
    });

    $(document).on('click', '.item-obra', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#obra').val(txt[1]);
        $('#nomeobra').val(txt[0]);
    });

    $(document).on('click', '.item-obra-padrao', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#obrapadrao').val(txt[1]);
        $('#nomeobrapadrao').val(txt[0]);
    });

    $(document).on('click', '.item-obra-cliente', function() {
        var txt = $(this).text().trim().split(" | ");
        $('.close').trigger('click');
        $('#cliente').val(txt[2]);
        $('#obra').val(txt[1]);
        $('#nomeobra').val(txt[0]);

    });

});