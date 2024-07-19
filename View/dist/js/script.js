document.addEventListener("DOMContentLoaded", function () {
    const tipoCuenta = document.getElementById("tipoCuenta");
    const camposUsuario = document.getElementById("camposUsuario");

    if (tipoCuenta) {
        tipoCuenta.addEventListener("change", function () {
            if (this.value === "usuario") {
                camposUsuario.classList.add("hidden");
            } else {
                camposUsuario.classList.remove("hidden");
            }
        });
    }

   
});
