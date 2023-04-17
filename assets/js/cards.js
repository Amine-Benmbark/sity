var content = document.getElementById('card_service').getElementsByTagName('div');
var zX = 1;

alert('okok');

window.addEventListener('wheel', function (e) {
    var dir;
    if (!e.ctrlKey) {
        return;
    }
    dir = (e.deltaY > 0) ? 0.1 : -0.1;
    zX += dir;
    for (var i = 0; i<content.length; i++) {
         content[i].style.transform = 'scale(' + zX + ')';
        }
        console.log("okokoko");
    e.preventDefault();
    return;
});

 