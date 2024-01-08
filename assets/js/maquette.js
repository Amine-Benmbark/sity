import { fabric } from 'fabric';

document.addEventListener("DOMContentLoaded", function () {
  const canvas = new fabric.Canvas('designCanvas');
  const rectangleButton = document.getElementById('rectangle');
  const cercleButton = document.getElementById('cercle');
  const texteButton = document.getElementById('texte');

  function createShapeWithColor(color, shapeType) {
    let shape;

    if (shapeType === 'rectangle') {
      shape = new fabric.Rect({
        left: 10,
        top: 10,
        width: 100,
        height: 100,
        fill: color
      });
    } else if (shapeType === 'circle') {
      shape = new fabric.Circle({
        left: 50,
        top: 50,
        radius: 25,
        fill: color
      });
    }

    canvas.add(shape);

    shape.on('mousedown', function (event) {
      if (event.button === 2) {
        showShapeContextMenu(shape, event.e.clientX, event.e.clientY);
      }
    });
  }

  // Fonction pour créer une palette de couleurs
  function showColorPicker(callback, shapeType) {
    const colorInput = document.createElement('input');
    colorInput.type = 'color';
    colorInput.addEventListener('input', function () {
      callback(colorInput.value, shapeType);
      document.body.removeChild(colorInput);
    });

    document.body.appendChild(colorInput);
    colorInput.click();
  }

  function showShapeContextMenu(shape, x, y) {
    const contextMenu = [
      { name: 'Modifier', action: () => handleEdit(shape) },
      { name: 'Supprimer', action: () => handleDelete(shape) }
    ];

    showContextMenu(contextMenu, x, y);
  }

  function handleEdit(shape) {
    const newColor = prompt('Modifier la couleur :', shape.fill);
    if (newColor) {
      shape.set('fill', newColor);
      canvas.renderAll();
    }
  }

  function handleDelete(shape) {
    canvas.remove(shape);
    hideContextMenu();
  }

  function showContextMenu(options, x, y) {
    hideContextMenu();

    const contextMenuDiv = document.createElement('div');
    contextMenuDiv.id = 'contextMenu';
    contextMenuDiv.style.position = 'absolute';
    contextMenuDiv.style.left = x + 'px';
    contextMenuDiv.style.top = y + 'px';
    contextMenuDiv.style.backgroundColor = '#fff';
    contextMenuDiv.style.border = '1px solid #ccc';
    contextMenuDiv.style.padding = '5px';

    options.forEach(option => {
      const menuItem = document.createElement('div');
      menuItem.textContent = option.name;
      menuItem.style.cursor = 'pointer';

      menuItem.addEventListener('click', function () {
        option.action();
        hideContextMenu();
      });

      contextMenuDiv.appendChild(menuItem);
    });

    document.body.appendChild(contextMenuDiv);
  }

  function hideContextMenu() {
    const contextMenu = document.getElementById('contextMenu');
    if (contextMenu) {
      contextMenu.parentNode.removeChild(contextMenu);
    }
  }

  rectangleButton.addEventListener('click', function () {
    showColorPicker(function (chosenColor) {
      createShapeWithColor(chosenColor, 'rectangle');
    }, 'rectangle');
  });

  cercleButton.addEventListener('click', function () {
    showColorPicker(function (chosenColor) {
      createShapeWithColor(chosenColor, 'circle');
    }, 'circle');
  });

  texteButton.addEventListener('click', function () {
    showColorPicker(function (chosenColor) {
      const userInput = prompt('Entrez le texte :');

      if (userInput) {
        const fontInput = prompt('Entrez la police (par exemple: Arial):');
        const fontSizeInput = prompt('Entrez la taille de la police (par exemple: 20):');

        if (fontInput && fontSizeInput) {
          const text = new fabric.Text(userInput, {
            left: 150,
            top: 10,
            fill: chosenColor,
            fontFamily: fontInput,
            fontSize: parseInt(fontSizeInput),
            selectable: true
          });
          canvas.add(text);

          canvas.on('mouse:up', function (event) {
            const selectedObject = event.target;
            if (selectedObject && selectedObject.type === 'text') {
              const contextMenu = [
                { name: 'Modifier', action: () => handleEdit(selectedObject) },
                { name: 'Supprimer', action: () => handleDelete(selectedObject) }
              ];

              showContextMenu(contextMenu, event.e.clientX, event.e.clientY);
            }
          });
        } else {
          alert('Veuillez fournir une police et une taille de police valides.');
        }
      }
    });
  });

});