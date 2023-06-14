const Cargando = Swal.mixin({
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading()
    },
    showConfirmButton: false,
    width: '100',
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

const Alerta = Swal.mixin({
    toast: false,
    //position: 'top-end',
    showConfirmButton: true,
    //timer: 3000,
    //timerProgressBar: true,
    /*didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }*/
});

const MessageDelete = Swal.mixin({
    title: '¿Estas seguro?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, bórralo!'
});

