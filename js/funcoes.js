$(document).ready(function() {

    function validaCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }

    function validaCPF(strCPF) {
        var Soma;
        var Resto;
        var strCPF = strCPF.replace(".", "").replace(".", "").replace("-", "");
        Soma = 0;
        if ((strCPF == "00000000000") ||
            (strCPF == "11111111111") ||
            (strCPF == "22222222222") ||
            (strCPF == "33333333333") ||
            (strCPF == "44444444444") ||
            (strCPF == "55555555555") ||
            (strCPF == "66666666666") ||
            (strCPF == "77777777777") ||
            (strCPF == "88888888888") ||
            (strCPF == "99999999999")) {
            document.getElementById('cpf').value = "";
            alert('CPF inválido!');
        }

        if (strCPF != "") {
            for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11)) Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10))) {
                document.getElementById('cpf').value = "";
                alert('CPF inválido!');
            }

            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11)) Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11))) {
                document.getElementById('cpf').value = "";
                alert('CPF inválido!');
            }
        }
        return true;
    }

    function validaData(campo, valor) {
        if (valor != "") {
            var date = valor;
            var ardt = new Array;
            var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
            ardt = date.split("/");
            erro = false;

            var hoje = new Date();
            var anoAtual = hoje.getFullYear();

            if (anoAtual < ardt[2]) {
                erro = true;
            } else if (date.search(ExpReg) == -1) {
                erro = true;
            } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30)) {
                erro = true;
            } else if (ardt[1] == 2) {
                if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                    erro = true;
                if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                    erro = true;
            }

            // if (erro) {
            //     alert("Data inválida!");
            //     campo.value = "";
            //     campo.focus();
            //     return false;
            // }
        }
        return true;
    }

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#logradouro").val("");
        $("#complemento").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
    }

    $("#dtinicio").blur(function() {
        if (validaData($("#dtinicio"), $("#dtinicio").val()) == false) {
            $("#dtinicio").val("");
            $("#dtinicio").focus();
        }
    });

    $("#dtfinal").blur(function() {
        if (validaData($("#dtfinal"), $("#dtfinal").val()) == false) {
            $("#dtfinal").val("");
            $("#dtfinal").focus();
        }
    });

    $("#dt-emissao").blur(function() {
        if (validaData($("#dt-emissao"), $("#dt-emissao").val()) == false) {
            $("#dt-emissao").val("");
            $("#dt-emissao").focus();
        }
    });

    $("#dt-entrada").blur(function() {
        if (validaData($("#dt-entrada"), $("#dt-entrada").val()) == false) {
            $("#dt-entrada").val("");
            $("#dt-entrada").focus();
        }
    });

    $("#cpf").blur(function() {
        validaCPF($("#cpf").val());
    });

    $("#cnpj").blur(function() {
        if (validaCNPJ($("#cnpj").val()) == false) {
            alert('CNPJ inválido!');
            $("#cnpj").val("");
            $("#cnpj").focus();
        }
    });





    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro").val("...");
                $("#complemento").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
                $("#complemento").focus();

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#complemento").val(dados.complemento);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
    // Fim Quando o campo cep perde o foco.

    if ($("#fisica").prop("checked")) {
        $("#div-cnpj").hide();
        $("#div-ie").hide();
        $("#div-nomefantasia").hide();
        $("#div-contato").hide();

        $("#div-cpf").show();
        $("#div-rg").show();
        $("#div-emissor").show();
    } else {
        $("#div-cnpj").show();
        $("#div-ie").show();
        $("#div-nomefantasia").show();
        $("#div-contato").show();

        $("#div-cpf").hide();
        $("#div-rg").hide();
        $("#div-emissor").hide();
    }

    $("#fisica").click(function() {
        $("#div-cnpj").hide();
        $("#div-ie").hide();
        $("#div-contato").hide();
        $("#div-nomefantasia").hide();

        if ($("#cnpj").val() == "") {
            $("#cnpj").val("0");
        }
        if ($("#nomefantasia").val() == "") {
            $("#nomefantasia").val("0");
        }

        $("#div-cpf").show();
        $("#div-rg").show();
        $("#div-emissor").show();

        if ($("#cpf").val() == "0__.___.___-__") {
            $("#cpf").val("");
        }

    });

    $("#juridica").click(function() {
        $("#div-cnpj").show();
        $("#div-ie").show();
        $("#div-nomefantasia").show();
        $("#div-contato").show();

        if ($("#cnpj").val() == "0_.___.___/____-__") {
            $("#cnpj").val("");
        }
        if ($("#nomefantasia").val() == "0") {
            $("#nomefantasia").val("");
        }

        $("#div-cpf").hide();
        $("#div-rg").hide();
        $("#div-emissor").hide();

        if ($("#cpf").val() == "") {
            $("#cpf").val("0");
        }
    });


});