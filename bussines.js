function recuperaApi(url, host, contentType, callback) {
  $.ajax({
    url: "sqlscope_connection.php",
    dataType: "html",
    type: "post",
    data: {
      funcao: "get_data_from_api",
      url: url,
      host: host,
      contentType: contentType
    },
    success: function (data) {
      callback(data);
    },
  });
}

function recuperaApiProfissional(url, host, contentType, id, callback) {
  $.ajax({
    url: "sqlscope_connection.php",
    dataType: "html",
    type: "post",
    data: {
      funcao: "get_data_from_api_profissional",
      url: url,
      host: host,
      contentType: contentType,
      id: id
    },
    success: function (data) {
      callback(data);
    },
  });
}

function gravaAgendamento(nome,dataNascimento,comoConheceu,cpf,specialtyId,profissionalId) {
  $.ajax({
    url: "sqlscope_connection.php",
    dataType: "html",
    type: "post",
    data: {
      funcao: "grava_agendamento",
      nome: nome,
      dataNascimento: dataNascimento,
      comoConheceu: comoConheceu,
      cpf: cpf,
      specialtyId: specialtyId,
      profissionalId: profissionalId
    },
    success: function (data) {
      alert("Agendamento concluído com sucesso");
      $(location).attr('href', 'index.php');
    },
  });
}
