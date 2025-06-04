let usuario = null;

const params = new URLSearchParams(window.location.search);
let idDesarrollador = params.get("id");

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

          if(usuario.rol === "admin"){
            let usuariosLink = document.createElement("a");
            let liUsuarios = document.createElement("li");
            usuariosLink.href = "http://localhost:8080/usuarios";
            usuariosLink.textContent = "Gestion Usuarios";
            liUsuarios.classList.add("link-usuarios");
            liUsuarios.appendChild(usuariosLink);
            navLinks.insertBefore(liUsuarios, busqueda);
            let plataformasLink = document.createElement("a");
            let liPlataformas = document.createElement("li");
            plataformasLink.href = "http://localhost:8080/plataformas";
            plataformasLink.textContent = "Gestion Plataformas";
            liPlataformas.classList.add("link-plataformas");
            liPlataformas.appendChild(plataformasLink);
            navLinks.insertBefore(liPlataformas, busqueda);
            let desarrolladorasLink = document.createElement("a");
            let liDesarrolladoras = document.createElement("li");
            desarrolladorasLink.href = "http://localhost:8080/desarrolladores";
            desarrolladorasLink.textContent = "Gestion Desarrolladores";
            liDesarrolladoras.classList.add("link-desarrolladores");
            liDesarrolladoras.appendChild(desarrolladorasLink);
            navLinks.insertBefore(liDesarrolladoras, busqueda);
          }

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

          let formulario = document.querySelector(".formularioDesarrollador");
          
          if(idDesarrollador){
            fetch(`http://localhost:8080/api/desarrolladores/${idDesarrollador}`, {
                credentials: "include",
                method: "GET"
            })
            .then(response => {

                return response.json();
            })
            .then(data => {
                console.log(data);
                formulario.querySelector("#nombre").value = data.nombre;
                formulario.querySelector("#pais").value = data.pais; 
            }
            )
            .catch(error => {
                console.error("Error al cargar el desarrollador:", error);
            });
        }

            if(idDesarrollador){
                formulario.addEventListener("submit", (e) => {
                e.preventDefault();
                let formulario = document.querySelector(".formularioDesarrollador");
                let formData = new FormData(formulario);
                formData.append("_method", "PUT");
                
                fetch("http://localhost:8080/api/desarrolladores/"+idDesarrollador, {
                method: "POST",
                body: formData,
                credentials: "include"
                })
                .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error al actualizar el perfil");
                }
                })
                .then(data => {
                    console.log(data);
                    if (data.error) {
                        console.error("Error al actualizar el perfil:", data.error);
                    } else {
                        console.log("Perfil actualizado correctamente");
                    }
                })
                .catch(error => {
                    console.error("Error en la solicitud de actualización del perfil:", error);
                });
                });
            } else {
                formulario.addEventListener("submit", (e) => {
                    e.preventDefault();
                    let formulario = document.querySelector(".formularioDesarrollador");
                    let formData = new FormData(formulario);
                    
                    fetch("http://localhost:8080/api/desarrolladores/store", {
                    method: "POST",
                    body: formData,
                    credentials: "include"
                    })
                    .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error("Error al crear el desarrollador");
                    }
                    })
                    .then(data => {
                    console.log(data);
                    if (data.error) {
                        console.error("Error al crear el desarrollador:", data.error);
                    } else {
                        console.log("Plataforma creada correctamente");
                        window.location.href = "http://localhost:8080/desarrolladores";
                    }
                    })
                    .catch(error => {
                    console.error("Error en la solicitud de creación de el desarrollador:", error);
                    });
                });
            }

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