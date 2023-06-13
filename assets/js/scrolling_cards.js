// Fonction de gestion de l'observation
function handleIntersection(entries, observer) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate__animated', 'animate__zoomIn');
        observer.unobserve(entry.target);
      }
    });
  }
  
  // Fonction pour initialiser l'observateur lors du défilement
  function initIntersectionObserver() {
    // Création de l'observateur
    const observer = new IntersectionObserver(handleIntersection, {
      root: null,
      rootMargin: '0px',
      threshold: 0.5 // Définissez la valeur selon vos besoins
    });
  
    // Sélectionnez toutes les cartes
    const cards = document.querySelectorAll('.card');
  
    // Ajoutez chaque carte à l'observateur
    cards.forEach(card => {
      observer.observe(card);
    });
  }
  
  // Fonction pour vérifier la position des cartes lors du défilement
  function checkCardPosition() {
    const windowHeight = window.innerHeight;
    const cards = document.querySelectorAll('.card');
  
    cards.forEach(card => {
      const cardTop = card.getBoundingClientRect().top;
  
      if (cardTop < windowHeight * 0.8) {
        card.classList.add('animate__animated', 'animate__zoomIn');
      }
    });
  }
  
  // Événement de défilement de la fenêtre
  window.addEventListener('scroll', checkCardPosition);
  
  // Appel de la fonction d'initialisation de l'observateur
  initIntersectionObserver();
  