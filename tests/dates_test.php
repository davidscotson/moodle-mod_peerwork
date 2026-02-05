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
 * Contains unit tests for mod_peerwork\dates.
 *
 * @package   mod_peerwork
 * @copyright 2026
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace mod_peerwork;

use advanced_testcase;
use cm_info;
use core\activity_dates;

/**
 * Class for unit testing mod_peerwork\dates.
 *
 * @package   mod_peerwork
 * @copyright 2026
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class dates_test extends advanced_testcase {

    /**
     * Data provider for get_dates_for_module().
     * @return array[]
     */
    public static function get_dates_for_module_provider(): array {
        $now = time();
        $before = $now - DAYSECS;
        $earlier = $before - DAYSECS;
        $after = $now + DAYSECS;
        $later = $after + DAYSECS;

        return [
            'without any dates' => [
                null, null, []
            ],
            'only with opening time' => [
                $after, null, [
                    ['label' => get_string('activitydate:opens', 'mod_peerwork'), 'timestamp' => $after],
                ]
            ],
            'only with closing time' => [
                null, $after, [
                    ['label' => get_string('activitydate:closes', 'mod_peerwork'), 'timestamp' => $after],
                ]
            ],
            'with both times' => [
                $after, $later, [
                    ['label' => get_string('activitydate:opens', 'mod_peerwork'), 'timestamp' => $after],
                    ['label' => get_string('activitydate:closes', 'mod_peerwork'), 'timestamp' => $later],
                ]
            ],
            'between the dates' => [
                $before, $after, [
                    ['label' => get_string('activitydate:opened', 'mod_peerwork'), 'timestamp' => $before],
                    ['label' => get_string('activitydate:closes', 'mod_peerwork'), 'timestamp' => $after],
                ]
            ],
            'dates are past' => [
                $earlier, $before, [
                    ['label' => get_string('activitydate:opened', 'mod_peerwork'), 'timestamp' => $earlier],
                    ['label' => get_string('activitydate:closed', 'mod_peerwork'), 'timestamp' => $before],
                ]
            ],
        ];
    }

    /**
     * Test for get_dates_for_module().
     *
     * @dataProvider get_dates_for_module_provider
     * @param int|null $from Time of opening peerwork.
     * @param int|null $due Peerwork due date.
     * @param array $expected The expected value of calling get_dates_for_module()
     */
    public function test_get_dates_for_module(?int $from, ?int $due, array $expected): void {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();

        $course = $generator->create_course();
        $user = $generator->create_user();
        $generator->enrol_user($user->id, $course->id);

        $data = ['course' => $course->id];
        if ($from) {
            $data['fromdate'] = $from;
        }
        if ($due) {
            $data['duedate'] = $due;
        }
        $peerwork = $generator->create_module('peerwork', $data);

        $this->setUser($user);

        $cm = get_coursemodule_from_instance('peerwork', $peerwork->id);
        $cm = cm_info::create($cm);

        $dates = activity_dates::get_dates_for_module($cm, (int) $user->id);

        $this->assertEquals($expected, $dates);
    }
}
