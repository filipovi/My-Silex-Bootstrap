Feature: user-navigation
    Afin de pouvoir montrer un exemple fonctionnel de formulaire
    En tant qu'utilisateur
    Je dois pouvoir utiliser ce formulaire

    Scenario: Affichage du formulaire
        Given I am on "/action"
        Then I should see "BaseSilex Form"

    Scenario: Execution avec erreur
        Given I am on "/action"
        When I press "submit"
        Then I should be on "/action"
        And I should see "error"

    Scenario: Execution sans erreur
        Given I am on "/action"
        When I fill in "form_id" with "123"
        And I press "submit"
        Then I should be on "/"
        And I should see "999"
        And I should see "notice !"

