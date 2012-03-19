Feature: user-navigation
    Afin de pouvoir utiliser ce site
    En tant qu'utilisateur 
    Je dois pouvoir afficher la page d'accueil

    Scenario: Accès à l'accueil
        Given I am on "/1"
        Then I should see "Hello World!"

    Scenario: Accès à l'accueil avec l'index = 1
        Given I am on "/1"
        Then I should see "Id = 1"

    Scenario: Accès à l'accueil avec l'index = 2
        Given I am on "/2"
        Then I should see "Id = 2"

