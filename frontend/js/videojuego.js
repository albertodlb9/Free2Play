let usuario=null;
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
        cargarReviews(idVideojuego);
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
          cargarReviews(idVideojuego);
        } else {
          console.log("No hay usuario logueado");
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

    
});
    const contenedorDetalles = document.querySelector(".detalle-videojuego");
    const params = new URLSearchParams(window.location.search);
    const idVideojuego = params.get("id");
    if (contenedorDetalles) {
    fetch(`http://localhost:8080/api/videojuegos/${idVideojuego}`)
        .then(response => {
        return response.json();
        })
        .then(videojuego => {
          console.log("Videojuego:", videojuego);
        const titulo = document.createElement("h2");
        titulo.textContent = videojuego.titulo;

        const imagen = document.createElement("img");
        imagen.src = videojuego.portada;
        imagen.alt = videojuego.titulo;
        imagen.style.maxWidth = "300px";

        const tituloDescripcion = document.createElement("h3");
        tituloDescripcion.textContent = "Descripción";

        const descripcion = document.createElement("p");
        descripcion.textContent = videojuego.descripcion;

        const año = document.createElement("p");
        año.textContent = `Año de lanzamiento: ${videojuego.fecha_lanzamiento}`;

        const plataforma = document.createElement("p");
        plataforma.textContent = `Plataforma: ${videojuego.plataforma_nombre}`;

        const desarrollador = document.createElement("p");
        desarrollador.textContent = `Desarrollador: ${videojuego.desarrollador_nombre}`;

        const notaMedia = crearEstrellas(videojuego.nota_media);

        const nuevaReview = document.createElement("button");
        nuevaReview.textContent = "Nueva Review";
        nuevaReview.classList.add("nueva-review");
        nuevaReview.addEventListener("click", () => {
            window.location.href = `http://localhost:8080/nuevaReview?videojuegoId=${videojuego.id}`;
        });
        contenedorDetalles.appendChild(nuevaReview);
        

        contenedorDetalles.appendChild(titulo);
        contenedorDetalles.appendChild(imagen);
        contenedorDetalles.appendChild(tituloDescripcion);
        contenedorDetalles.appendChild(descripcion);
        contenedorDetalles.appendChild(año);
        contenedorDetalles.appendChild(plataforma);
        contenedorDetalles.appendChild(desarrollador);
        contenedorDetalles.appendChild(notaMedia);
        })
        .catch(error => {
        console.error("Error al cargar detalles del videojuego:", error);
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
    
      function cargarReviews(idVideojuego) {
        const contenedor = document.querySelector(".contenedor-reviews");
        if (contenedor) {
          fetch(`http://localhost:8080/api/reviews/videojuego/${idVideojuego}`)
              .then(response => {
                  return response.json();
              })
              .then(reviews => {
                reviews.forEach(review => {
                  const div = document.createElement("div");
                  div.classList.add("review");

                  const nombreUsuario = document.createElement("h4");
                  nombreUsuario.textContent = review.nombre_usuario;

                  const titulo = document.createElement("h3");
                  titulo.textContent = review.titulo;

                  const nota = crearEstrellas(review.puntuacion);

                  const comentario = document.createElement("p");
                  comentario.textContent = review.contenido;

                  if (usuario.rol === "admin" || (usuario.id && review.usuario_id === usuario.id)) {
                    const divBoton = document.createElement("div");
                    divBoton.classList.add("botonDeleteContainer");

                    const deleteButton = document.createElement("button");
                    deleteButton.textContent = "Eliminar";
                    deleteButton.classList.add("botonDelete");
                    deleteButton.addEventListener("click", () => {
                      let formulario = new FormData();
                      formulario.append("_method", "DELETE");
                       fetch(`http://localhost:8080/api/reviews/${review.id}`, {
                        method: "POST",
                        credentials: "include",
                        body: formulario
                       })
                        .then(response => {
                          if (response.ok) {
                            div.remove();
                          } else {
                            console.error("Error al eliminar la review");
                          }
                        })
                        .catch(error => {
                          console.error("Error en la solicitud de eliminación de la review:", error);
                        });

                    });
                    divBoton.appendChild(deleteButton);
                    div.appendChild(divBoton);
                  }

                  div.appendChild(titulo);
                  div.appendChild(nombreUsuario);
                  div.appendChild(nota);
                  div.appendChild(comentario);
                  contenedor.appendChild(div);

                  titulo.addEventListener("click", () => {
                    window.location.href = `http://localhost:8080/review?id=${review.id}`;
                  });
                  titulo.style.cursor = "pointer";
                });

              })
          .catch(error => {
            console.error("Error cargando reviews:", error);
          });
        }
      }
