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

          fetch("http://localhost:8080/api/usuarios", {
            credentials: "include"
          })
          .then(response => response.json())
          .then(usuarios => {
            console.log("Usuarios cargados:", usuarios);
            if (usuarios.error) {
              console.error("Error al cargar usuarios:", usuarios.error);
            } else {
                
              let usuariosList = document.querySelector("#usuariosTabla");
              usuariosList.innerHTML = "";
              usuarios.forEach(usuario => {
                let row = document.createElement("tr");
                let  id = document.createElement("td");
                id.textContent = usuario.id;
                row.appendChild(id);
                let nombreUsuario = document.createElement("td");
                nombreUsuario.textContent = usuario.nombre_usuario;
                row.appendChild(nombreUsuario);
                let nombre = document.createElement("td");
                nombre.textContent = usuario.nombre;
                row.appendChild(nombre);
                let apellido1 = document.createElement("td");
                apellido1.textContent = usuario.apellido1;
                row.appendChild(apellido1);
                let apellido2 = document.createElement("td");
                apellido2.textContent = usuario.apellido2;
                row.appendChild(apellido2);
                let email = document.createElement("td");
                email.textContent = usuario.email;
                row.appendChild(email);
                let rol = document.createElement("td");
                rol.textContent = usuario.rol;
                row.appendChild(rol);
                let telefono = document.createElement("td");
                telefono.textContent = usuario.telefono;
                row.appendChild(telefono);
                let direccion = document.createElement("td");
                direccion.textContent = usuario.direccion;
                row.appendChild(direccion);
                let avatar = document.createElement("td");
                let avatarImg = document.createElement("img");
                avatarImg.src = `http://localhost:8080/api/avatars/${usuario.avatar}`;
                avatarImg.classList.add("avatar");
                avatar.appendChild(avatarImg);
                row.appendChild(avatar);
                let acciones = document.createElement("td");
                let editarLink = document.createElement("a");
                editarLink.href = `http://localhost:8080/perfil?id=${usuario.id}`;
                editarLink.textContent = "Editar";
                editarLink.classList.add("editar-usuario");
                let eliminarLink = document.createElement("a");
                eliminarLink.textContent = "Eliminar";
                eliminarLink.classList.add("eliminar-usuario");
                acciones.appendChild(editarLink);
                acciones.appendChild(eliminarLink);
                row.appendChild(acciones);
                usuariosList.appendChild(row);
                eliminarLink.addEventListener("click", (e) => {
                  e.preventDefault();        
                    fetch(`http://localhost:8080/api/usuarios/${usuario.id}`, {
                      method: "POST",
                      credentials: "include",
                      body: new FormData().append("_method", "DELETE")
                    })
                    .then(response => {
                      if (response.ok) {
                        row.remove();
                        console.log(`Usuario ${usuario.nombre_usuario} eliminado correctamente`);
                      } else {
                        console.error("Error al eliminar el usuario");
                      }
                    })
                    .catch(error => console.error("Error en la solicitud de eliminación del usuario:", error));
                  });
                });


            }
          })
          .catch(error => console.error("Error al cargar usuarios:", error));
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