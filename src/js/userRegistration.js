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
    let btn = document.getElementById('signUpId');
    btn.addEventListener('click', onSubmit);

    let container = document.querySelector('.register-form');
    if(container !== null) {
        let inputPass = container.querySelector('#passwordId');
        inputPass.addEventListener('keyup', onKeyUp);

        let inputRepeatPass = container.querySelector('#repeatPasswordId');
        inputRepeatPass.addEventListener('keyup', onKeyUp);
    }
}

function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function checkPassword(pass, container) {
    if(container.hasChildNodes()) {
        removeAllChildNodes(container);
    }
    let msg = document.createElement('p');
    msg.classList = 'text-error';
    if(pass.length < 8) {
        msg.textContent = "Password must be at least 8 charachters";
    }
    else if(pass.length > 50) {
        msg.textContent = "Password is to long!";
    }
    container.appendChild(msg);
}
function checkPasswords(container) {
    if(container.hasChildNodes()) {
        removeAllChildNodes(container);
    }
    let pass1 = document.getElementById('passwordId');
    let pass2 = document.getElementById('repeatPasswordId');
    let msg = document.createElement('p');
    msg.classList = 'text-error';

    if(pass1 === null || pass2 === null || pass1.value !== pass2.value)
    {
        msg.textContent = "Passwords do not match!";
        container.appendChild(msg);
    }

}
function onKeyUp() {
    let password = this.value;
    let msgContainer = document.getElementById('alertMsgId');
    checkPassword(password, msgContainer);
    checkPasswords(msgContainer);
}
function onSubmit() {
    let form = this.parentNode;
    let password = form.querySelector(`[id='passwordId']`);

}
setEvents();
