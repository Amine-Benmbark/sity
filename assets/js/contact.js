$(document).ready(function() {
    $(window).scroll(function() {
      const contactverif = document.querySelector('.contactverif');
      if(contactverif){
      // Récupérer la position de l'élément par rapport au haut de la page
      var elementPosition = $('#elementToZoom').offset().top;
      if (elementPosition) {

      // Récupérer la position actuelle du scroll
      var scrollPosition = $(window).scrollTop();
      
      // Si la position de l'élément est visible dans la fenêtre
      if (elementPosition - scrollPosition < $(window).height()) {
        // Calculer le facteur d'agrandissement en fonction de la position du scroll
        var scale = 1 + (scrollPosition - elementPosition + $(window).height()) / 1000;
        // Appliquer la transformation de mise à l'échelle
        scale = Math.min(scale, 1.3);
        $('#elementToZoom').css('transform', 'scale(' + scale + ')');
      }
    }
  }
    });
});
  

