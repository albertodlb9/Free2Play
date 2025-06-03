let usuario=null;
const contenedorReview = document.querySelector(".review-container");
const params = new URLSearchParams(window.location.search);
const idReview = params.get("id");
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
        cargarComentarios(idReview);
      } else {
        usuario = data;
        if(usuario){
          let login = document.querySelector(".link-login");
          let registro = document.querySelector(".link-registro");
          let busqueda = document.querySelector(".buscador");
          let navLinks = document.querySelector(".nav-links");
          let escribirComentario = document.querySelector(".nuevoComentario");

          login.style.display = "none"; 
          registro.style.display = "none"; 
          let usuarioLink = document.createElement("a");
          let li = document.createElement("li");
          let avatar = document.createElement("img");
          avatar.src = "http://localhost:8080/api/avatars/"+usuario.avatar;
          avatar.classList.add("avatar");

          let logout = document.createElement("a");
          let liLogout = document.createElement("li");
          let comentarioNuevo = document.createElement("a");
          comentarioNuevo.classList.add("botonComentario");
          comentarioNuevo.href = `http://localhost:8080/comentario?id=${idReview}`;
            comentarioNuevo.textContent = "Escribir comentario";
            escribirComentario.appendChild(comentarioNuevo);
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
          cargarComentarios(idReview);
        } else {
          let login = document.querySelector(".link-login");
          let registro = document.querySelector(".link-registro");
          let escribirComentario = document.querySelector(".nuevoComentario");
          escribirComentario.style.display = "none";
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

    
});
    
    if (contenedorReview) {
    fetch(`http://localhost:8080/api/reviews/${idReview}`)
        .then(response => {
        return response.json();
        })
        .then(review => {
            console.log(review);
                  const div = document.createElement("div");
                  div.classList.add("review");

                  const nombreUsuario = document.createElement("h4");
                  nombreUsuario.textContent = review.nombre_usuario;

                  const nota = crearEstrellas(review.puntuacion);

                  const comentario = document.createElement("p");
                  comentario.textContent = review.contenido;

                  div.appendChild(nombreUsuario);
                    div.appendChild(nota);
                    div.appendChild(comentario);
                    contenedorReview.appendChild(div);
    })
        .catch(error => {
        console.error("Error al cargar detalles de la review:", error);
        });

    
    }
   
    function crearEstrellas(nota) {
    const estrellas = document.createElement('div');
    estrellas.classList.add('estrellas');

    const maxEstrellas = 5;
    const entero = Math.floor(nota);
    const decimal = nota - entero;

    for(let i = 1; i <= maxEstrellas; i++) {
        const star = document.createElement('i');
        if(i <= entero) {
        star.className = 'fas fa-star';
        star.style.color = '#f5c518';
        } else if(i === entero + 1 && decimal >= 0.5) {
        star.className = 'fas fa-star-half-alt';
        star.style.color = '#f5c518';
        } else {
        star.className = 'far fa-star';
        star.style.color = '#888';
        }
        estrellas.appendChild(star);
    }
    return estrellas;
    }
    
    function cargarComentarios(idReview) {
        const contenedorComentarios = document.querySelector(".comentarios-container");
        if (contenedorComentarios) {
            fetch(`http://localhost:8080/api/comentarios/review/${idReview}`)
                .then(response => {
                    return response.json();
                })
                .then(comentarios => {
                    comentarios.forEach(comentario => {
                        const divComentario = document.createElement("div");
                        divComentario.classList.add("comentario");

                        const nombreUsuario = document.createElement("h5");
                        nombreUsuario.textContent = comentario.nombre_usuario;

                        const contenidoComentario = document.createElement("p");
                        contenidoComentario.textContent = comentario.contenido;

                        if (usuario && comentario.usuario_id === usuario.id) {
                            const botonEliminar = document.createElement("button");
                            botonEliminar.textContent = "Eliminar";
                            botonEliminar.classList.add("boton-eliminar");
                            botonEliminar.addEventListener("click", () => {
                                fetch(`http://localhost:8080/api/comentarios/${comentario.id}`, {
                                    method: "DELETE",
                                    credentials: "include"
                                })
                                .then(response => {
                                    if (response.ok) {
                                        divComentario.remove();
                                    } else {
                                        console.error("Error al eliminar el comentario");
                                    }
                                })
                                .catch(error => console.error("Error en la solicitud de eliminación:", error));
                            });
                            divComentario.appendChild(botonEliminar);
                        }

                        divComentario.appendChild(nombreUsuario);
                        divComentario.appendChild(contenidoComentario);
                        contenedorComentarios.appendChild(divComentario);
                    });
                })
                .catch(error => {
                    console.error("Error al cargar comentarios:", error);
                });
        }
    }