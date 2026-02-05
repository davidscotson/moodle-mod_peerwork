@mod @mod_peerwork
Feature: Students can view upcoming peerwork activities in the timeline block
  In order for student to see upcoming peerwork activities in timeline block
  As a teacher
  I should be able to set the availability dates of peerwork activities

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | One      | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
    And the following "course enrolments" exist:
      | user     | course | role    |
      | student1 | C1     | student |
    And the following "groups" exist:
      | course | name   |
      | C1     | Group 1 |
    And the following "group members" exist:
      | user     | group  |
      | student1 | Group 1 |

  @javascript
  Scenario Outline: Student can view upcoming peerwork activities in the timeline block
    Given the following "activities" exist:
      | activity | course | name           | id_fromdate_enabled | fromdate     | id_duedate_enabled | duedate      |
      | peerwork | C1     | Peerwork Past  | 1                   | <pastfrom>   | 1                  | <pastdue>    |
      | peerwork | C1     | Peerwork Future| 1                   | <futurefrom> | 1                  | <futuredue>  |
      | peerwork | C1     | Peerwork No Date | 0                 |              | 0                  |              |
    When I log in as "student1"
    Then I should not see "Peerwork Past" in the "Timeline" "block"
    And I should not see "Peerwork No Date" in the "Timeline" "block"
    And I should see "Peerwork Future" in the "Timeline" "block"
    And I click on "Peerwork Future" "link" in the "Timeline" "block"
    And the activity date in "Peerwork Future" should contain "Due:"
    And the activity date in "Peerwork Future" should contain "<futuredue>%A, %d %B %Y, %I:%M##"

    Examples:
      | pastfrom        | pastdue         | futurefrom          | futuredue             |
      | ##1 month ago## | ##yesterday##   | ##tomorrow##        | ##tomorrow +1day##    |
      | ##yesterday##   | ##yesterday##   | ##tomorrow noon##   | ##tomorrow noon +3hours## |
      | ##6 months ago##| ##1 week ago##  | ##tomorrow +5days## | ##tomorrow +6days##   |
