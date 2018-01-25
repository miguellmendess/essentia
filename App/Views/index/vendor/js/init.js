$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#paginaCadastro").click(function(e) {
    $( ".index" ).hide();
    $( ".listagem" ).hide();
    $( ".cadastro" ).show("slow");
});

$("#paginaListagem").click(function(e) {
    $( ".index" ).hide();
    $( ".cadastro" ).hide();
    $( ".listagem" ).show("slow");
});

$("#paginaIndex").click(function(e) {
    $( ".cadastro" ).hide();
    $( ".listagem" ).hide();
    $( ".index" ).show("slow");
});
