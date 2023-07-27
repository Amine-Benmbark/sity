
$(document).ready(function() {
    const slidingNewsletter = document.querySelector('.nousanim');
    window.addEventListener('scroll', () => {
      const { scrollTop, clientHeight } = document.documentElement;
      const topElementToTopViewport = slidingNewsletter.getBoundingClientRect().top;
  
      if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
        slidingNewsletter.classList.add('active');
      } else {
        slidingNewsletter.classList.remove('active');
      }
    });

    const nousanimG = document.querySelector('.nousanimG');
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = nousanimG.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          nousanimG.classList.add('active');
        } else {
          nousanimG.classList.remove('active');
        }
      });

      const nousanimGa = document.querySelector('.nousanimGa');
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport =  nousanimGa.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
            nousanimGa.classList.add('active');
        } else {
            nousanimGa.classList.remove('active');
        }
      });
});