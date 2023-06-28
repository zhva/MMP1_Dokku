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

class FilterSetting
{
  constructor() {
    this.isFilterOn = false;
    this.filterValue = -1;
  }
}

class Filter
{
  constructor() {
    this.manaCostFilter = new FilterSetting();
    this.cardTypeFilter = new FilterSetting();
    this.minionTypeFilter = new FilterSetting();
    this.rarityFilter = new FilterSetting();
    this.keywordsFilter = new FilterSetting();
  }
	
	ManaFilter(card) {
		if (this.manaCostFilter.isFilterOn === false) {
			return true;
    }
		else if (parseInt(this.manaCostFilter.filterValue) === 8) {
			return parseInt(card.dataset.manacost) >= 8;
    }
		else {
			return card.dataset.manacost === this.manaCostFilter.filterValue;
    }
	}
	CardTypeFilter(card) {
		if (this.cardTypeFilter.isFilterOn === false) {
			return true;
    }	
		return card.dataset.cardtypeid === this.cardTypeFilter.filterValue;
	}
	MinionTypeFilter(card) {
    if (this.minionTypeFilter.isFilterOn === false) {
			return true;
    }
		return card.dataset.miniontypeid === this.minionTypeFilter.filterValue;
	}
  RarityFilter(card) {
    if (this.rarityFilter.isFilterOn === false) {
			return true;
    }
		return card.dataset.rarityid === this.rarityFilter.filterValue;
  }
  KeywordsFilter(card) {
    if (this.keywordsFilter.isFilterOn === false) {
			return true;
    }
    if(card.dataset.keywords !== null) {
      let keywords = card.dataset.keywords.split(",");
      for(let i = 0; i < keywords.length; i++) {
        if(keywords[i] === this.keywordsFilter.filterValue) {
          return true;
        }
      }
    }
		return false;
  }
  Filter(card) {
		return this.ManaFilter(card) && this.CardTypeFilter(card) && this.MinionTypeFilter(card) && this.RarityFilter(card) && this.KeywordsFilter(card);
	}
}
function toggleCardsVisibility(containerId, msgId) {
  let classCardsContainer = document.getElementById(containerId);
  if(classCardsContainer !== null) {
    if(classCardsContainer.querySelector('#'+ msgId) !== null) {
      classCardsContainer.querySelector('#'+ msgId).remove();
    }
    let classCards = classCardsContainer.getElementsByClassName('card-container');
    let hiddenClassCards = 0;
    for(let i = 0; i < classCards.length; i++) {
      let showClassCard = currentFilter.Filter(classCards[i]);
      if(showClassCard) {
        classCards[i].classList.remove('hide');
      }
      else {
        classCards[i].classList.add('hide');
        hiddenClassCards++;
      }
    }
    if(classCards.length === hiddenClassCards) {
      let msg = document.createElement('p');
      msg.id = msgId;
      msg.textContent = "No cards here. Update your filter to see more";
      classCardsContainer.appendChild(msg);
    }
  }
}
function filterCards(currentFilter) {
  toggleCardsVisibility('classCardsId', 'noClassCardsMsgId');
  toggleCardsVisibility('neutralCardsId', 'noNeutralCardsMsgId');
}
let currentFilter = new Filter();
function setFilterEvents() {
  let manaCostFilter = document.getElementById('manaSelectionId');
  manaCostFilter.addEventListener('change', function() {
    let selectedValue = parseInt(manaCostFilter.value);
    currentFilter.manaCostFilter.isFilterOn =  selectedValue !== -1;
    currentFilter.manaCostFilter.filterValue = manaCostFilter.value;
  });

  let cardTypeFilter = document.getElementById('cardTypeSelectionId');
  cardTypeFilter.addEventListener('change', function() {
    let selectedValue = parseInt(cardTypeFilter.value);
    currentFilter.cardTypeFilter.isFilterOn = selectedValue !== -1;
    currentFilter.cardTypeFilter.filterValue = cardTypeFilter.value;
  });

  let minionTypeFilter = document.getElementById('minionTypeSelectionId');
  minionTypeFilter.addEventListener('change', function() {
    let selectedValue = parseInt(minionTypeFilter.value);
    currentFilter.minionTypeFilter.isFilterOn = selectedValue !== -1;
    currentFilter.minionTypeFilter.filterValue = minionTypeFilter.value;
  });

  let rarityFilter = document.getElementById('rarirySelectionId');
  rarityFilter.addEventListener('change', function() {
    let selectedValue = parseInt(rarityFilter.value);
    currentFilter.rarityFilter.isFilterOn = selectedValue !== -1;
    currentFilter.rarityFilter.filterValue = rarityFilter.value;
  });

  let keywordsFilter = document.getElementById('keywordSelectionId');
  keywordsFilter.addEventListener('change', function() {
    let selectedValue = parseInt(keywordsFilter.value);
    currentFilter.keywordsFilter.isFilterOn = selectedValue !== -1;
    currentFilter.keywordsFilter.filterValue = keywordsFilter.value;
  })

  let btnSearch = document.getElementById('searchBtnId');
  btnSearch.addEventListener('click', function(){
    filterCards(currentFilter);
  }); 
}
setFilterEvents();
