let listaJuegos;
let usuario;
document.addEventListener("DOMContentLoaded", () => {
  fetch("http://localhost:8080/api/videojuegos/videojuegosMasValorados")
    .then(response => response.json())
    .then(data =>{
    listaJuegos = data;
     mostrarJuegos(data)
    })
    .catch(error => console.error("Error al cargar videojuegos:", error));

    fetch("http://localhost:8080/api/usuarios/loged", {
      credentials: "include"
    })
    .then(response => {
      if (!response.ok) {
        throw new Error("Error al verificar sesión");
      }
      return response.json()
    })
    .then(data => {
      if (data.error) {
        console.error("Error al verificar sesión:", data.error);
      } else {
        usuario = data;
        if(usuario){
          let login = document.querySelector(".link-login");
          let registro = document.querySelector(".link-registro");
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
    .catch(error => console.error(error));
});

function mostrarJuegos(juegos) {
  const contenedor = document.querySelector(".juegos-grid");

  for (let i = 0; i < 4; i++) {
    let tarjeta = document.createElement("div");
    tarjeta.classList.add("juego-tarjeta");

    let img = document.createElement("img");
    img.src = juegos[i].portada;
    img.alt = juegos[i].titulo;

    let titulo = document.createElement("h4");
    titulo.textContent = juegos[i].titulo;

    let fecha = document.createElement("p");
    fecha.textContent = juegos[i].fecha_lanzamiento;

    let estrellas = crearEstrellas(juegos[i].nota_media);

    tarjeta.appendChild(img);
    tarjeta.appendChild(titulo);
    tarjeta.appendChild(fecha);
    tarjeta.appendChild(estrellas);

    contenedor.appendChild(tarjeta);

    tarjeta.addEventListener("click", () => {
        let idJuego = juegos[i].id;
        window.location.href = `http://localhost:8080/videojuego?id=${idJuego}`;
    });
  };
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




