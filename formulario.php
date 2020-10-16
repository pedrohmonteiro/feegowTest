<?php
include("nav.php");
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
        <!-- index CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/index.css">


        <title>Hello, world!</title>
    </head>

    <body>
        <div class="container">
            <form>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="nomeSpan">Nome Completo</span>
                            </div>
                            <input type="text" class="form-control" placeholder="" id="nome" aria-describedby="nomeSpan">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="dataNascimentoSpan">Data de Nascimento</span>
                            </div>
                            <input type="date" class="form-control" placeholder="" id="dataNascimento" name="dataNascimento" aria-describedby="dataNascimentoSpan">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="comoConheceu">Como Conheceu</label>
                            </div>
                            <select class="custom-select" id="comoConheceu" name="comoConheceu">
                                <option selected></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="cpfSpan">CPF</span>
                            </div>
                            <input type="text" class="form-control"  id="cpf" name="cpf" aria-describedby="cpfSpan">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col"><button type="button" class="btn btn-primary">SOLICITAR HORÁRIOS</button></div>
                </div>
            </form>
        </div>


        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js" crossorigin="anonymous"></script>
    
        
    </body>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $("#cpf").mask("999.999.999-99");  

        let url = "https://api.feegow.com/v1/api/patient/list-sources";
        let host = "api.feegow.com/v1";
        let contentType = "application/json";
        let token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38";
        getapi(url, host, contentType, token);


        $("#dataNascimento").on("focusout", function() {
            validaCampoData("#dataNascimento");
        });
        $("#cpf").on("change", function() {
            let cpf = $("#cpf").val();
            cpf = cpf.replaceAll(".", "");
            cpf = cpf.replace("-", "");
            if(TestaCPF(cpf) == false){
                alert("cpf inválido");
            }
        });


    });


    async function getapi(url, host, contentType, token) {

        let urlApi = url;
        let hostApi = "Host=" + host;
        let contentTypeApi = "Content-Type=" + contentType;
        let tokenApi = "x-access-token=" + token;

        final_url = urlApi + "?" + hostApi + "&" + contentTypeApi + "&" + tokenApi;
        // Storing response 
        const response = await fetch(final_url);
        // Storing data in form of JSON 
        var data = await response.json();
        console.log(data);

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

    function validaCampoData(campo) {
        var valor = $(campo).val();
        let piece = valor.split('-');
        if (piece[0] >= 2020) {

        }
        valor = piece[2] + "/" + piece[1] + "/" + piece[0];
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

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
            alert("data errada");
            return false;
        }
        return true;
    }


    function gravar() {
        var portal = $("#portal").val();
        var orgaoLicitante = $("#orgaoLicitante").val();
        var participaPregao = $("#participaPregao option:selected").val();
        var numeroPregao = $("#numeroPregao").val();
        var dataPregao = $("#dataPregao").val();
        var horaPregao = $("#horaPregao").val();
        var oportunidadeCompra = $("#oportunidadeCompra").val();


        if (portal === "") {
            smartAlert("Atenção", "Selecione um portal !", "error");
            $("#portal").focus();
            return;
        }

        if (orgaoLicitante === "") {
            smartAlert("Atenção", "Digite o Nome do Orgão Licitante !", "error");
            $("#orgaoLicitante").focus();
            return;
        }

        if (participaPregao === "") {
            smartAlert("Atenção", "Ecolha uma opção do Participar !", "error");
            $("#participaPregao").focus();
            return;
        }

        if (numeroPregao === "") {
            smartAlert("Atenção", "Digite o Número do Pregão !", "error");
            $("#numeroPregao").focus();
            return;
        }

        if (dataPregao === "") {
            smartAlert("Atenção", "Digite a Data do Pregão !", "error");
            $("#dataPregao").focus();
            return;
        }

        if (horaPregao === "") {
            smartAlert("Atenção", "Digite a Hora do Pregão !", "error");
            $("#horaPregao").focus();
            return;
        }

        if (oportunidadeCompra === "") {
            smartAlert("Atenção", "Digite a Oportunidade de Compra !", "error");
            $("#oportunidadeCompra").focus();
            return;
        }

        var form = $('#formGarimparPregoes')[0];
        var formData = new FormData(form);
        gravaPregoes(formData);
    }
</script>

<!-- $url = "https://api.feegow.com/v1/api/specialties/list?Host=api.feegow.com/v1&Content-Type=application/json&x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38" -->