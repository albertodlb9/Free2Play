let usuario = null;

document.addEventListener("DOMContentLoaded", () => {
  fetch("http://localhost:8080/api/usuarios/loged", {
      credentials: "include"
    })
    .then(response => {
      return response.json()
    })
    .then(data => {
      if (data.message) {
        console.error("Error al verificar sesión:", data.message);
        window.location.href = "http://localhost:8080/login";
      } else {
        usuario = data;
        if(usuario){
          let login = document.querySelector(".link-login");
          let registro = document.querySelector(".link-registro");
          let busqueda = document.querySelector(".buscador");
          let navLinks = document.querySelector(".nav-links");

          login.style.display = "none"; 
          registro.style.display = "none"; 
          let usuarioLink = document.createElement("a");
          let li = document.createElement("li");
          let avatar = document.createElement("img");
          avatar.src = "http://localhost:8080/api/avatars/"+usuario.avatar;
          avatar.classList.add("avatar");

          let logout = document.createElement("a");
          let liLogout = document.createElement("li");
          logout.textContent = "Cerrar sesión";
          liLogout.classList.add("link-logout");
          usuarioLink.href = "http://localhost:8080/perfil";
          usuarioLink.textContent = usuario.nombre_usuario;
          li.classList.add("link-usuario");
          li.appendChild(usuarioLink);
          li.appendChild(avatar);
          navLinks.insertBefore(li, busqueda); 
          liLogout.appendChild(logout);
          navLinks.insertBefore(liLogout, busqueda);

          fetch("http://localhost:8080/api/desarrolladores",{
            method: "GET",
            credentials: "include"
          })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error al obtener desarrolladores");
                }
                })
            .then(data => {
                if (data.error) {
                    console.error("Error al obtener desarrolladores:", data.error);
                } else {
                    let selectDesarrollador = document.querySelector("#desarrolladorId");
                    data.forEach(desarrollador => {
                        let option = document.createElement("option");
                        option.value = desarrollador.id;
                        option.textContent = desarrollador.nombre;
                        selectDesarrollador.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error("Error en la solicitud de desarrolladores:", error);
            });

            fetch("http://localhost:8080/api/plataformas",{
            method: "GET",
            credentials: "include"
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error al obtener plataformas");
                }
            })
            .then(data => {
                if (data.error) {
                    console.error("Error al obtener plataformas:", data.error);
                } else {
                    let selectPlataforma = document.querySelector("#plataformaId");
                    data.forEach(plataforma => {
                        let option = document.createElement("option");
                        option.value = plataforma.id;
                        option.textContent = plataforma.nombre;
                        selectPlataforma.appendChild(option);
                    });
                }
            })

          let formulario = document.querySelector("#formularioVideojuego");


        formulario.addEventListener("submit", (e) => {
        e.preventDefault();
        let formData = new FormData(formulario);
        
        fetch("http://localhost:8080/api/videojuegos/store", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
        .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("Error al crear el videojuego");
        }
        })
        .then(data => {
            console.log(data);
        if (data.error) {
            console.error("Error al crear el videojuego:", data.error);
        } else {
            console.log("videojuego creada correctamente");
            window.location.href = "http://localhost:8080/videojuegos";
        }
        })
        .catch(error => {
        console.error("Error en la solicitud de creación de el videojuego:", error);
        });
        });

          logout.addEventListener("click", (e) => {
            e.preventDefault();
            logout.style.cursor = "pointer";
            fetch("http://localhost:8080/api/usuarios/logout", {
              method: "POST",
              credentials: "include"
            })
            .then(response => {
              if (response.ok) {
                window.location.href = "http://localhost:8080/";
              } else {
                console.error("Error al cerrar sesión");
              }
            })
            .catch(error => console.error("Error en la solicitud de cierre de sesión:", error));
          });
        } else {
          let login = document.querySelector(".link-login");
          let registro = document.querySelector(".link-registro");
          login.style.display = "block"; 
          registro.style.display = "block"; 

          let liLogout = document.querySelector(".link-logout");
          let liUsuario = document.querySelector(".link-usuario");
          if (liLogout) {
            liLogout.remove();
          }
          if (liUsuario) {
            liUsuario.remove();
          }
        }
      }
    })
    .catch(error =>{ 
      console.error(error)  
    });
}
);
