<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Unit tests for mod/peerwork/lib.php.
 *
 * @package    mod_peerwork
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_peerwork;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/peerwork/lib.php');

/**
 * Unit tests for mod/peerwork/lib.php.
 *
 * @package    mod_peerwork
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class lib_test extends \advanced_testcase {

    public function test_peerwork_core_calendar_provide_event_action_open_for_student(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $group = $this->getDataGenerator()->create_group(['courseid' => $course->id]);
        groups_add_member($group->id, $student->id);

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertInstanceOf('\core_calendar\local\event\value_objects\action', $actionevent);
        $this->assertEquals(get_string('addsubmission', 'peerwork'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    public function test_peerwork_core_calendar_provide_event_action_open_for_instructor(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $teacher = $this->getDataGenerator()->create_and_enrol($course, 'teacher');

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($teacher);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertInstanceOf('\core_calendar\local\event\value_objects\action', $actionevent);
        $this->assertEquals(get_string('allsubmissions', 'peerwork'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    public function test_peerwork_core_calendar_provide_event_action_open_for_student_without_group(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertNull($actionevent);
    }

    public function test_peerwork_core_calendar_provide_event_action_not_open_yet(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $group = $this->getDataGenerator()->create_group(['courseid' => $course->id]);
        groups_add_member($group->id, $student->id);

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() + DAYSECS,
            'duedate' => time() + (2 * DAYSECS),
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertNull($actionevent);
    }

    public function test_peerwork_core_calendar_provide_event_action_grouping_set_without_group(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $grouping = $this->getDataGenerator()->create_grouping(['courseid' => $course->id]);

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
            'pwgroupingid' => $grouping->id,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertInstanceOf('\core_calendar\local\event\value_objects\action', $actionevent);
        $this->assertEquals(get_string('addsubmission', 'peerwork'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    public function test_peerwork_core_calendar_provide_event_action_open_for_instructor_without_group(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $teacher = $this->getDataGenerator()->create_and_enrol($course, 'teacher');

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($teacher);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertInstanceOf('\core_calendar\local\event\value_objects\action', $actionevent);
        $this->assertEquals(get_string('allsubmissions', 'peerwork'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    public function test_peerwork_core_calendar_provide_event_action_closed(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $group = $this->getDataGenerator()->create_group(['courseid' => $course->id]);
        groups_add_member($group->id, $student->id);

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - (2 * DAYSECS),
            'duedate' => time() - DAYSECS,
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertNull($actionevent);
    }

    public function test_peerwork_core_calendar_provide_event_action_with_submission(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $group = $this->getDataGenerator()->create_group(['courseid' => $course->id]);
        groups_add_member($group->id, $student->id);

        $peerwork = $this->getDataGenerator()->create_module('peerwork', [
            'course' => $course->id,
            'fromdate' => time() - DAYSECS,
            'duedate' => time() + DAYSECS,
        ]);

        $generator = $this->getDataGenerator()->get_plugin_generator('mod_peerwork');
        $generator->create_submission([
            'peerworkid' => $peerwork->id,
            'groupid' => $group->id,
            'userid' => $student->id,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $event = $this->create_action_event($course->id, $peerwork->id, 'due');

        $this->setUser($student);
        $factory = new \core_calendar\action_factory();
        $actionevent = mod_peerwork_core_calendar_provide_event_action($event, $factory);

        $this->assertNull($actionevent);
    }

    /**
     * Creates an action event.
     *
     * @param int $courseid
     * @param int $instanceid The peerwork id.
     * @param string $eventtype The event type. eg. 'due'.
     * @param int|null $timestart The start timestamp for the event.
     * @return bool|\calendar_event
     */
    private function create_action_event(int $courseid, int $instanceid, string $eventtype, ?int $timestart = null) {
        $event = new \stdClass();
        $event->name = 'Calendar event';
        $event->modulename = 'peerwork';
        $event->courseid = $courseid;
        $event->instance = $instanceid;
        $event->type = CALENDAR_EVENT_TYPE_ACTION;
        $event->eventtype = $eventtype;
        $event->timestart = $timestart ?? time();

        return \calendar_event::create($event);
    }
}
