//CAMPO BUSQUEDA EN EL NAVBAR
$("#navbarSearch").focus(function(){
    let form = $(this).closest("form");
    form.attr("onsubmit","return buscar()");
});

function buscar(){
    let input = $("#navbarSearch");
    let keyword  = input.val();
    if (keyword.length > 0){
        input.blur();
        //alert('Falta vincular con el componente Livewire');
        //$('#cargar_buscar').removeClass('d-none');
        Livewire.dispatch('buscar', { keyword: keyword });
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

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

