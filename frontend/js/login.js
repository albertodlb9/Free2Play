const formulario = document.getElementById("formularioLogin");
const errorMensaje = document.getElementById("errorMensaje");

formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    errorMensaje.style.display = "none";
    errorMensaje.textContent = "";

    const formData = new FormData(formulario);

    fetch("http://localhost:8080/api/usuarios/login", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.error) {
            errorMensaje.style.display = "block";
            errorMensaje.textContent = data.error;
        } else {
            window.location.href = "http://localhost:8080/";
        }
    })
    .catch(error => {
        errorMensaje.style.display = "block";
        errorMensaje.textContent = "Error al iniciar sesión. Por favor, inténtalo de nuevo.";
        console.error("Error en la solicitud:", error);
    });
}
);
