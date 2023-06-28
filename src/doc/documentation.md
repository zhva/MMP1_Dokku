#### Hearthstone Deck Builder ##

# ------------------------------------ Documentation --------------------------------------------- #

### Folders ###
 ## [bdsql] contains executable sql code for db creation
  # db consists of 3 tables
  # -users->decks - Information about users.
  #     id - primary key
  # -decks - Information about decks with comments and raitings. Users can have number of decks.
  #     id - primary key
  #     class_id foreign key
  #     user_id foreign key
  # -classes - Information about deck classes.
  #     id - primary key

 ## [css] contains style sheets of the application
  # reset.css resets all the styles in application
  # style.css contains styles for the aplication

 ## [js] contains js files that handle all functionality on the client side
  # deckManager.js - contains all the functionality for deck builder
  # importDeck.js - contains all the functionality for deck import
  # setFiltersOptions.js - contains all the functionality for filtering cards
  # userDecksManager.js - contains all the functionality for deck manager
  # userRegistration.js - contains all the functionality for user registration

 ## [functionality] contains files that handle work with API and DB
  # cardInfo.php - gets Information about card from API
  # config.php - settings for DB connection
  # deleteUserDeckFromDB.php - handles deletion of the deck from db
  # functions.php - different functions used in project & db settings
  # getCardsByDeckcode.php - gets cards from API using deck code
  # getClassCards.php - gets a set of cards that belong to the specific class
  # getDeckClass.php - evaluates the class of the card set from API
  # getDeckCodeByCards.php - gets deck code using list of cards from API
  # getHsApiToken.php - gets API authorization token from Blizzard
  # getMetadataApi.php - gets different information about decks, classes, cards from API
  # getUserDeckInfo.php - gets informaton about user's deck from db
  # getUserDecks.php - gets all user decks from db
  # sendDeckToDB.php - saves user's deck changes in db
  # userLogin.php - handles user login
  # userRegistration.php - handles user registration

 ## [fonts] contains 2 folders with font files

 ## [img] contains images and icons for the project

 ## [doc] contains all documentation for this project including the "Creative Commons" license