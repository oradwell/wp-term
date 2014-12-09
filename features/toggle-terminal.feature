Feature: Toggle Terminal
  In order to type commands
  As a website user
  I need to be able to open and close terminal

  @javascript
  Scenario: Opening the terminal
    Given I am on the homepage
    When I follow "Open Terminal"
    Then I should see the terminal

  @javascript
  Scenario: Exit the terminal
    Given I am on the homepage
    When I follow "Open Terminal"
    And I execute command "exit"
    Then I should not see the terminal
