const nav = document.getElementById('pronav');

const changeNavColor = () => {
  if (window.pageY > 100) {
    nav.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    nav.style.boxShadow = '0px 1px 4px black';
  } else {
    nav.style.backgroundColor = 'rgba(0, 0, 0, 0)';
    nav.style.boxShadow = 'none';
  }
};

window.addEventListener('scroll', changeNavColor);
