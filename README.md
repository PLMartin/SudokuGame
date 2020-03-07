

# SUDOKU


## Description


Cette application permet de génèrer des sudokus selon plusieurs niveaux de difficultés.
L'utilisateur ne peux jouer qu'une seule partie à la fois. 
Il aura la possibilité de jouer normalement, ou de résoudre le sudoku automatiquement à n'importe quel moment de la partie.
L'utilisateur pourra également sauvegarder sa partie, et aura la possibilité de la charger lors de son retour sur l'application


## Technologies utilisées

- Framework de développement : Symfony 5.0
- Framework  de tests : PHPUnit


## User stories


- En tant qu'utilisateur, je veux accéder directement à l'application sans authentification. 
  Sur la page d'accueil, je veux pouvoir choisir entre jouer et résoudre automatiquement un sudoku.
  
  
- En tant qu'utilisateur, si j'ai choisi de résoudre automatiquement un sudoku, alors j'accèderai à une page avec un
  sudoku à remplir et un boutons pour valider et lancer la résolution automatique. Si le sudoku comporte une erreur,
  un message sera alors affiché:\
  "Le sudoku est incorrect, la valeur de la cellule { x : y } est erronée"
  
  
- En tant qu'utilisateur, au démarrage, si j'ai choisi de jouer et si il existe une sauvegarde, alors il sera proposé de 
  continuer la partie ou d'en créer une nouvelle, sinon le choix de créer une nouvelle partie est imposé.
  
  
- En tant qu'utilisateur, au moment de la création de la partie, il me sera proposé de choisir un niveau de difficulté :
    - Facile : 50 cases pré-remplies;
    - Moyen : 40 cases pré-remplies;
    - Difficile : 30 cases pré-remplies.
    
    
- En tant qu'utilisateur, si je suis en train de jouer, lorsque je clique sur une cellule vide, une petite modale doit s'ouvrir pour 
  demander le chiffre à entrer. Pour quitter la modale, il suffira de cliquer en dehors de celle-ci.\
  Si c'est correct, un message de succés apparait et la modale disparait : "OK"\
  Si c'est incorrect, un message d'erreur apparait : "Incorrect, vous avez le droit à l'echec encore X fois"\
  
  Attention : L'utilisateur n'a le droit qu'à 3 erreurs durant une partie.


- En tant qu'utilisateur, si je suis en train de jouer, je souhaite pouvoir sauvegarder ma partie en cours.


- En tant qu'utilisateur, si je suis en train de jouer, il me sera possible d'abandonner la partie. Je serai alors redirigé sur la page d'accueil.












