document.addEventListener("DOMContentLoaded", function () {

    document.getElementById('tipoCuenta').addEventListener('click', function () {
        const tipoCuenta = document.getElementById('tipoCuenta');
        const camposUsuario = document.getElementById('camposUsuario');

        tipoCuenta.addEventListener('change', function () {
            if (this.value === 'usuario') {
                camposUsuario.classList.add('hidden');
            } else {
                camposUsuario.classList.remove('hidden');
            }
        });

    });
});