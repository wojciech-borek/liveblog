Feature:
  Relation Create
  As a user
  I want to add new relation

  Scenario: Adding a new relation
    Given I am a user
    When I create a new relation with the title "My New Relation 2"
    Then the relation "My New Relation 2" should exist in the system
    And the status of the relation "My New Relation 2" should be "draft"

  Scenario: Adding a new relation with empty title
    Given I am a user
    When I create a new relation with the title ""
    Then the response status code should be "400"

