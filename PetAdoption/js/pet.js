const pets = [
    { "name": "Cody", "type": "Dog", "age": 1, "img": "../Image/dogs/dog01.jpg" },
    { "name": "Max", "type": "Dog", "age": 4, "img": "../Image/Golden-Retriever.jpg" },
    { "name": "Whiskers", "type": "Cat", "age": 2, "img": "../Image/cats/cat01.jpg" },
    { "name": "Mittens", "type": "Cat", "age": 2, "img": "../Image/cats/cat02.jpg" },
    { "name": "Coco", "type": "Bird", "age": 2, "img": "../Image/birds/bird01.jpg" },
    { "name": "Yoda", "type": "Dog", "age": 3, "img": "../Image/dogs/dog03.jpg" },
    { "name": "Goldie", "type": "Bird", "age": 1, "img": "../Image/birds/bird02.jpg" },
    { "name": "Melon", "type": "Capybara", "age": 5, "img": "../Image/capybaras/capybara01.jpg" },
    { "name": "Me", "type": "Capybara", "age": 4, "img": "../Image/capybaras/capybara02.jpg" },
];

function adoptPet() {
    window.location.href = "adoptPet.html";
}

function filterPets() {
    const selectedType = $('input[name="pet-type"]:checked').val();
    let filteredPets = pets;
    
    if (selectedType !== 'all') {
        filteredPets = pets.filter(pet => pet.type === selectedType);
    }
    
    renderPets(filteredPets);
}

function renderPets(filteredPets) {
    const $container = $('#pet-list');
    $container.empty();
    filteredPets.forEach(pet => {
        const petHTML = `
            <div class="pet">
                <img src="${pet.img}" alt="${pet.name}">
                <h3>${pet.name}</h3>
                <p>Type: ${pet.type}</p>
                <p>Age: ${pet.age} years</p>
                <button onclick="adoptPet()">Adopt Now</button>
            </div>
        `;
        $container.append(petHTML);
    });
}
$(document).ready(function () {
    renderPets(pets);
    $('input[name="pet-type"]').on('change', filterPets);
});