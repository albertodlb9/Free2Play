let listaJuegos;
document.addEventListener("DOMContentLoaded", () => {
  fetch("http://localhost:8080/api/videojuegos")
    .then(response => response.json())
    .then(data =>{
    listaJuegos = data; // Guardar la lista de juegos en una variable global
     mostrarJuegos(data)
    })
    .catch(error => console.error("Error al cargar videojuegos:", error));
});

function mostrarJuegos(juegos) {
  const contenedor = document.querySelector(".juegos-grid");

  juegos.forEach(juego => {
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

    contenedor.appendChild(tarjeta);

    tarjeta.addEventListener("click", () => {
        let idJuego = juego.id;
        window.location.href = `http://localhost:8080/videojuego/${idJuego}`;
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





