
$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#paginaCadastro").click(function (e) {
    $(".index").hide();
    $(".listagem").hide();
    $(".cadastro").show("slow");
});

$("#paginaListagem").click(function (e) {
    $(".index").hide();
    $(".cadastro").hide();
    $(".listagem").show("slow");
});

$("#paginaIndex").click(function (e) {
    $(".cadastro").hide();
    $(".listagem").hide();
    $(".index").show("slow");
});

/* Máscaras ER */
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function mtel(v) {
    v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function id(el) {
    return document.getElementById(el);
}

window.onload = function () {
    id('telefone').onkeyup = function () {
        mascara(this, mtel);
    }

}

$('#formulario').submit(function () {

    // Captura os dados do formulário
    var formulario = document.getElementById('formulario');

    // Instância o FormData passando como parâmetro o formulário
    var formData = new FormData(formulario);

    // Envia O FormData através da requisição AJAX
    $.ajax({
        url: "cadastro",
        type: "POST",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            var conteudo = "";
            for (var i = 0; i < retorno.length; i++) {
                conteudo += '<div class="row">';
                conteudo += '<div class="col-md-2 " style="border:1px solid">';
                conteudo += '<img src ="' + retorno[i].endereco + '" class="view">';
                conteudo += '</div >';
                conteudo += '<div class="col-md-3 " style="border:1px solid">';
                conteudo += retorno[i].nome;
                conteudo += '</div >';
                conteudo += '<div class="col-md-2 " style="border:1px solid">';
                conteudo += retorno[i].telefone;
                conteudo += '</div >';
                conteudo += '<div class="col-md-3 " style="border:1px solid">';
                conteudo += retorno[i].email;
                conteudo += '</div >';
                conteudo += '<div class="col-md-2 " style="border:1px solid">';
                conteudo += "<div id='" + retorno[i].id + "' class='btn excluir'>Excluir</div>";
                conteudo += "<div id='" + retorno[i].id + "' class='btn editar'>Editar</div>";
                conteudo += '</div >';
                conteudo += '</div >';

            }
            $('#listagemClientes').html(conteudo);
        }

    });
    alert('Cadastro Inserido Com Sucesso!')
    document.getElementById("nome").value = "";
    document.getElementById("email").value = "";
    document.getElementById("telefone").value = "";
    document.getElementById("foto").value = "";

    $("#foto").attr('src', '');
    return false;
});

$('#alteracao').submit(function () {

    // Captura os dados do formulário
    var formulario = document.getElementById('alteracao');

    // Instância o FormData passando como parâmetro o formulário
    var formData = new FormData(formulario);

    // Envia O FormData através da requisição AJAX
    $.ajax({
        url: "alteracao",
        type: "POST",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            if (retorno.status == '1') {
                $('.mensagem').html(retorno.mensagem);
            } else {
                $('.mensagem').html(retorno.mensagem)
            }
            $('.card-panel').removeClass('hide');
        }
    });

    return false;
});

$('.editar').click(function () {
    var id = $(this).attr('id');
    id = {'id': id};
    $.ajax({
        url: "consulta",
        type: "POST",
        data: id,
        dataType: 'json',
        success: function (retorno) {
            if (retorno.id > '0') {
                $(".modal").show();
                $(".modal-edicao").show();
                $(".popup").hide();
                var img = '<img src="' + retorno.endereco + '" class ="view">';
                var endereco = '"' + retorno.endereco + '"';

                $("#id_alteracao").attr('value', retorno.id);
                document.getElementById("foto_alteracao").value = "";
                $("#nome_alteracao").attr('value', retorno.nome);
                $('#email_alteracao').attr('value', retorno.email);
                $('#telefone_alteracao').attr('value', retorno.telefone);
                $("#foto_alteracao").attr('src', endereco);


            } else {
                $('.mensagem').html(retorno.mensagem)
            }
        }
    });

});

function editar(id) {
    var formulario = document.getElementById('alteracao');
    alert(formulario);
}


$('.excluir').click(function () {
    var id = $(this).attr('id');
    id = {'id': id};
    $.ajax({
        url: "consulta",
        type: "POST",
        data: id,
        dataType: 'json',
        success: function (retorno) {
            if (retorno.id > '0') {
                $(".modal").show();
                $(".popup").show();
                $(".modal-edicao").hide();

                var img = '<img src="' + retorno.endereco + '" class ="view" style="float:left">';
                conteudo = '<div>';
                conteudo += img;
                conteudo += '<div><span style="font-weight: bold">nome: </span>' + retorno.nome + '</div>';
                conteudo += '<div><span style="font-weight: bold">telefone: </span>' + retorno.telefone + '</div>';
                conteudo += '<div><span style="font-weight: bold">email: </span>' + retorno.email + '</div>';
                conteudo += '<div id = "' + retorno.id + '" class="btn excluir " onclick="confirma(' + retorno.id + ')">Excluir</div>';
                conteudo += '</div>';

                $('#popup').html(conteudo);
                $('.mensagem').html(retorno.mensagem);
            } else {
                $('.mensagem').html(retorno.mensagem)
            }
        }
    });

});


function confirma(id) {

    id = {'id': id};
    $.ajax({
        url: "exclusao",
        type: "POST",
        data: id,
        dataType: 'json',
        success: function (retorno) {
            if (retorno > '0') {
                $(".modal").show();
                var conteudo = "";
                for (var i = 0; i < retorno.length; i++) {
                    conteudo += '<div class="row">';
                    conteudo += '<div class="col-md-2 " style="border:1px solid">';
                    conteudo += '<img src ="' + retorno[i].endereco + '" class="view">';
                    conteudo += '</div >';
                    conteudo += '<div class="col-md-3 " style="border:1px solid">';
                    conteudo += retorno[i].nome;
                    conteudo += '</div >';
                    conteudo += '<div class="col-md-2 " style="border:1px solid">';
                    conteudo += retorno[i].telefone;
                    conteudo += '</div >';
                    conteudo += '<div class="col-md-3 " style="border:1px solid">';
                    conteudo += retorno[i].email;
                    conteudo += '</div >';
                    conteudo += '<div class="col-md-2 " style="border:1px solid">';
                    conteudo += "<div id='" + retorno[i].id + "' class='btn excluir'>Excluir</div>";
                    conteudo += "<div id='" + retorno[i].id + "' class='btn editar'>Editar</div>";
                    conteudo += '</div >';
                    conteudo += '</div >';
                }

                $('#listagemClientes').html(conteudo);
                $('#popup').html("Excluido com sucesso!");

            } else {
                $('.mensagem').html(retorno.mensagem)
            }
        }
    });

}

// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}