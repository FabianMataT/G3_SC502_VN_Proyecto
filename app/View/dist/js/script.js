document.addEventListener("DOMContentLoaded", function () {
    const tipoCuenta = document.getElementById("tipoCuenta");

    if (tipoCuenta) {
        tipoCuenta.addEventListener("change", function () {
            if (this.value === "usuario") {
                window.location.href = "http://localhost/G3_SC502_VN_Proyecto/app/View/auth/registro.php";
            } else {
                window.location.href = "http://localhost/G3_SC502_VN_Proyecto/app/View/auth/registro_profecional.php";
            }
        });
    }
   
});
