// $(document).ready(function() {
//     alert('coucou');
// })

function chiffre() {
    const slidingNewsletter = document.querySelector('.chiffredaffairetext');
  
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
chiffre();  