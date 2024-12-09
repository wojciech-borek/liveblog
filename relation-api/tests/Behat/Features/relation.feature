Feature:
  Relation Management
  As a user
  I want to add new relation

  Scenario: Adding a new relation
    Given I am a user
    When I create a new relation with the title "My New Relation 2"
    Then the relation "My New Relation 2" should exist in the system
    And the status of the relation "My New Relation 2" should be "draft"
