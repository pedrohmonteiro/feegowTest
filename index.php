<?php
//importação da navbar 
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
        <!-- index CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/index.css">


        <title>Agendamento</title>
    </head>

    <body>
        <div class="container">

            <div class="row">

                <div class="col-sm">

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <label class="input-group-text" for="especialidade">Especialidades</label>
                        </div>

                        <select class="custom-select" id="especialidade" name="especialidade">
                            <option selected> </option>
                        </select>

                    </div>

                    <div class="row row-cols-1 row-cols-md-4" id="card">
                    </div>

                </div>

            </div>

        </div>

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!-- bussines -->
        <script src="sql/bussines.js" type="text/javascript"></script>

    </body>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $('.custom-select').select2();

        let host = "api.feegow.com/v1";
        let contentType = "application/json";

        getapiEspecialidade("https://api.feegow.com/v1/api/specialties/list", host, contentType);

        $("#especialidade").on("change", function() {
            let codigo = $("#especialidade").val();
            getapiProfissional("https://api.feegow.com/v1/api/professional/list", host, contentType, codigo);
            $("#card").html("");
        });
    });

    // função para pegar os epecialistas passando a url - host - content type
    async function getapiEspecialidade(url, host, contentType) {

        let urlApi = url;
        let hostApi = "Host=" + host;
        let contentTypeApi = "Content-Type=" + contentType;

        // Storing response 
        recuperaApi(urlApi, hostApi, contentTypeApi,
            function(data) {
                var data = JSON.parse(data);
                for (const [key, value] of Object.entries(data)) {
                    if (key == 'content') {
                        array = value;
                        for (const [key, value] of Object.entries(array)) {
                            let id = value['especialidade_id'];
                            let nome = value['nome'];
                            if (nome == null) {
                                nome = "";
                            }

                            var option = $('<option value=' + id + '>' + nome + '</option>');
                            $("#especialidade").append(option);

                        }
                    }
                }
            }
        );
    }

    // função para pegar os profissionais pela especialidade escolhida passando a url - host - content type - id da especialidade
    async function getapiProfissional(url, host, contentType, id) {

        let urlApi = url;
        let hostApi = "Host=" + host;
        let contentTypeApi = "Content-Type=" + contentType;
        let idApi = "especialidade_id=" + id;

        // Storing response 
        recuperaApiProfissional(urlApi, hostApi, contentTypeApi, idApi,
            function(data) {
                var data = JSON.parse(data);
                let contador = 0;
                for (const [key, value] of Object.entries(data)) {
                    if (key == 'content') {
                        arrayProfissional = value;
                        for (const [key, value] of Object.entries(arrayProfissional)) {
                            let idProfissional = value['profissional_id'];
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

                            let design = "";
                            contador = parseInt(key);

                            if (contador & 1) {
                                design = "card-design"
                            }
                            let idEspecialidade = $("#especialidade").val();
                            var card = $('<div class="col mb-4"><div class="card"><div class="card-body ' + design + '"><h5 class="card-title">' + tratamento + ' ' + nome + '</h5><p class="card-text">CRM : ' + crm + '</p><a href="formulario.php?specialty_id=' + idEspecialidade + '&professional_id=' + idProfissional + '" class="btn btn-primary">AGENDAR</a></div></div></div>');
                            $("#card").append(card);


                        }
                    }
                }
            }
        );
    }
</script>