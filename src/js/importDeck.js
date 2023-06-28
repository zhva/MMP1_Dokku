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

document.getElementById('importDeckId').addEventListener('click', onImportDeckFromCode);

function onImportDeckFromCode() {
    let deckCodeContainer = document.getElementById('inputDeckCodeId');
    let deckCode = deckCodeContainer.value;
    if(deckCode === "")
    {
        changeDeckCodeContainerStyle('inputDeckCodeId', 'red', 'Invalid deck code!');
        return;
    }

    fetch("functionality/getDeckClass.php?deckcode=" + encodeURIComponent(deckCode))
    .then(response => {
        if(response.ok) {
            return response.json();
        }
        else {
            throw new Error('Invalid deck code!');
        }
    })
    .then(function(dataJson) {
        let deckClass = dataJson.class;
        window.location.href = `deckbuilder.php?class=${deckClass}&deckcode=${encodeURIComponent(deckCode)}`
    })
    .catch(error => {
        changeDeckCodeContainerStyle('inputDeckCodeId', 'red', error.toString());
        console.log("Error!:", error);
    })
}

function changeDeckCodeContainerStyle(containerId, color, text) {
    if(document.getElementById(containerId) !== null) {
        let container = document.getElementById(containerId);
        container.style.borderColor = color;
        container.value = text;
    }
}