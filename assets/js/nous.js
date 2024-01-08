$(document).ready(function() {
  // Empêcher le défilement horizontal sur les appareils tactiles
  document.addEventListener('touchmove', function(e) {
    if (e.touches.length === 2) {
      e.preventDefault();
    }
  });

  // Le reste de votre code pour détecter le défilement vertical et ajouter/supprimer la classe "active" aux éléments ciblés
  const slidingNewsletter = document.querySelector('.nousanim');
  if (slidingNewsletter) {
    window.addEventListener('scroll', () => {
      const { scrollTop, clientHeight } = document.documentElement;
      const topElementToTopViewport = slidingNewsletter.getBoundingClientRect().top;

      if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
        slidingNewsletter.classList.add('active');
      } else {
        slidingNewsletter.classList.remove('active');
      }
    });
  }

  const nousanimG = document.querySelector('.nousanimG');
  if (nousanimG) {
    window.addEventListener('scroll', () => {
      const { scrollTop, clientHeight } = document.documentElement;
      const topElementToTopViewport = nousanimG.getBoundingClientRect().top;

      if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
        nousanimG.classList.add('active');
      } else {
        nousanimG.classList.remove('active');
      }
    });
  }

  const nousanimGa = document.querySelector('.nousanimGa');
  if (nousanimGa) {
    window.addEventListener('scroll', () => {
      const { scrollTop, clientHeight } = document.documentElement;
      const topElementToTopViewport =  nousanimGa.getBoundingClientRect().top;

      if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          nousanimGa.classList.add('active');
      } else {
          nousanimGa.classList.remove('active');
      }
    });
  }
});
