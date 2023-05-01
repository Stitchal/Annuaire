let bar = document.querySelector('.bars'),
    navItem = document.querySelector('.nav-items');

bar.addEventListener('click', () => {
    navItem.classList.toggle('active');
})

var select = document.getElementById("mon-select");

// Récupère la valeur de l'option sélectionnée
var selectedOption = select.options[select.selectedIndex].value;
selectedOption.setC

// Affiche la valeur dans la console
console.log("Option sélectionnée : " + selectedOption);