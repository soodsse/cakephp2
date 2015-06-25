<?php
class Meeting extends AppModel{
	
	var $name='Meeting';
	var $actsAs = array('Containable');
	var $hasMany = array('MeetingQuestion'=>array('className'=>'MeetingQuestion','foreignKey'=>'meeting_id'),
	 'UserQuestion'=>array('className'=>'UserQuestion','foreignKey'=>'meeting_id'));
	
	
}
?>
