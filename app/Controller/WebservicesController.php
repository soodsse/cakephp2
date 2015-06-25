<?php
ob_start();
class WebservicesController extends AppController{
	
/*-----------------------------function for registration---------------------------------*/
	function registration()
	{
		//echo "helloaxs";die;
		$this->loadModel('User');
		if($this->request->is('get'))
		{ //echo "hello";die;
			if(!empty($_GET['email']))
			{	
				if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $_GET['email'])){
                   $user_email = $_GET['email'];
                }else {
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Please fill the valid format of email like (test@gmail.com) ';
					echo json_encode($response); die;
				}
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please Enter the email.';
				echo json_encode($response); die;
			}
			if(!empty($_GET['fullname']))
			{
				$user_fullname = $_GET['fullname'];
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please Enter the full name.';
				echo json_encode($response); die;
			}
			
			if(!empty($_GET['deviceID']))
			{
				$user_device_id = $_GET['deviceID'];
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please send the deviceID.';
				echo json_encode($response); die;
			}
				
			if($_GET['facebookLoginFlag'] !='yes')
			{  
		       if(empty($_GET['password'])){
					$response['statusCode']=0;
					$response['successful']='No';
				  	$response['message']='Please enter the password.';
					echo json_encode($response); die; 
			   }
			}
			if(!empty($_GET['password'])){
				$user_password = $_GET['password'];
			}else{
				$user_password = '';
			}
			if(!empty($_GET['facebookLoginFlag']) && isset($_GET['facebookLoginFlag']))
			{
				$facebookLoginFlag = $_GET['facebookLoginFlag'];
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='please send the facebook flag.';
				echo json_encode($response); die;
			}
			
			$data['User']['fullname'] = $user_fullname;
			$data['User']['email'] = $user_email;
			$data['User']['deviceid'] = $user_device_id;
			$data['User']['facebookloginflag']= $facebookLoginFlag;
			if(!empty($user_password)){
				$data['User']['password']=md5($user_password);
			}else{ 
				$data['User']['password']='';
			}
				
			$userdata=$this->User->find('first',array('conditions'=>array('User.email'=>$user_email)));
			if(empty($userdata))
			{
				if($this->User->save($data)){
					$last_id=$this->User->getLastInsertId();
					$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$last_id),'fields'=>array('id','email','deviceid','facebookloginflag','fullname')));
					$response['successful']='Yes';
					$response['statusCode']=1;
					if($user_info['User']['facebookloginflag'] == 'yes'){
						$response['message']='you have successfully login with facebook.';
					}else{
						$response['message']='You have successfully registered with app.';
					}
					$response['userId']=$user_info['User']['id'];
					$response['deviceID']=$user_info['User']['deviceid'];
					$response['facebookLoginFlag']=$user_info['User']['facebookloginflag'];
					$response['email']=$user_info['User']['email'];
					$response['fullname']=$user_info['User']['fullname'];
					echo json_encode($response); die;
				}else{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='please fill the all values.';
					echo json_encode($response); die;
				}
			}else{
				//echo "<pre>";print_r($userdata);die;
				if($userdata['User']['facebookloginflag'] =='yes' && $facebookLoginFlag=='yes')
				{
					//echo "<pre>";print_r($userdata);die;
					$response['successful']='Yes';
					$response['statusCode']=1;
					$response['message']='you have successfully login with facebook.';
					$response['userId']=$userdata['User']['id'];
					$response['deviceID']=$userdata['User']['deviceid'];
					$response['facebookLoginFlag']=$userdata['User']['facebookloginflag'];
					$response['email']=$userdata['User']['email'];
					$response['fullname']=$userdata['User']['fullname'];
					echo json_encode($response); die;
					//$response['message']='You have already signed up using the facebook and You are already a member of Audience response. Please click on forgot password.';
				}else{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='You have already registered with this email id on app.';
					echo json_encode($response); die;
				}
				
			}
		}
					
		
	}
	
/*-----------------------------function for login---------------------------------*/

	function login()
	{
		$this->loadModel('User');
		if($this->request->is('get'))
		{
			if(!empty($_GET['email']))
			{	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $_GET['email'])){
                   $user_email = $_GET['email'];
				   $this->chk_email($user_email);
                }else {
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Please fill the valid format of email like (test@gmail.com)';
					echo json_encode($response); die;
				}
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please Enter the email.';
				echo json_encode($response); die;
			}
			if(!empty($_GET['deviceID']))
			{
				$user_device_id = $_GET['deviceID'];
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please send the deviceID.';
				echo json_encode($response); die;
			}
				
			if(!empty($_GET['password']))
			{
				$user_password = $_GET['password'];
			}else{ 
				$user_password='';
			}
			
			if(!empty($_GET['facebookLoginFlag']) && isset($_GET['facebookLoginFlag']))
			{
				$facebookLoginFlag = $_GET['facebookLoginFlag'];
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='please send the facebook flag.';
				echo json_encode($response); die;
			}
		
				$user_info_facebook=$this->User->find('first',array('conditions'=>array('User.email'=>$user_email),'fields'=>array('id','email','deviceid','facebookloginflag','fullname')));
			if(trim(@$user_info_facebook['User']['facebookloginflag'])=='yes' && trim($facebookLoginFlag)=='yes')
			{ 
				if(!empty($user_info_facebook)){
					$response['message']='you have successfully login with facebook.';
					$response['successful']='Yes';
					$response['statusCode']=1;
					$response['userId']=$user_info_facebook['User']['id'];
					$response['deviceID']=$user_info_facebook['User']['deviceid'];
					$response['facebookLoginFlag']=$user_info_facebook['User']['facebookloginflag'];
					$response['email']=$user_info_facebook['User']['email'];
					$response['fullname']=$user_info_facebook['User']['fullname'];
					echo json_encode($response); die;
				}
			}elseif(trim(@$user_info_facebook['User']['facebookloginflag'])!='Yes' && trim($facebookLoginFlag) =='yes'){
				//print_r($user_info_facebook);die;
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='You have registerd with app, please signin with app.';
				echo json_encode($response); die;
			}
			else{
				$user_info_by_email=$this->User->find('first',array('conditions'=>array('User.email'=>$user_email),'fields'=>array('id','email','deviceid','facebookloginflag','fullname')));
				
				$user_info_by_password=$this->User->find('first',array('conditions'=>array('User.email'=>$user_email,'User.password'=>md5($user_password)),'fields'=>array('id','email','deviceid','facebookloginflag','fullname')));
				
				if(empty($user_info_by_email))
				{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Email id does not exist.';
					echo json_encode($response); die;
				}
				
				if(empty($user_info_by_password))
				{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='please fill the valid password.';
					echo json_encode($response); die;
				}
				
				if(!empty($user_info_by_email) && !empty($user_info_by_password))
				{
					$response['message']='you have successfully login with app.';
					$response['successful']='Yes';
					$response['statusCode']=1;
					$response['userId']=$user_info_by_email['User']['id'];
					$response['deviceID']=$user_info_by_email['User']['deviceid'];
					$response['facebookLoginFlag']=$user_info_by_email['User']['facebookloginflag'];
					$response['email']=$user_info_by_email['User']['email'];
					$response['fullname']=$user_info_by_email['User']['fullname'];
					echo json_encode($response); die;
				}
			}
			
		}
					
		
	}
 /*---------------------------------------function for meeting autentication -----------------------------------------------*/
 
 function meeting_authentication()
 {
	$this->loadModel('Meeting');
	$this->loadModel('User'); 
	$this->loadModel('UserHistory'); 
	if($this->request->is('get'))
	{
		if(is_numeric($_GET['userId'])){
			$userid = $_GET['userId'];
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please enter valid user id.';
			echo json_encode($response); die;
		}
		$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$_GET['userId'])));
		if(empty($user_info))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='User does not exist.';
			echo json_encode($response); die;
		}
		if(!empty($_GET['meetingCode']) && !empty($_GET['userId']))
		{
			$meeting_info=$this->Meeting->find('first',array('conditions'=>array('meetingCode'=>$_GET['meetingCode']),'recursive'=>2));
			//print_r($meeting_info);die;
			if(!empty($meeting_info))
			{	
				$data['UserHistory']['user_id']=$_GET['userId'];
				$data['UserHistory']['meetingcode']=$_GET['meetingCode'];
				$this->UserHistory->save($data);
				$response['message']='You have successfully Join the meeting.';
				$response['statusCode']=1;
				$response['successful']='Yes';
				$response['meetingData']=$meeting_info['Meeting'];
				if(!empty($meeting_info['MeetingQuestion'][0])){
					$response['questionData']=$meeting_info['MeetingQuestion'][0];
				}
				echo json_encode($response); die;
				
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Please Enter valid Meeting code.';
				echo json_encode($response); die;
			}
		} else {
			
			$dynaicalert='';
			
			if($_GET['meetingCode']=='' || empty($_GET['meetingCode'])){
				$dynaicalert='meeting id.';
			} else{
				$dynaicalert='user id.';
			}
			
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please enter correct '.$dynaicalert.'';
			echo json_encode($response); die;
		}
	}
 }
 
 /*---------------------------------------function for Answer submision-----------------------------------------------*/
 
 function answer_submission()
 {
	$this->loadModel('ReceivedAnswer');
	$this->loadModel('Meeting');
	$this->loadModel('User');
	$this->loadModel('MeetingQuestion');
	$this->loadModel('QuestionOption');
	if($this->request->is('get'))
	{	
		if(empty($_GET['meetingCode']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the meeting code.';
			echo json_encode($response); die;	
		}
		if(empty($_GET['userId']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the user id.';
			echo json_encode($response); die;	
		}
		if(empty($_GET['questionId']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the Question.';
			echo json_encode($response); die;	
		}
		if(empty($_GET['selcetedOptionId']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the option.';
			echo json_encode($response); die;	
		}
		if(!empty($_GET['meetingCode']) && !empty($_GET['userId']) && !empty($_GET['questionId']) && !empty($_GET['selcetedOptionId']))
		{      
				
				$meetingcode = $_GET['meetingCode'];
				
				if(is_numeric($_GET['questionId'])){
					$questionid = $_GET['questionId'];
				}else{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Please enter valid question id.';
					echo json_encode($response); die;
				}
				if(is_numeric($_GET['userId'])){
					$userid = $_GET['userId'];
				}else{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Please enter valid user id.';
					echo json_encode($response); die;
				}
				if(is_numeric($_GET['selcetedOptionId'])){
					$selectoptionid = $_GET['selcetedOptionId'];
					$option_info=$this->QuestionOption->find('first',array('conditions'=>array('QuestionOption.id'=>$selectoptionid)));
					if($selectoptionid < 0 || $selectoptionid == 0)
					{
						$response['message']='Please enter valid option id.';
						echo json_encode($response); die;
					}
					if(empty($option_info))
					{
						$response['message']='Option Id does not exist.';
						echo json_encode($response); die;
					}
					
				}else{
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='Please enter valid option id.';
					echo json_encode($response); die;
				}
				
				$meeting_info=$this->Meeting->find('first',array('conditions'=>array('meetingCode'=>$meetingcode),'recursive'=>-2));
				$question_info= $this->MeetingQuestion->find('first',array('conditions'=>array('MeetingQuestion.id'=>$questionid),'recursive'=>2));
				$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
				if(empty($meeting_info)){
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='please fill the valid meeting code.';
					echo json_encode($response); die;
				}
				if(empty($user_info)){
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='User Does not exist.';
					echo json_encode($response); die;
				}
				if(empty($question_info)){
					$response['statusCode']=0;
					$response['successful']='No';
					$response['message']='please fill the valid Question.';
					echo json_encode($response); die;
				}
				
				
				if(!empty($question_info))
				{
					$data['ReceivedAnswer']['meetingcode'] = $meetingcode;
					$data['ReceivedAnswer']['user_id'] = $userid;
					$data['ReceivedAnswer']['question_id'] = $questionid;
					$data['ReceivedAnswer']['answer_id'] = $selectoptionid;
					//print_r($data);die;
					$this->ReceivedAnswer->save($data);
					$response=$meeting_info;
					if(!empty($question_info)){
						$response['questionData']=$question_info;
					}else{
						$response['questionData']='';
					}
					$response['statusCode']=1;
					$response['successful']='Yes';
					$response['message']='Your answer have successfully submitted.';					
					echo json_encode($response); die;
				}
		}elseif(empty($_GET['selcetedOptionId'])){
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please enter the valid option id.';
			echo json_encode($response); die;
		}
		else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please fill the all value of the field like meetingcode,userId,questionId,selectoptionId.';
			echo json_encode($response); die;
		}
	}
	 
 }
 
  /*----------------------------------------get a Question to Admin  -------------------------------------------------*/
  
  function post_question_to_admin()
  {
	$this->loadModel('UserQuestion');
	$this->loadModel('Meeting');
	if($this->request->is('get'))
	{	
		if(empty($_GET['meetingCode']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the meeting code.';
			echo json_encode($response); die;	
		}
		if(empty($_GET['userId']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the user id.';
			echo json_encode($response); die;	
		}
		if(empty($_GET['questionAsked']))
		{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please Enter the Question.';
			echo json_encode($response); die;	
		}
		if(!empty($_GET['meetingCode']) && !empty($_GET['userId']) && !empty($_GET['questionAsked']))
		{
			$data['UserQuestion']['meetingcode'] = $_GET['meetingCode'];
			$data['UserQuestion']['user_id'] = $_GET['userId'];
			$this->chk_userid($data['UserQuestion']['user_id']);
			$this->chk_meetingcode($data['UserQuestion']['meetingcode']);
			$meetingid=$this->Meeting->find('first',array('conditions'=>array('Meeting.meetingcode'=>$data['UserQuestion']['meetingcode'])));
			$data['UserQuestion']['question_text'] = $_GET['questionAsked'];
			$data['UserQuestion']['meeting_id'] = $meetingid['Meeting']['id'];
			$this->UserQuestion->save($data);
			$userquestion_id=$this->UserQuestion->getLastInsertId();
			$userquestion_data=$this->UserQuestion->find('first',array('conditions'=>array('UserQuestion.id'=>$userquestion_id)));
			
			$meeting_history=$this->Meeting->find('first',array('conditions'=>array('Meeting.meetingcode'=>$data['UserQuestion']['meetingcode']),'recursive'=>2));
			
			if(!empty($userquestion_data))
			{
				$response['statusCode']=1;
				$response['message']='your question has been submitted successfully.';
				$response['questionData']=$userquestion_data;
				$response['meetingData']=$meeting_history;
				echo json_encode($response); die;
			}
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='please send the valid userId and meeting code and question.';
			echo json_encode($response); die;
		}
	}  
  }
  
 /*---------------------------------Meeting Code listing  attended till date---------------------------------------------*/
  
  function meeting_code_detail()
  {
	$this->loadModel('Meeting');
	$this->loadModel('UserHistory');
	$this->loadModel('UserQuestion');
	if($this->request->is('get'))
	{
		if(!empty($_GET['userId']))
		{
			$user_id = $_GET['userId'];
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please enter the user id.';
			echo json_encode($response); die;
		}
		$this->chk_userid($user_id);
		//echo $user_id; die;
		$meeting_info = $this->UserQuestion->find('all',array('conditions'=>array('UserQuestion.user_id'=>$user_id),'group'=>'UserQuestion.meetingcode'));
		if(empty($meeting_info)){
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='User has not attend any meeting';
			echo json_encode($response); die;
		}
		
	    $meeting_history=array();
			//echo "<pre/>"; 
			//print_r($meeting_info); die;
		foreach($meeting_info as $meetngcodes){
			//echo "<pre>"; print_r($meetngcodes); die;	
			$this->Meeting->contain('UserQuestion.user_id = '.$user_id.'');
			$meeting_history[]=$this->Meeting->find('first',array('conditions'=>array('Meeting.meetingcode'=>$meetngcodes['UserQuestion']['meetingcode']),'recursive'=>2,'contain'=>array('UserQuestion.id','UserQuestion.user_id','UserQuestion.meetingcode','UserQuestion.question_text','UserQuestion.date_added')));					
		}
		/*$k=0;
		$values=array();
		foreach($meeting_history as $key=>$value){
			if(empty($value['UserQuestion'])){
				$value['UserQuestion'] = "you did not ask any question";
				$values[$k]=$value;
			}else{
				$values[$k]=$value;
			}
			$k++;
		}
		
		//print_r($values);*/

		if(empty($meeting_history)){
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please enter the valid User Id';
			echo json_encode($response); die;
		}
		
		if(!empty($meeting_history) && is_array($meeting_history))
		{
			$response['statusCode']=1;
			$response['successful']='Yes';
			$response['meeting_data']=$meeting_history;
			echo json_encode($response); die;
			
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='User has not attend any meeting';
			echo json_encode($response); die;
		}
	}  
  }
  
  /*----------------------------------Account details---------------------------------------------*/
  
  function account_details()
  {
    $this->loadModel('User');
	if($this->request->is('get'))
	{
		if(!empty($_GET['userId']))
		{
			$user_id = $_GET['userId'];
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please send the User ID.';
			echo json_encode($response); die;
		}
		if(is_numeric($user_id)){
			$this->chk_userid($user_id);
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please fill the valid user id.';
			echo json_encode($response); die;
		}
		$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fields'=>array('id','email','deviceid','facebookloginflag','fullname','date_added')));
		if(!empty($user_info))
		{
			$response['statusCode']=1;
			$response['userId']=$user_info['User']['id'];
			$response['deviceID']=$user_info['User']['deviceid'];
			$response['facebookLoginFlag']=$user_info['User']['facebookloginflag'];
			$response['email']=$user_info['User']['email'];
			$response['fullname']=$user_info['User']['fullname'];
			echo json_encode($response); die;
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please send the valid user ID, this id does not exist in our database.';
			echo json_encode($response); die;
		}
	}
  }
  
  /*--------------------------------change password---------------------------------------------*/
  
  function forget_password()
  {
	$this->loadModel('User');
	if($this->request->is('get'))
	{
		if(!empty($_GET['userEmail']))
		{
			if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $_GET['userEmail'])){
                  $user_email = $_GET['userEmail'];
                }else {
					$response['message']='Please fill the valid format of email like (test@gmail.com)';
					echo json_encode($response); die;
				}
			$user_info_by_email=$this->User->find('first',array('conditions'=>array('User.email'=>$user_email)));
			if(empty($user_info_by_email))
			{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='Email id does not exist';
			    echo json_encode($response); die;
			}
		}else{
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please Enter the email.';
			echo json_encode($response); die;
		}
		if(!empty($_GET['userEmail']))
		{
			$new_password = $this->RandomPasswordGenerator(6);	
			$pass=md5($new_password);
			$this->User->updateAll(array('User.password'=>"'".$pass."'"),array('User.email'=>$user_email));
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: meetingleader" . "\r\n";
			$msg='Your Password has been successfully Changed , you can login with new password.'."</br></br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ " .$new_password.' }';
			if(mail($user_email,"Your New Password",$msg,$headers))
			{
				$response['statusCode']=1;
				$response['successful']='Yes';
				$response['message']='Password has been successfully Changed and New password has been successfully sent on your email address.';
				//$response['user_new_password']=$new_password;
				echo json_encode($response); die;
			}else{
				$response['statusCode']=0;
				$response['successful']='No';
				$response['message']='email has not been sent';
			   echo json_encode($response); die;
			}
		}
	}
 }
 
 /*-------------------------------Edit Profile--------------------------------------------*/
 
	function edit_profile()
	{
		$this->loadModel('User');
		
		if(!empty($_GET['userId']))
		{  
			$userid=$_GET['userId'];
			$this->chk_integer($userid);
			$this->chk_userid($userid);
		}else{
			$response['statusCode']=0;
			$response['successful']="No";
			$response['message']='Please enter the User Id.';
		    echo json_encode($response); die;
		}
		
		if(empty($_GET['fullname']) && empty($_GET['password'])){			
			$response['statusCode']=0;
			$response['successful']="No";
		    $response['message']='Both fields are empty. Please enter name or password.';
			echo json_encode($response); die;
		} else {
		
			$fullname=$password='';
			if(!empty($_GET['fullname']))
			{
				$fullname=$_GET['fullname'];
			}
			
			if(!empty($_GET['password']))
			{
				$password=md5($_GET['password']);
			}
			
			$actMsg='';
			// Update User table according to fullname, password Or both. 
			if(!empty($fullname) && empty($password)){
				$this->User->updateAll(array('User.fullname'=>"'".$fullname."'"),array('User.id'=>$userid));
				$actMsg='name';
			}elseif(!empty($password) && empty($fullname)){
				$this->User->updateAll(array('User.password'=>"'".$password."'"),array('User.id'=>$userid));
				$actMsg='password';
			}elseif(!empty($fullname) && !empty($password)){
				$this->User->updateAll(array('User.fullname'=>"'".$fullname."'", 'User.password'=>"'".$password."'"),array('User.id'=>$userid));
				$actMsg='name and password';
			}
			// End
			
			$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
			//print_r($user_info);die;
			$response['statusCode']=1;
			$response['successful']='Yes';
			$response['message']='Your '.$actMsg.' has been successfully updated.';
			$response['userId']=$user_info['User']['id'];
			$response['deviceID']=$user_info['User']['deviceid'];
			$response['facebookLoginFlag']=$user_info['User']['facebookloginflag'];
			$response['email']=$user_info['User']['email'];
			$response['fullname']=$user_info['User']['fullname'];
			echo json_encode($response); die;
		
		}
	}
  
 /*-------------------------------meeting code existence--------------------------------------*/
  
  function chk_meetingcode($meetingcode)
  {
	$this->loadModel('Meeting');
	$meeting_info=$this->Meeting->find('first',array('conditions'=>array('Meeting.meetingcode'=>$meetingcode)));
	if(empty($meeting_info))
	{
		$response['statusCode']=0;
		$response['successful']='No';
		$response['message']='Meeting Code does not exist, please fill the valid meeting code.';
		echo json_encode($response); die;
	}
  }
 
 /*--------------------------------user Id existence--------------------------------------*/
  
  function chk_userid($userid)
  {
	$this->loadModel('User');
	$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
	if(empty($user_info))
	{
		$response['statusCode']=0;
		$response['successful']='No';
		$response['message']='User does not exist, please fill the valid User Id.';
		echo json_encode($response); die;
	}
  }
  
  /*-------------------------------Email Id existence--------------------------------------*/
  
  function chk_email($email)
  {
	$this->loadModel('User');
	$user_info=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
	if(empty($user_info))
	{
		$response['statusCode']=0;
		$response['successful']='No';
		$response['message']='Email does not exist, please fill the valid Email id';
		echo json_encode($response); die;
	}
  }
  
  /*------------------------------check variable is integer or not ------------------------------------*/
  
  function chk_integer($userid)
  {
	  if(!is_numeric($userid)){
			$response['statusCode']=0;
			$response['successful']='No';
			$response['message']='Please fill the valid user id.';
			echo json_encode($response); die;
		}
  }
  
  /*-------------------------------Random password Genrator--------------------------------------*/
  
  function RandomPasswordGenerator($length=6)
  {
    		$string="";
    		$pattern="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    		for($i=0; $i<$length; $i++)
    		{
    			  $string .=$pattern{rand(0,61)};
    		}
    	return $string;
  } 
	
  
	
 /*---------------------------------------------------end here controller-------------------------------------------*/
}

 ?>