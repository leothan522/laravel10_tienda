//CAMPO BUSQUEDA EN EL NAVBAR
$("#navbarSearch").focus(function(){
    let form = $(this).closest("form");
    form.attr("onsubmit","return search()");
});

function search(){
    let input = $("#navbarSearch");
    let keyword  = input.val();
    if (keyword.length > 0){
        input.blur();
        //alert('Falta vincular con el componente Livewire');
        Livewire.emit('buscar', keyword);
    }
    return false;
}

$(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    $('.swalDefaultInfo').click(function() {
        Toast.fire({
            icon: 'info',
            title: 'Generando Archivo'
        })
    });

});
