document.getElementById("formularioRegistro").addEventListener("submit", (e) => {
  e.preventDefault();

  const form = document.getElementById("formularioRegistro");
  const formData = new FormData(form);

  fetch("http://localhost:8080/api/usuarios/store", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      document.getElementById("errorMensaje").textContent = data.error;
      document.getElementById("errorMensaje").style.display = "block";
    } else {
      console.log("Registro exitoso:", data);
    }
  })
  .catch(error => {
    console.error("Error en el registro:", error);
    document.getElementById("errorMensaje").textContent = "Error en el registro.";
    document.getElementById("errorMensaje").style.display = "block";
  });
});