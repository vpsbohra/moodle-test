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
 * My Moodle -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
 * @package    moodlecore
 * @subpackage my
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');
global $DB;
$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title("Add Time Slot");
$PAGE->set_heading("Add Time Slot");
$PAGE->set_url($CFG->wwwroot.'/addtimeslot.php');

echo $OUTPUT->header();
if(isset($_POST['submit'])){
$ins = new stdClass();
$ins->course_id = $_POST['SelectCourse'];
$ins->starttime = $_POST['start_date'];
$ins->endtime = $_POST['end_date'];
$ins->teacherid = $_POST['assign_teacher'];

$ins->duration = $_POST['duration'];

$DB->insert_record('course_timeslot', $ins);
$msg="done.....";
}

$timeslots = $DB->get_recordset_sql("SELECT * FROM {course}");
//print_r($timeslots);

?>
<form action="" method="POST">
  <div class="form-row">
      <?php //if($msg){echo $msg;} ?>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Select Course</label>
       <select id="SelectCourse" class="form-control" name="SelectCourse">
        <option selected>Choose...</option>
        <?php foreach($timeslots as $timeslot){?>
        <option value="<?php echo $timeslot->id;?>"><?php echo $timeslot->fullname;?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Assign Teacher</label>
       <select id="AssignTeacher" class="form-control" name="assign_teacher">
        <option selected>Choose...</option>
        <option value="1">Test 123</option>
        <option value="2">Test 456</option>
      </select>
    </div>
  </div>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="StartDate">Choose Start Time</label>
       <input type="text" class="form-control" id="start_date" name="start_date">
    </div>
    <div class="form-group col-md-6">
      <label for="EndTime">Choose End Time</label>
       <input type="text" class="form-control" id="end_date" name="end_date">
    </div>
  </div>

   <div class="form-group">
      <label for="Duration">Duration</label>
      <input type="text" class="form-control" name="duration" id="duration">
    </div>
 
  <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>
<?php echo $OUTPUT->footer(); ?>