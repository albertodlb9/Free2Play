const formulario = document.getElementById("formularioLogin");
const errorMensaje = document.getElementById("errorMensaje");

formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    errorMensaje.style.display = "none";  // Oculta error previo
    errorMensaje.textContent = "";

    const formData = new FormData(formulario);

    fetch("http://localhost:8080/api/usuarios/login", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(function (response) {
        if (response.ok) {
            //window.location.href = "http://localhost:8080/";
            response.json().then(function (data) {
                console.log("Inicio de sesión exitoso:", data);
            });
        } else {
            return response.json().then(function (errorData) {
                errorMensaje.textContent = errorData.message || "Error al iniciar sesión";
                errorMensaje.style.display = "block";
                throw new Error(errorData.message);
            });
        }
    })
    
    .catch(function (error) {
        console.error("Error de red:", error);
        if (!errorMensaje.textContent) {
            errorMensaje.textContent = "Error de red. Por favor, inténtalo de nuevo más tarde.";
            errorMensaje.style.display = "block";
        }
    });
});
