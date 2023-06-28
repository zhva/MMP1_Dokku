/*
This project was created as a part of the bachelor's degree in MultiMediaTechnology at Salzburg 
University of Applied Sciences.

It is a learning project and it does not pursue any commercial goals. All the images used in this project
were either created by Viktoriia Zhuravel, found on the internet under the Creative Commons NonCommercial 
license or provided by the Blizzard API (https://develop.battle.net/). All the rights for the images from 
Blizzard API or any resources affiliated with Hearthstone(TM) as well as any names and trademarks belong to 
Blizzard Entertainment, Inc.

MultiMediaProject 1 - Summer semester 2022

Design & Development: Viktoria Zhuravel */

function setEvents() {
    window.addEventListener('load', onPageLoad);  
}

function onPageLoad() {
    loadDecks();
}
function loadDecks() {
    fetch("functionality/getUserDecks.php")
    .then(response => {
        if(response.ok) {
            return response.json();
        }
        else {
            throw new Error('Some error occurred during login!');
        }
    })
    .then(function(decksJson) {
        let decks = decksJson.decks;
        for(let i = 0; i < decks.length; i++) {
            addDeckBlock(decks[i]); 
        }
    })
    .catch((error) => {
        console.log("Error!:", error);
    });
}
function addDeckBlock(deck) {
    let decksContainer = document.getElementById('userDecksContainerId');
    if(decksContainer === "") {
        return;
    }
    decksContainer.appendChild(createDeckBlock(deck));
}

function createDeckBlock(deck) {
    let divDeckContainer = document.createElement('div');
    divDeckContainer.classList.add("user-deck-container");
    let divInfo = document.createElement('div');
    divInfo.classList.add('user-deck-info-container');

    let divHex = document.createElement('div');
    divHex.classList.add('hex');

    let divHexBG = document.createElement('div');
    divHexBG.classList.add('hex-background');

    let img =  getClassImage(deck.classSlug);
    img.classList.add('clipped_img');
    img.alt = `Image of ${deck.name}`;
    divHexBG.appendChild(img);

    divHex.appendChild(divHexBG);
    divInfo.appendChild(divHex);

    let divName = document.createElement('div');
    divName.classList.add('user-deck-name-container');

    let pName = document.createElement('p');
    pName.textContent = deck.name;
    divName.appendChild(pName);

    let divRating = document.createElement('div');
    divRating.classList.add("rating");
    
    let rating = deck.rating;
    for(let i = 5; i > 0; i--) {
        let input = document.createElement('input');
        if(i === parseInt(rating)) {
            input.checked = true;
        }
        input.type = 'radio';
        input.name = deck.id + 'rating';
        input.id = deck.id + 'rating' + i;
        input.disabled = true;
        divRating.appendChild(input);

        let label = document.createElement('label');
        label.htmlFor = deck.id + 'rating' + i;
        divRating.appendChild(label)
    }
    divName.appendChild(divRating);
    divInfo.appendChild(divName);

    let span = document.createElement('span');
    span.textContent = deck.dustCost;
    divInfo.appendChild(span);

    let btnCode = document.createElement('input');
    btnCode.type = 'button';
    btnCode.value = 'Get Deck Code';
    btnCode.name = "deckCodeCopy";
    btnCode.id = 'getDeckCode' + deck.id;
    btnCode.addEventListener('click', onCopyDeckCode);
    divInfo.appendChild(btnCode);

    let btnEdit = document.createElement('input');
    btnEdit.classList.add('button-secondary');
    btnEdit.type = 'button';
    btnEdit.value = 'Edit';
    btnEdit.id = 'editDeck' + deck.id;
    btnEdit.addEventListener('click', onEditDeck);
    divInfo.appendChild(btnEdit);

    let btnDelete = document.createElement('input');
    btnDelete.classList.add('button-secondary');
    btnDelete.type = 'button';
    btnDelete.value = 'Delete';
    btnDelete.id = 'deleteDeck' + deck.id;
    btnDelete.addEventListener('click', onDeleteDeck);
    divInfo.appendChild(btnDelete);

    let deckCodeHidden = document.createElement('input');
    deckCodeHidden.type = 'hidden';
    deckCodeHidden.name = 'deckCode';
    deckCodeHidden.value = deck.code;
    divInfo.appendChild(deckCodeHidden);

    let deckClassHidden = document.createElement('input');
    deckClassHidden.type = 'hidden';
    deckClassHidden.name = 'deckClass';
    deckClassHidden.value = deck.classSlug;
    divInfo.appendChild(deckClassHidden);

    let deckIdHidden = document.createElement('input');
    deckIdHidden.type = 'hidden';
    deckIdHidden.name = 'deckId';
    deckIdHidden.value = deck.id;
    divInfo.appendChild(deckIdHidden);

    let divComment = document.createElement('div');
    divComment.classList.add('comment-container');

    let pComment = document.createElement('p');
    pComment.textContent = deck.description;
    divComment.appendChild(pComment);
    divDeckContainer.appendChild(divInfo);
    divDeckContainer.appendChild(divComment);

    return divDeckContainer;
}

function getClassImage(classSlug) {
    var icon = document.createElement('img');
    if(classSlug !== '')
    {
        icon.src = `./img/classIcons/${classSlug}.png`;
    }
    return icon;
}

function onEditDeck() {
    let container = this.parentNode;
    if(container !== null) {
        let deckClass = container.querySelector("input[name='deckClass']").value;
        let deckcode = encodeURIComponent(container.querySelector("input[name='deckCode']").value);

        window.location.href = `deckbuilder.php?class=${deckClass}&deckcode=${deckcode}`;
    }
}
function onDeleteDeck() {
    let btnContainer = this.parentNode;
    if(btnContainer !== null) {
        let deckId = btnContainer.querySelector("input[name='deckId']").value;
        let data = {deckId: deckId};
        fetch("functionality/deleteUserDeckFromDB.php", {
            method: "POST",
            headers: {'Content-Type': 'application/json'}, 
            body: JSON.stringify(data)
          })
          .then(response => {
            console.log("Deletion complete! response:", response);
            if(response.ok) {
                // delete card block
                btnContainer.parentNode.remove();

            }
            else {
                throw new Error('Invalid deck code!');
            }
          })
          .catch(error => {
            console.log("Error!:", error);
          });
    }
}

function onCopyDeckCode() {
   let container = this.parentNode;
   let deckCode = container.querySelector("input[name='deckCode']").value;
   if(deckCode !== "" || deckCode !== null)
   {
        navigator.clipboard.writeText(deckCode);
        let btns = document.getElementsByName('deckCodeCopy');

        btns.forEach(function(btn) {
            btn.value = "Get Deck Code"
            btn.classList.remove('button-primary-pressed');
        })

        this.value = "Deck Code Copied!"
        this.classList.add('button-primary-pressed');
   }
}
setEvents();