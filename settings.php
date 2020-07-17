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
 * This file adds the settings pages to the navigation menu
 *
 * @package   mod_peerwork
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $steps = range(0, 100, 1);
    $zerotohundredpcopts = array_combine($steps, array_map(function($i) {
        return $i . '%';
    }, $steps));

    $settings->add(new admin_setting_configselect(
        'peerwork/numcrit',
        get_string('numcrit', 'mod_peerwork'),
        get_string('numcrit_help', 'mod_peerwork'),
        3,
        [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/addmorecriteriastep',
        get_string('addmorecriteriastep', 'mod_peerwork'),
        get_string('addmorecriteriastep_help', 'mod_peerwork'),
        1,
        array_combine(range(1, 9), range(1, 9))
    ));

    $settings->add(new admin_setting_heading(
        'peerwork/defaultsettingshdr',
        get_string('defaultsettings', 'mod_peerwork'),
        get_string('defaultsettings_desc', 'mod_peerwork')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'peerwork/allowlatesubmissions',
        get_string('allowlatesubmissions', 'mod_peerwork'),
        get_string('allowlatesubmissions_help', 'mod_peerwork'),
        0
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/maxfiles',
        get_string('setup.maxfiles', 'mod_peerwork'),
        get_string('setup.maxfiles_help', 'mod_peerwork'),
        1,
        [0 => 0, 1, 2, 3, 4, 5]
    ));

    $scales = get_scales_menu();

    $settings->add(new admin_setting_configselect(
        'peerwork/critscale',
        get_string('critscale', 'mod_peerwork'),
        get_string('critscale_help', 'mod_peerwork'),
        null,
        $scales
    ));

    $settings->add(new admin_setting_configcheckbox(
        'peerwork/selfgrading',
        get_string('selfgrading', 'mod_peerwork'),
        get_string('selfgrading_help', 'mod_peerwork'),
        0
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/paweighting',
        get_string('paweighting', 'mod_peerwork'),
        get_string('paweighting_help', 'mod_peerwork'),
        50,
        $zerotohundredpcopts
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/noncompletionpenalty',
        get_string('noncompletionpenalty', 'mod_peerwork'),
        get_string('noncompletionpenalty_help', 'mod_peerwork'),
        0,
        $zerotohundredpcopts
    ));

    $settings->add(new admin_setting_configcheckbox(
        'peerwork/displaypeergradestotals',
        get_string('displaypeergradestotals', 'mod_peerwork'),
        get_string('displaypeergradestotals_help', 'mod_peerwork'),
        false
    ));

    $setting = new admin_setting_configselect(
        'peerwork/justificationtype',
        get_string('justificationtype', 'mod_peerwork'),
        get_string('justificationtype_help', 'mod_peerwork'),
        0,
        [
            0 => get_string('justificationtype0', 'mod_peerwork'),
            1 => get_string('justificationtype1', 'mod_peerwork')
        ]
    );
    $setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
    $settings->add($setting);

    $settings->add(new admin_setting_configtext(
        'peerwork/justificationmaxlength',
        get_string('justificationmaxlength', 'mod_peerwork'),
        get_string('justificationmaxlength_help', 'mod_peerwork'),
        280,
        PARAM_INT
    ));

    $settings->add(new admin_setting_heading(
        'peerwork/defaultcritshdr',
        get_string('defaultcrit', 'mod_peerwork'),
        get_string('defaultcrit_desc', 'mod_peerwork')
    ));

    $scales = [0 => ''] + $scales;

    $settings->add(new admin_setting_confightmleditor(
        'peerwork/defaultcrit0',
        get_string('defaultcrit0', 'mod_peerwork'),
        get_string('defaultcrit0_help', 'mod_peerwork'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/defaultscale0',
        get_string('defaultscale0', 'mod_peerwork'),
        get_string('defaultscale0_help', 'mod_peerwork'),
        0,
        $scales
    ));

    $settings->add(new admin_setting_confightmleditor(
        'peerwork/defaultcrit1',
        get_string('defaultcrit1', 'mod_peerwork'),
        get_string('defaultcrit1_help', 'mod_peerwork'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/defaultscale1',
        get_string('defaultscale1', 'mod_peerwork'),
        get_string('defaultscale1_help', 'mod_peerwork'),
        0,
        $scales
    ));

    $settings->add(new admin_setting_confightmleditor(
        'peerwork/defaultcrit2',
        get_string('defaultcrit2', 'mod_peerwork'),
        get_string('defaultcrit2_help', 'mod_peerwork'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/defaultscale2',
        get_string('defaultscale2', 'mod_peerwork'),
        get_string('defaultscale2_help', 'mod_peerwork'),
        0,
        $scales
    ));

    $settings->add(new admin_setting_confightmleditor(
        'peerwork/defaultcrit3',
        get_string('defaultcrit3', 'mod_peerwork'),
        get_string('defaultcrit3_help', 'mod_peerwork'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/defaultscale3',
        get_string('defaultscale3', 'mod_peerwork'),
        get_string('defaultscale3_help', 'mod_peerwork'),
        0,
        $scales
    ));

    $settings->add(new admin_setting_confightmleditor(
        'peerwork/defaultcrit4',
        get_string('defaultcrit4', 'mod_peerwork'),
        get_string('defaultcrit4_help', 'mod_peerwork'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configselect(
        'peerwork/defaultscale4',
        get_string('defaultscale4', 'mod_peerwork'),
        get_string('defaultscale4_help', 'mod_peerwork'),
        0,
        $scales
    ));
}
