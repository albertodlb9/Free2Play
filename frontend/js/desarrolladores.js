let usuario = null;

document.addEventListener("DOMContentLoaded", () => {
  fetch("http://localhost:8080/api/usuarios/loged", {
      credentials: "include"
    })
    .then(response => {
      return response.json()
    })
    .then(data => {
      if (data.error) {
        console.error("Error al verificar sesión:", data.error);
        window.location.href = "http://localhost:8080/login";
      } else {
        usuario = data;
        if(!(usuario.rol === "admin")){
            window.location.href = "http://localhost:8080/";
        }
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

          fetch("http://localhost:8080/api/desarrolladores", {
            credentials: "include"
          })
          .then(response => response.json())
          .then(desarrolladores => {
            if (desarrolladores.error) {
              console.error("Error al cargar desarrolladores:", desarrolladores.error);
            } else {
                
              let desarrolladoresList = document.querySelector("#desarrolladoresTabla");
                desarrolladoresList.innerHTML = "";
                desarrolladores.forEach(desarrollador => {
                let row = document.createElement("tr");
                let  id = document.createElement("td");
                id.textContent = desarrollador.id;
                row.appendChild(id);
                let nombreDesarrollador = document.createElement("td");
                nombreDesarrollador.textContent = desarrollador.nombre;
                row.appendChild(nombreDesarrollador);
                let pais = document.createElement("td");
                pais.textContent = desarrollador.pais;
                row.appendChild(pais);
                let acciones = document.createElement("td");
                let editarLink = document.createElement("a");
                editarLink.href = `http://localhost:8080/desarrollador?id=${desarrollador.id}`;
                editarLink.textContent = "Editar";
                editarLink.classList.add("editar-desarrollador");
                let eliminarLink = document.createElement("a");
                eliminarLink.textContent = "Eliminar";
                eliminarLink.classList.add("eliminar-desarrollador");
                acciones.appendChild(editarLink);
                acciones.appendChild(eliminarLink);
                row.appendChild(acciones);
                desarrolladoresList.appendChild(row);
                eliminarLink.addEventListener("click", (e) => {
                  e.preventDefault();      
                  let formData = new FormData();
                    formData.append("_method", "DELETE");  
                    fetch(`http://localhost:8080/api/desarrolladores/${desarrollador.id}`, {
                      method: "POST",
                      credentials: "include",
                      body: formData
                    })
                    .then(response => {
                      if (response.ok) {
                        row.remove();
                        console.log(`desarrollador ${desarrollador.nombre} eliminado correctamente`);
                      } else {
                        console.error("Error al eliminar el desarrollador");
                      }
                    })
                    .catch(error => console.error("Error en la solicitud de eliminación del desarrollador:", error));
                  });   
                });
                    let contenedorDesarrolladores = document.querySelector(".contenedor-desarrolladores");
                    let nuevoDesarrollador = document.createElement("a");
                    nuevoDesarrollador.href = "http://localhost:8080/desarrollador";
                    nuevoDesarrollador.textContent = "Nuevo Desarrollador";
                    nuevoDesarrollador.classList.add("nuevo-desarrollador");
                    contenedorDesarrolladores.appendChild(nuevoDesarrollador);

            }
          })
          .catch(error => console.error("Error al cargar plataformas:", error));
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