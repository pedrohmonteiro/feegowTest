<?php
include("components/nav.php");
?>

<div>

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- jquerry -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <!-- select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- index CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/index.css">


        <title>Agendamento</title>
    </head>

    <body>
        <div class="container">

            <form>

                <div class="row">

                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="nomeSpan">Nome Completo</span>
                            </div>
                            <input type="text" class="form-control" placeholder="" id="nome" aria-describedby="nomeSpan">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="dataNascimentoSpan">Data de Nascimento</span>
                            </div>
                            <input type="date" min="1900-01-01" max="2030-12-31" data-dateformat="dd/mm/yyyy" class="form-control" placeholder="" id="dataNascimento" name="dataNascimento" aria-describedby="dataNascimentoSpan">
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="cpfSpan">CPF</span>
                            </div>
                            <input type="text" class="form-control" id="cpf" name="cpf" aria-describedby="cpfSpan">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="comoConheceu">Como Conheceu</label>
                            </div>
                            <select class="custom-select select" id="comoConheceu" name="comoConheceu">
                                <option selected></option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col"><button type="button" class="btn btn-primary" id="btnGravar" name="btnGravar">SOLICITAR HORÁRIOS</button></div>
                </div>

            </form>

        </div>

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js" crossorigin="anonymous"></script>

        <script src="sql/bussines.js" type="text/javascript"></script>


    </body>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $('select').select2();
        //mascara do cpf
        $("#cpf").mask("999.999.999-99");

        let url = "https://api.feegow.com/v1/api/patient/list-sources";
        let host = "api.feegow.com/v1";
        let contentType = "application/json";

        getapiComoConheceu(url, host, contentType);

        $("#btnGravar").on("click", function() {
            gravar();
        });


        $("#dataNascimento").on("focusout", function() {
            validaCampoData("#dataNascimento");
        });

        $("#cpf").on("change", function() {
            let cpf = $("#cpf").val();
            cpf = cpf.replaceAll(".", "");
            cpf = cpf.replace("-", "");
            if (TestaCPF(cpf) == false) {
                swal("CPF inválido", {
                    dangerMode: true,
                });
                $("#cpf").val("");
            }
        });

        $("#nome").on("change", function() {
            let nome = $("#nome").val();
            if (allLetter(nome) == false) {
                $("#nome").val("");
            };
        });



    });

    // função para pegar o como conheceu passando a url - host - content type
    async function getapiComoConheceu(url, host, contentType) {

        let urlApi = url;
        let hostApi = "Host=" + host;
        let contentTypeApi = "Content-Type=" + contentType;


        final_url = urlApi + "?" + hostApi + "&" + contentTypeApi;
        // Storing response 
        recuperaApi(urlApi, hostApi, contentTypeApi,
            function(data) {

                var data = JSON.parse(data);

                for (const [key, value] of Object.entries(data)) {
                    if (key == 'content') {
                        arrayProfissional = value;

                        for (const [key, value] of Object.entries(arrayProfissional)) {
                            let id = value['origem_id'];
                            let nome = value['nome_origem'];
                            if (nome == null) {
                                nome = "";
                            }

                            var option = $('<option value=' + id + '>' + nome + '</option>');
                            $("#comoConheceu").append(option);

                        }
                    }
                }
            }
        );
    }

    // função para verificar se o nome contén somente caracteres corretos
    function allLetter(inputtxt) {
        var letters = /^[a-zà-ú .-]+$/i;
        if (letters.test(inputtxt)) {
            return true;
        } else {
            swal("Por favor entre somente com caracteres alfabéticos", {
                dangerMode: true,
            });
            return false;
        }
    }

    // função para verificar se o cpf esta correto
    function TestaCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;

        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10))) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11))) return false;
        return true;
    }

    // função para validar a data 
    function validaCampoData(campo) {
        var valor = $(campo).val();

        if (comparaData(valor) == 1) {
            swal("Data inválida", {
                dangerMode: true,
            });
            $(campo).val("");
            return false;
        }
        valor = piece[2] + "/" + piece[1] + "/" + piece[0];
        var validacao = validaData(valor);
        if (validacao === false) {
            $(campo).val("");
        }
    }

    // função para verificar se a data é maior ou menor que hj
    function comparaData(valor) {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        if (valor > today) {
            return 1;
        } else {
            return 0;
        }
    }

    // função para verificar se a data conten os dados corretos
    function validaData(valor) {
        var date = valor;
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            swal("Data inválida", {
                dangerMode: true,
            });
            return false;
        }
        return true;
    }

    // função para enviar os dados para o banco
    function gravar() {
        let nome = $("#nome").val();
        let dataNascimento = $("#dataNascimento").val();
        let comoConheceu = $("#comoConheceu option:selected").val();
        let cpf = $("#cpf").val();
        cpf = cpf.replaceAll(".", "");
        cpf = cpf.replace("-", "");
        let url_string = location.href;
        var url = new URL(url_string);
        var specialtyId = url.searchParams.get("specialty_id");
        var profissionalId = url.searchParams.get("professional_id");

        if (nome === "") {
            alert("Digite o Nome!");
            $("#nome").focus();
            return;
        }

        if (dataNascimento === "") {
            alert("Digite a data de nascimento!");
            $("#dataNascimento").focus();
            return;
        }

        if (comoConheceu === "") {
            alert("Selecione como conheceu!");
            $("#comoConheceu").focus();
            return;
        }

        if (cpf === "") {
            alert("Digite o cpf!");
            $("#cpf").focus();
            return;
        }

        gravaAgendamento(nome, dataNascimento, comoConheceu, cpf, specialtyId, profissionalId);

    }
</script>