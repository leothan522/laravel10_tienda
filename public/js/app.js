//CAMPO BUSQUEDA EN EL NAVBAR
$("#navbarSearch").focus(function(){
    let form = $(this).closest("form");
    form.attr("onsubmit","return search()");
});
