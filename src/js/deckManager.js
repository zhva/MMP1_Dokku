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

let deck = [];
function setEvents() {
    document.getElementById('copyCodeId').addEventListener('click', onCopyDeckCodeToClipboard);

    window.addEventListener('load', onPageLoad);
    window.addEventListener('click', function(e){   
        if(document.querySelector('div.info-hint') !== null && document.getElementById('hintId') !== null) {
            if (!document.querySelector('div.info-hint').contains(e.target) && !document.getElementById('hintId').contains(e.target)){
                onBtnCloseClick();
            }
        }
      });

    document.getElementById('hintId').addEventListener('click', onHintClick);

}

function onPoolCardDblClick() {
    if(document.getElementById(this.id).classList.contains("disabled")) {
        return;
    }

    addCardToDeck(this.id);
}
function onDeckNameFocusOut() {
    updateDeckInDB();
}
function onRatingClick() {
    updateDeckInDB();
}
function onCommentFocusOut() {
    updateDeckInDB();
}
function addCardToDeck(cardId) {
    if(deck.length !== 30) {
        fetch("functionality/cardInfo.php?id=" + cardId)
        .then(response => response.json())
        .then(async function(card){
            addCardBlockToDeckArea(card);
            await updateUrl();
            updateDeckInDB();
            toggleDeckInfoStatus();
        })
    }
}
async function updateUrl()
{
    const url = new URL(window.location.href);
    let searchTearm = "";
    deck.forEach(card => searchTearm += card.id + "%2C");
    // cut of the last separator
    searchTearm = searchTearm.slice(0, -3); 
    return fetch("functionality/getDeckCodeByCards.php?ids=" + searchTearm)
    .then(response => response.json())
    .then(function(deckInfo){
        // no encoding is required because searchParams feels too smart
        let deckCode = deckInfo['deckCode'];
        if(url.searchParams.has('deckcode') === false) {
            url.searchParams.append('deckcode', deckCode);
        }
        else {
            url.searchParams.set('deckcode', deckCode);
        }
        const nextState = { additionalInformation: url.toString() };
        window.history.replaceState(nextState, '', url.toString());
    });

}
function createCardBlockInDeckArea(container, card) {
    let div = document.createElement('div');
    div.classList.add("deck-card-wrapper");
    div.id = `deck_${card.id}`;
    div.addEventListener('dblclick', deleteCardFromDeckArea);

    let spanMana = document.createElement('span');
    spanMana.textContent = card.manaCost;
    div.appendChild(spanMana);

    let p = document.createElement('p');
    p.textContent = card.name;
    div.appendChild(p);

    let divImg = document.createElement('div');
    divImg.classList.add('cropped-img-container');

    let img = document.createElement('img');
    img.src = card.cropImage;
    img.alt = `Cropped image of ${card.name}`;
    divImg.appendChild(img);
    div.appendChild(divImg);

    let spanCount = document.createElement('span');
    spanCount.id = `count_${card.id}`;
    spanCount.textContent = 1;
    div.appendChild(spanCount);

    container.appendChild(div);
}
function updateCardCount(container, cardId, value) {
    let cardContainer = container.querySelector(`[id='deck_${cardId}']`);
    let span = cardContainer.querySelector(`[id='count_${cardId}']`);
    if (span !== null) {
        span.innerHTML = value;
    }
}

function getCardCount(container, cardId) {
    let cardContainer = container.querySelector(`[id='deck_${cardId}']`);
    let span = null;

    let thisCardCount = 0;

    if(cardContainer !== null) {
        span = cardContainer.querySelector(`[id='count_${cardId}']`);
        if (span !== null) {
            thisCardCount = parseInt(span.innerHTML);
        }
    }

    return thisCardCount;
}
function updateDeckInDB() {
    if(!getLoginStatus()) {
        return;
    }
    let deckHeaderContainer = document.getElementById('deckHeaderId');
    if(deckHeaderContainer === null) {
        return;
    }
    
    let deckIdContainer = deckHeaderContainer.querySelector("#deckId");
    let deckId = (deckIdContainer === null) ? "": deckIdContainer.value;
    let deckCode = "";
    let url = new URL(window.location.href);
    if(url.searchParams.has('deckcode')) {
        deckCode = url.searchParams.get('deckcode');
    }
    let className = "";
    if(url.searchParams.has('class')) {
        className = url.searchParams.get('class');
    }
    let deckName = deckHeaderContainer.querySelector('input[type="text"]').value;
    let dustCost = evalDustCost();
    let rating;

    if(deckHeaderContainer.querySelector('input[name="rating"]:checked') === null) {
        rating = 0;
    }
    else {
        rating = parseInt(deckHeaderContainer.querySelector('input[name="rating"]:checked').value);
    }
    let descriptionContainer = deckHeaderContainer.querySelector('details > input');
    let description = "";
    if(descriptionContainer !== null) {
        description = descriptionContainer.value;
    }
    let data = {deckId: deckId, deckCode: deckCode, className: className, deckName: deckName, dustCost: dustCost, rating: rating, description: description};

    //send post request to php
    fetch("functionality/sendDeckToDB.php", {
        method: "POST",
        headers: {'Content-Type': 'application/json'}, 
        body: JSON.stringify(data)
      })
      .then(response => {
        console.log("Request complete! response:", response);
         return response.json();
      })
      .then(function(deckIdJson) {
          let deckId = deckIdJson.deckId;
          if(deckId === "") {
            throw new Error("Deck code is empty!");
          }
          else {
            let deckCodeIdContainer = document.getElementById('deckId');
            if(deckCodeIdContainer !== null) {
                deckCodeIdContainer.value = deckId;
            }
          }
      })
      .catch(error => {
        console.log("Error!:", error);
      });
}
function addCardBlockToDeckArea(card) {
    // only one legendary (rarityId = 5) card per deck is allowed
    let isLegendary = (card.rarityId == 5);
    let deckContainer = document.getElementById('deckAreaId');
    let thisCardCount = getCardCount(deckContainer, card.id);

    if(thisCardCount === 0) {
        thisCardCount += 1;

        createCardBlockInDeckArea(deckContainer, card);
        deck.push(card);
        
        if(isLegendary) {
            if(document.getElementById(card.id) !== null) {
                document.getElementById(card.id).classList.replace("enabled", "disabled");
            }
        }
    }
    else if(thisCardCount === 1 && isLegendary === false) {
        thisCardCount += 1

        updateCardCount(deckContainer, card.id, thisCardCount);
        deck.push(card);
        
        if(document.getElementById(card.id) !== null) {
            document.getElementById(card.id).classList.replace("enabled", "disabled");
        }
    }
    else {
        return;
    }
}

function toggleDeckInfoStatus() {
    let deckHeaderContainer = document.getElementById('deckHeaderId');
    if(deckHeaderContainer !== null) {
        let cardCounter = deckHeaderContainer.querySelector("[id='cardsCountId']");
        cardCounter.innerHTML = `${deck.length}/30`;
    }
    if(deck.length === 0) {
        disableDeckInfo();
    }
    else {
        enableDeckInfo();
    }
    updateDeckDustCost();

}

function evalDustCost(){
    let dustCost = 0; 
    for (let i = 0; i<deck.length; i++) {
        switch (deck[i].rarityId) {
            case 1:
                dustCost += 40;
                break;
            case 3:
                dustCost += 100;
                break;
            case 4:
                dustCost += 400;
                break;
            case 5:
                dustCost += 1600;
                break;
        }
    }
    return dustCost;
}

function updateDeckDustCost() {
    dustCost = evalDustCost();
    let deckHeaderContainer = document.getElementById('deckHeaderId');
    if(deckHeaderContainer !== null) {
        let deckDustCost = deckHeaderContainer.querySelector('span.dust-cost');
        if(deckDustCost !== null) {
            deckDustCost.textContent = dustCost;
        }
    }
}
function createCardBlock(card) {
    let cardContainer = document.createElement('div');
    cardContainer.classList.add('card-container');
    cardContainer.classList.add('enabled');
    cardContainer.id = card.id;
    let keywordIds = null;
    if(card.keywordIds !== null) {
        for(let i = 0; i < card.keywordIds.length; i++)
        {
            keywordIds += card.keywordIds[i];
            if(i !== card.keywordIds.length - 1)
            {
                keywordIds += ",";
            }
        }
    }
    cardContainer.setAttribute('data-name', card.name);
    cardContainer.setAttribute('data-rarityid', card.rarityId);
    cardContainer.setAttribute('data-manacost', card.manaCost);
    cardContainer.setAttribute('data-cardtypeid', card.cardTypeId);
    cardContainer.setAttribute('data-miniontypeid', card.minionTypeId);
    cardContainer.setAttribute('data-keywords', keywordIds);

    let cardImg = document.createElement('img');
    cardImg.src = card.image;
    cardImg.alt = card.name;

    cardContainer.appendChild(cardImg);
    cardContainer.addEventListener('dblclick', onPoolCardDblClick);
    return cardContainer;
}
function printCards(cardsContainer, cards) {
    if(cardsContainer === null) {
        console.log(`Error!: Card container ${cardsContainer} does not exist!`);
        return;
    }
    for(let i = 0; i < cards.length; i++)
    {
        cardsContainer.appendChild(createCardBlock(cards[i]));
    }
}
async function loadCards() {
    let url = new URL(window.location.href);
    let cardsClass = "";

    if(!url.searchParams.has('class')) {
        console.log("Error!: There is no class param in the URL!");
        return;
    }
    cardsClass = url.searchParams.get('class');

    let classCardsContainer = document.getElementById('classCardsId');
    let neutralCardsContainer = document.getElementById('neutralCardsId');

    return fetch("functionality/getClassCards.php?class=" + cardsClass)
    .then(response => {
        if(response.ok) {
            return response.json();
        }
        else {
            throw new Error('Something went very wrong with API!');
        }
    })
    .then(function(cardsJson){
        let classCards = cardsJson.cards.classCards;
        let neutralCards = cardsJson.cards.neutralCards;

        printCards(classCardsContainer, classCards);
        printCards(neutralCardsContainer, neutralCards);

    })
    .catch((error) => {
        console.log("Error!:", error);
    });
}
async function onPageLoad() {
    await loadCards();

    let url = new URL(window.location.href);
    let deckCode = "";
    if(url.searchParams.has('deckcode')) {
        deckCode = url.searchParams.get('deckcode');
        fillDeck(deckCode);
    }

    if(getLoginStatus()) {
        fillDeckInfo(deckCode);
        toggleDeckInfoStatus();
    }
    else {
        let deckHeader = document.getElementById('deckHeaderId');
        if(deckHeader !== null) {
            let deckName = document.createElement('input');
            deckName.placeholder = "Name";
            deckName.type = 'text';
            deckName.id = 'deckNameId';
            deckName.value = `Standard ${capitalizeFirstLetter(url.searchParams.get('class'))} Deck`;
            deckHeader.prepend(deckName);

            let deckNameLabel = document.createElement('label');
            deckNameLabel.htmlFor = 'deckNameId';
            deckHeader.prepend(deckNameLabel);

            toggleDeckInfoStatus();
        }
    }
}
function getLoginStatus() {
    let main = document.querySelector('main');
    return main.classList.contains('logged-in');
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }


function fillDeck(deckCode) {
    fetch("functionality/getCardsByDeckcode.php?deckcode=" + encodeURIComponent(deckCode))
    .then(response => {
        if(response.ok) {
            return response.json();
        }
        else {
            throw new Error('Invalid deck code!');
        }
    })
    .then(function(cardsJson){
        let cards = cardsJson.cards;
        for(let i = 0; i < cards.length; i++)
        {
            addCardBlockToDeckArea(cards[i]); 
        }
        toggleDeckInfoStatus();
    })
    .catch((error) => {
        console.log("Error!:", error);
    });
}

function fillDeckInfo(deckCode) {
    if (deckCode === "") {
        let url = new URL(window.location.href);
        if(url.searchParams.has('class'))
        {
            className = url.searchParams.get('class');
        }
        
        let deckHeader = document.getElementById('deckHeaderId');
        if(deckHeader !== null) {
            deckHeader.prepend(createDeckBlock(null));
        }

        return;
    }

    fetch("functionality/getUserDeckInfo.php?deckcode=" + encodeURIComponent(deckCode))
    .then(response => {
        if(response.ok) {
            return response.json();
        }
        else {
            throw new Error('Invalid deck code!');
        }
    })
    .then(function(deckJson) {
        let deckHeader = document.getElementById('deckHeaderId');
        if(deckHeader !== null) {
            if (deckJson.nodeck == true) {
                deckHeader.prepend(createDeckBlock(null));
            }
            else {
                deckHeader.prepend(createDeckBlock(deckJson));
            }
        }
        toggleDeckInfoStatus();
    })
    .catch((error) => {
        //this user doesn't have deck with this code
        console.log("Error!:", error);
    });
    
}
function disableDeckInfo() {
    let deckInfoContainer = document.getElementById('deckHeaderId');
    if(deckInfoContainer.querySelector('.deck-info-container input') !== null) {
        deckInfoContainer.querySelector('.deck-info-container input').disabled = true;
        let radioElls = deckInfoContainer.querySelector('.rating').getElementsByTagName('input');
        for (let el of radioElls) { 
            el.disabled = true; 
        }
        deckInfoContainer.querySelector('details > input').disabled = true;
    }
}
function enableDeckInfo() {
    let deckInfoContainer = document.getElementById('deckHeaderId');
    if(deckInfoContainer.querySelector('.deck-info-container input') !== null) {
        deckInfoContainer.querySelector('.deck-info-container input').disabled = false;
    
        let radioElls = deckInfoContainer.querySelector('.rating').getElementsByTagName('input');
        for (let el of radioElls) { 
            el.disabled = false; 
        }
        deckInfoContainer.querySelector('details > input').disabled = false;
}
}
function createDeckBlock(deckInfo) {
    let deckInfoDefault = {id: "", name: `Standard Deck`, description: "", dustCost : 0, rating : 0}; // TODO: change for deffault values
    if (deckInfo === null) {
        deckInfo = deckInfoDefault;
    }

    let deckInfoContainer = document.createElement('div');
    deckInfoContainer.classList.add("deck-info");

    let divInfo = document.createElement('div');
    divInfo.classList.add('deck-info-container');

    let deckName = document.createElement('input');
    deckName.value = deckInfo.name;
    deckName.placeholder = "Name";
    deckName.type = 'text';
    deckName.id = 'deckNameId';
    deckName.addEventListener('focusout', onDeckNameFocusOut);
    divInfo.appendChild(deckName);

    let deckNameLabel = document.createElement('label');
    deckNameLabel.htmlFor = 'deckNameId';
    divInfo.appendChild(deckNameLabel);

    let span = document.createElement('span');
    span.classList.add('dust-cost');
    span.textContent ="Dust cost: " + deckInfo.dustCost;
    divInfo.appendChild(span);
    
    let divRating = document.createElement('div');
    divRating.classList.add('rating');

    let rating = deckInfo.rating;
    const ratingMax = 5;
    for(let i = ratingMax; i > 0; i--) {
        let input = document.createElement('input');
        if(i === parseInt(rating)) {
            input.setAttribute("checked", "checked");
        }
        input.type = 'radio';
        input.name = 'rating';
        input.id = deckInfo.id + 'rating' + i;
        input.value = i;
        input.addEventListener('click', onRatingClick);

        divRating.appendChild(input);

        let label = document.createElement('label');
        label.htmlFor = deckInfo.id + 'rating' + i;
        divRating.appendChild(label)
    }
    divInfo.appendChild(divRating);

    let commentContainer = document.createElement('details');
    commentContainer.classList.add('comment-container');

    let summary = document.createElement('summary');
    summary.textContent = "Comments/Description";
    commentContainer.appendChild(summary);

    let inputComment = document.createElement('input');
    inputComment.type = 'text';
    inputComment.placeholder = "Comments";
    inputComment.value = deckInfo.description;
    inputComment.id = 'inputCommentId';
    inputComment.addEventListener('focusout', onCommentFocusOut);
    commentContainer.appendChild(inputComment);

    let inputCommentLabel = document.createElement('label');
    inputCommentLabel.htmlFor = 'inputCommentId';
    commentContainer.appendChild(inputCommentLabel);

    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.id = 'deckId';
    hiddenInput.value = deckInfo.id;

    deckInfoContainer.appendChild(divInfo);
    deckInfoContainer.appendChild(commentContainer);
    deckInfoContainer.appendChild(hiddenInput);

    return deckInfoContainer;
}
function deleteCard(id) {
    let deckContainer = document.getElementById('deckAreaId');
    let card = deckContainer.querySelector(`[id='deck_${id}']`);
    let cardCountContainer = card.querySelector(`[id='count_${id}']`);
    let cardCount = cardCountContainer.textContent
    if(parseInt(cardCount) === 1) {
        card.remove();
    }
    else if (parseInt(cardCount) === 2) {
        cardCountContainer.textContent = cardCount - 1;
        if(document.getElementById(id) !== null) {
            document.getElementById(id).classList.replace("disabled", "enabled");
        }
    }
    let index = -1;
    for (let i = 0; i<deck.length; i++) {
        if (deck[i].id === parseInt(id)) {
            index = i;
            break;
        }
    }

    if(index !== -1) {
        deck.splice(index, 1);
    }
}
async function deleteCardFromDeckArea() {
    let cardId = this.id.slice(5);
    if(cardId === null) {
        return;
    }
    deleteCard(cardId);
    await updateUrl();
    updateDeckInDB();
    toggleDeckInfoStatus();
}
function removeSearchParameter(paramName) {
    let url = new URL(window.location.href);
    if(url.searchParams.has(paramName))
    {
        url.searchParams.delete(paramName);
        const nextState = { additionalInformation: url.toString() };
        window.history.replaceState(nextState, '', url.toString());
    }
}
function onCopyDeckCodeToClipboard() {
    let url = new URL(window.location.href);
    let deckCode = "";
    if(url.searchParams.has('deckcode'))
    {
        deckCode = url.searchParams.get('deckcode');
        navigator.clipboard.writeText(deckCode);
        this.value = "Deck Code Copied!"
        this.classList.add('button-primary-pressed');
    }
}
function onHintClick() {
    if(document.querySelector('div.info-hint') !== null) {
        return;
    }
    let hintContainer = document.createElement('div');
    hintContainer.classList.add('info-hint');

    let infoHeader = document.createElement('h2');
    infoHeader.textContent = 'Info-Help';
    hintContainer.appendChild(infoHeader);

    let msg1 = document.createElement('p');
    msg1.textContent = "Doubleclick on the card to add it to your deck.";

    let msg2 = document.createElement('p');
    msg2.textContent = "Doubleclick on the card header in your deck to remove it.";

    let msg3 = document.createElement('p');
    msg3.textContent = "In order to edit the deck name or description the deck should not be empty.";

    let msg4 = document.createElement('p');
    msg4.textContent = "All the changes to the deck will be automatically saved into your account, if you are logged in.";

    let msgContainer = document.createElement('div');
    msgContainer.appendChild(msg1);
    msgContainer.appendChild(msg2);
    msgContainer.appendChild(msg3);
    msgContainer.appendChild(msg4);
    
    let closeBtn = document.createElement('a');
    closeBtn.classList.add('info-hint-close');
    closeBtn.id = 'closeBtnId';
    closeBtn.innerHTML = '✕';
    closeBtn.addEventListener('click', onBtnCloseClick);

    hintContainer.appendChild(closeBtn);
    hintContainer.appendChild(msgContainer);

    let contentContainer = document.querySelector('.content-container');
    if(contentContainer !== null) {
        contentContainer.appendChild(hintContainer);
    }
}

function onBtnCloseClick() {
    let btnContainer = document.getElementById('closeBtnId').parentNode;
    if(btnContainer !== null) {
        btnContainer.remove();
    }
}
setEvents();
