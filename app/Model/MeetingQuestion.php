<?php
class MeetingQuestion extends AppModel{
	
	var $name='MeetingQuestion';
	var $actsAs = array('Containable');
	var $hasMany = array('QuestionOption'=>array('className'=>'QuestionOption','foreignKey'=>'meeting_question_id'));
	
}
?>
