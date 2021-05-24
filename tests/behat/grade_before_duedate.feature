@mod @mod_peerwork @mod_peerwork_grade_before_duedate
Feature: Grade a submission before the due date has passed
    In order to test the grading warning before a due date has passed
    As a teacher
    I need to see a warning when I start to enter a grade

  Background:
    Given the following "courses" exist:
        | fullname | shortname | category | groupmode |
        | Course 1 | C1 | 0 | 1 |
    And the following "users" exist:
        | username | firstname | lastname | email |
        | teacher1 | Teacher | 1 | teacher1@example.com |
        | student0 | Student | 0 | student0@example.com |
        | student1 | Student | 1 | student1@example.com |
        | student2 | Student | 2 | student2@example.com |
        | student3 | Student | 3 | student3@example.com |
    And the following "course enrolments" exist:
        | user | course | role |
        | teacher1 | C1 | editingteacher |
        | student0 | C1 | student |
        | student1 | C1 | student |
        | student2 | C1 | student |
        | student3 | C1 | student |
    And the following "groups" exist:
        | name | course | idnumber |
        | Group 1 | C1 | G1 |
    And the following "group members" exist:
        | user | group |
        | student0 | G1 |
        | student1 | G1 |
        | student2 | G1 |
        | student3 | G1 |
    And the following config values are set as admin:
        | calculator | webpa | peerwork |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I add a "Peer Assessment" to section "1" and I fill the form with:
        | Peer assessment | Test peerwork name |
        | Description | Test peerwork description |
        | Peer grades visibility | Hidden from students |
        | Require justification | Disabled |
        | Criteria 1 description | Criteria 1 |
        | Criteria 1 scoring type | Default competence scale |
        | Peer assessment weighting | 0 |
    And I log out
    And I log in as "student1"
    And I am on "Course 1" course homepage
    And I follow "Test peerwork name"
    And I press "Add submission"
    And I give "student0" grade "0" for criteria "Criteria 1"
    And I give "student2" grade "1" for criteria "Criteria 1"
    And I give "student3" grade "1" for criteria "Criteria 1"
    And I press "Save changes"
    And I log out

  @javascript
  Scenario: View the warning message if due date has not passed.
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I follow "Test peerwork name"
    And I follow "Group 1"
    And I set the following fields to these values:
        | Group grade out of 100 | 80 |
    Then "The due date has not passed. If you grade now then students will no longer be able to edit submissions." "text" should be visible

  @javascript
  Scenario: Warning message is not shown if due date has  passed.
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I follow "Test peerwork name"
    And I navigate to "Edit settings" in current page administration
    And I set the following fields to these values:
        | duedate[day]       | ## 1 day ago ## j ## |
        | duedate[month]     | ## 1 day ago ## F ## |
        | duedate[year]      | ## 1 day ago ## Y ## |
        | duedate[hour]      | ## 1 day ago ## G ## |
        | duedate[minute]    | ## 1 day ago ## i ## |
    And I press "Save and display"
    And I follow "Test peerwork name"
    And I follow "Group 1"
    And I set the following fields to these values:
        | Group grade out of 100 | 80 |
    Then "The due date has not passed. If you grade now then students will no longer be able to edit submissions." "text" should not be visible


