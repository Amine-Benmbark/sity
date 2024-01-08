// $(document).ready(function() {
//     alert('coucou');
// })

$(document).ready(function button_carousel() {
    const next = document.querySelector(".next");
    const previous = document.querySelector(".previous");
    const caroussel = document.querySelector(".caroussel-cards");
    let angle = 0;

    next.addEventListener("click", () => {angle -= 60;
    caroussel.style.transform = `translateZ(-25rem) rotateY(${angle}deg)`; });

    previous.addEventListener("click", () => {angle +=60;
    caroussel.style.transform = `translateZ(-25rem) rotateY(${angle}deg)`; });
})
button_carousel();