function Categorie() {
    const slidingNewsletter = document.querySelector('#un');
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

    const deux = document.querySelector('#deux');
    if(deux){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = deux.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          deux.classList.add('active');
        } else {
          deux.classList.remove('active');
        }
      });
    }

      const trois = document.querySelector('#trois');
      if(trois){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = trois.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          trois.classList.add('active');
        } else {
          trois.classList.remove('active');
        }
      });
    }


      const quatre = document.querySelector('#quatre');
      if(quatre){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = quatre.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          quatre.classList.add('active');
        } else {
          quatre.classList.remove('active');
        }
      });
    }

      const cinq = document.querySelector('#cinq');
      if(cinq){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = cinq.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
            cinq.classList.add('active');
        } else {
            cinq.classList.remove('active');
        }
      });
    }

      const six = document.querySelector('#six');
      if(six){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = six.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          six.classList.add('active');
        } else {
          six.classList.remove('active');
        }
      });
    }


      const sept = document.querySelector('#sept');
      if(sept){
      window.addEventListener('scroll', () => {
        const { scrollTop, clientHeight } = document.documentElement;
        const topElementToTopViewport = sept.getBoundingClientRect().top;
    
        if (scrollTop > (scrollTop + topElementToTopViewport).toFixed() - clientHeight * 0.9) {
          sept.classList.add('active');
        } else {
          sept.classList.remove('active');
        }
      });
    }
}

Categorie();