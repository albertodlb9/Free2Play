let listaJuegos;
let usuario;

document.addEventListener("DOMContentLoaded", () => {
  const juegosFetch = fetch("http://localhost:8080/api/videojuegos")
    .then(response => response.json());

  const usuarioFetch = fetch("http://localhost:8080/api/usuarios/loged", {
    credentials: "include"
  }).then(response => {
    if (!response.ok) {
      return { error: "No logueado" };
    }
    return response.json();
  });

  Promise.all([juegosFetch, usuarioFetch])
    .then(([juegos, userData]) => {
      listaJuegos = juegos;
      if (!userData.error) {
        usuario = userData;

        let login = document.querySelector(".link-login");
        let registro = document.querySelector(".link-registro");
        let navLinks = document.querySelector(".nav-links");

        if(usuario.rol === "admin"){
          let nuevoJuegoLink = document.createElement("a");
          let liNuevoJuego = document.createElement("li");
          nuevoJuegoLink.href = "http://localhost:8080/nuevoJuego";
          nuevoJuegoLink.textContent = "Nuevo Juego";
          liNuevoJuego.classList.add("link-nuevo-juego");
          liNuevoJuego.appendChild(nuevoJuegoLink);
          navLinks.appendChild(liNuevoJuego);
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
        navLinks.appendChild(li); 
        liLogout.appendChild(logout);
        navLinks.appendChild(liLogout);

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
        usuario = null;

        let login = document.querySelector(".link-login");
        let registro = document.querySelector(".link-registro");
        login.style.display = "block"; 
        registro.style.display = "block"; 

        let liLogout = document.querySelector(".link-logout");
        let liUsuario = document.querySelector(".link-usuario");
        if (liLogout) liLogout.remove();
        if (liUsuario) liUsuario.remove();
      }

      mostrarJuegos(listaJuegos, usuario);
    })
    .catch(error => console.error("Error en carga inicial:", error));
});

function mostrarJuegos(juegos, usuario) {
  const contenedor = document.querySelector(".juegos-grid");
  contenedor.innerHTML = "";

  juegos.forEach(juego => {
    let divGrande = document.createElement("div");
    let tarjeta = document.createElement("div");
    tarjeta.classList.add("juego-tarjeta");

    let img = document.createElement("img");
    img.src = juego.portada;
    img.alt = juego.titulo;

    let titulo = document.createElement("h4");
    titulo.textContent = juego.titulo;

    let fecha = document.createElement("p");
    fecha.textContent = juego.fecha_lanzamiento;

    let estrellas = crearEstrellas(juego.nota_media);

    tarjeta.appendChild(img);
    tarjeta.appendChild(titulo);
    tarjeta.appendChild(fecha);
    tarjeta.appendChild(estrellas);
    contenedor.appendChild(divGrande);
    divGrande.appendChild(tarjeta);

    if(usuario && usuario.rol === "admin") {
      let eliminarLink = document.createElement("a");
      eliminarLink.textContent = "Eliminar";
      eliminarLink.classList.add("eliminar-juego");
      divGrande.appendChild(eliminarLink);
      eliminarLink.addEventListener("click", (e) => {
        e.preventDefault();
        let formData = new FormData();
        formData.append("_method", "DELETE");
        fetch(`http://localhost:8080/api/videojuegos/${juego.id}`, {
          method: "POST",
          credentials: "include",
          body: formData
        })
        .then(response => {
          if (response.ok) {
            tarjeta.remove();
            divGrande.remove();
            console.log(`Juego ${juego.titulo} eliminado correctamente`);
          } else {
            console.error("Error al eliminar el juego");
          }
        })
        .catch(error => console.error("Error en la solicitud de eliminación del juego:", error));
      });
    }

    tarjeta.addEventListener("click", () => {
      let idJuego = juego.id;
      window.location.href = `http://localhost:8080/videojuego?id=${idJuego}`;
    });
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
