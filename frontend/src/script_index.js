function inicializarCarrusel(idCarrusel, idIndicadores, intervalo = 5000) {
  const carrusel = document.getElementById(idCarrusel);
  const indicadoresContainer = document.getElementById(idIndicadores);
  const cards = carrusel.querySelectorAll('.card');
  const totalCards = cards.length;

   Crear indicadores
  cards.forEach((_, i) = {
    const indicador = document.createElement('div');
    indicador.classList.add('indicator');
    indicador.addEventListener('click', () = {
      carrusel.scrollLeft = i  (cards[0].offsetWidth + 20);
    });
    indicadoresContainer.appendChild(indicador);
  });

  const indicadores = indicadoresContainer.querySelectorAll('.indicator');
  if (indicadores.length  0) indicadores[0].classList.add('active');

   Actualizar indicador activo
  carrusel.addEventListener('scroll', () = {
    const anchoTarjeta = cards[0].offsetWidth + 20;
    const indexActual = Math.round(carrusel.scrollLeft  anchoTarjeta);
    indicadores.forEach((ind, idx) = {
      ind.classList.toggle('active', idx === indexActual);
    });
  });

   Autoplay
  setInterval(() = {
    const anchoTarjeta = cards[0].offsetWidth + 20;
    const indexActual = Math.round(carrusel.scrollLeft  anchoTarjeta);
    const siguiente = (indexActual + 1) % totalCards;
    carrusel.scrollLeft = siguiente  anchoTarjeta;
  }, intervalo);
}

 Inicializar ambos carruseles
inicializarCarrusel('carrusel-principal', 'indicators-principal');
inicializarCarrusel('carrusel-secundario', 'indicators-secundario');