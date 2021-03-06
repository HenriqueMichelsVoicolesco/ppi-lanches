// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function (form) {
  form.addEventListener('submit', function (event) {
    if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  }, false);
});

// verifica se um dos radio buttons dos formularios
// de inserção estão selecionados, se sim mostra o formulario,
// essas duas linha são para a atualização que já deixa um selecionado
var id_form = $('input[name=form-check]:checked').val();
$("#" + id_form).show();

// a cada mudança de seleção dos radio buttons trocar o 
// formulario a ser exibido e esconde o outro, essa função
// seria para ao adicionar um novo usuário, servidor ou turma
$("input[name=form-check]").on("change", function () {
  var id_form = $(this).val();
  $("form").hide();
  $("#" + id_form).show();
});

// pega o valor dos checkbox do formulario dos dias
// de lanche, se ao enviar o formulario pelo menos uma 
// estiver marcada então valida todas retirando os required
// de cada uma, se não coloca todas como required
var cbx_group = $("input:checkbox[name='diasLanche[]']");
$("#btn-t").click(function () {
  if (cbx_group.is(":checked")) {
    cbx_group.prop("required", false);
  } else {
    cbx_group.prop("required", true);
  }
});

// para não enviar um ajax a todo momento sem estar na pagina
// do contado então verifica se o id dele existe, se existir
// verifica a cada 1 segundo por ajax quantos usuários pediram
// o lanche naquele dia  
if ($("#contador").length) {
  setInterval(function () {
    $.ajax({
      url: "?pagina=read&metodo=numRegistros&ajax=sim",
      dataType: "JSON",
      success: function (result) {
        var contador = '';
        if (result != 0) {
          $.each(result, function (index, data) {
            contador += '<div class="col-lg-5"><p>' + data.curso + ' - ' + data.semestre + ' - ' + data.modalidade + ': ' + data.num_registros + '</p></div>';
          });
        } else {
          contador += '<div class="col-lg-5"><p> Nenhuma turma requisitou lanche hoje! </p></div>';
        }
        $("#contador").html(contador);
      }
      // [debug] se ocorrer um erro exibe-o como 
      // tabela no console do navegador
      //, error: function (jqXHR, exception) {
      //   var msg = '';
      //   if (jqXHR.status === 0) {
      //     msg = 'Not connected.\n Verify Network.';
      //   } else if (jqXHR.status == 404) {
      //     msg = 'Requested page not found. [404]';
      //   } else if (jqXHR.status == 500) {
      //     msg = 'Internal Server Error [500].';
      //   } else if (exception === 'parsererror') {
      //     msg = 'Requested JSON parse failed.';
      //   } else if (exception === 'timeout') {
      //     msg = 'Time out error.';
      //   } else if (exception === 'abort') {
      //     msg = 'Ajax request aborted.';
      //   } else {
      //     msg = 'Uncaught Error.\n' + jqXHR.responseText;
      //   }
      //   console.log(msg);
      // },
    });
  }, 1000);
}

// adiciona na variavel metodo qual o valor
// do data-metodo no formulario da pagina
// de reserva e no de retirada, e inicializa
// as variaveis de url para o ajax
var metodo = $("form").data("metodo");
var url_envio;
var url_resposta;

// se o existir o formulario reserva e o retirada:
if ($("#form-reserva, #form-retirada").length) {

  // desabilida a tecla tab para não ser possível
  // remover o foco do input de matricula
  $(document).keydown(function (objEvent) {
    if (objEvent.keyCode == 9) {
      objEvent.preventDefault();
    }
  });

  // verifica o valor da variavel metodo, se for igual a reserva
  // então define a variavel com essas urls, do contrario, outros
  // valores para elas
  if (metodo == 'reserva') {
    url_envio = "?pagina=create&metodo=reservaMatricula&ajax=sim";
    url_resposta = "?pagina=read&metodo=respostaReserva&ajax=sim";
  } else {
    url_envio = "?pagina=create&metodo=retiradaMatricula&ajax=sim";
    url_resposta = "?pagina=read&metodo=respostaRetirada&ajax=sim";
  }

  // ao submeter o formulário:
  $('form').submit(function () {

    // atribui o valor do input da matricula na variável
    var matricula = $("input[name=matricula]").val();

    // chama o ajax com o endereço do php(var url_envio), 
    // passa o método (GET) e os dados (var matricula)
    if (matricula) {
      $.ajax({
        url: url_envio,
        type: "GET",
        data: {
          id: matricula,
        }
      });
    }
    // após executar retorna como falso para
    // não enviar o formulário pelo html,
    // apenas pelo ajax
    return false;
  });
}

// variavel contendo o intervalo de tempo
// do ajax
var timer = null;
var timer = setInterval(ajaxReturn, 1000);

// a cada 3,1 segundos o ajax
// verifica o arquivo para pegar
// os dados de retorno da reserva 
// ou retirada
function ajaxReturn() {
  $.ajax({
    url: url_resposta,
    dataType: "JSON",
    // se for sucesso chama a função
    // para que para o ajax e exibe 
    // o resultado
    success: function (response) {
      stopTimer();
      display(response);
    }
    // [debug] se ocorrer um erro exibe-o como 
    // tabela no console do navegador
    // ,error: function (jqXHR, exception) {
    //   var msg = '';
    //   if (jqXHR.status === 0) {
    //     msg = 'Not connected.\n Verify Network.';
    //   } else if (jqXHR.status == 404) {
    //     msg = 'Requested page not found. [404]';
    //   } else if (jqXHR.status == 500) {
    //     msg = 'Internal Server Error [500].';
    //   } else if (exception === 'parsererror') {
    //     msg = 'Requested JSON parse failed.';
    //   } else if (exception === 'timeout') {
    //     msg = 'Time out error.';
    //   } else if (exception === 'abort') {
    //     msg = 'Ajax request aborted.';
    //   } else {
    //     msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //   }
    //   console.log(msg);
    // }
  });
}

function stopTimer() {
  timer = clearInterval(timer);
}
function continueTimer() {
  timer = setInterval(ajaxReturn, 1000);
}


// função para chamar o modal (muda o display para flex)
// exibe o nome do aluno/matricula e a mensagem
// desabilita o botão de enviar e o input
// nos paragrafos e após 3 segundo fecha o modal 
// (muda o display para none), reabilita novamente
// o botão e o input, limpa o formulário, ativa novamente 
// o focus e recomeça a execução do ajax
function display(response) {
  $("#modal").css("display", "flex");
  $("#identificacao").text(response.identificacao);
  $("#mensagem").html(response.mensagem);
  $("button[name=submit], input[name=matricula]").prop("disabled", true);
  setTimeout(function () {
    $("#modal").css("display", "none");
    $("button[name=submit], input[name=matricula]").prop("disabled", false);
    $("form")[0].reset();
    $("form").removeClass('was-validated');
    $("input[name=matricula]").focus();
    continueTimer();
  }, 3000);

};