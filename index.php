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
            <input id="codigo" name="codigo" type="text" class="hidden" hidden value="">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="especialidade">Especialidades</label>
                </div>
                <select class="custom-select" id="especialidade" name="especialidade">
                    <option selected></option>
                    <?php
                    include("connection.php");
                    ?>
                </select>
            </div>
            <div class="row row-cols-1 row-cols-md-4" id="card">
            </div>
        </div>


        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $("#especialidade").on("change", function() {
            let codigo = $("#especialidade").val();
            let api_url = 'https://api.feegow.com/v1/api/professional/list?&Host=api.feegow.com/v1&Content-Type=application/json&x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38&ativo=1&especialidade_id=263';
            let response = getapi(api_url);
        });
    });

    async function getapi(url) {

        // Storing response 
        const response = await fetch(url);
        // Storing data in form of JSON 
        var data = await response.json();
        console.log(data);

        for (const [key, value] of Object.entries(data)) {
            if (key == 'content') {
                arrayProfissional = value;
                for (const [key, value] of Object.entries(arrayProfissional)) {
                    let id = value['profissional_id'];
                    let tratamento = value['tratamento'];
                    let nome = value['nome'];
                    let crm = value['documento_conselho'];

                    if (tratamento == null) {
                        tratamento = "";
                    }
                    if (nome == null) {
                        nome = "";
                    }
                    if (crm == null) {
                        crm = "";
                    }

                    var card = $('<div class="col mb-4"><div class="card"><div class="card-body"><h5 class="card-title">' + tratamento + ' ' + nome + '</h5><p class="card-text">CRM : ' + crm + '</p><a href="formulario.php?id=' + id + '" class="btn btn-primary">AGENDAR</a></div></div></div>');
                    $("#card").append(card);

                }
            }
        }
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