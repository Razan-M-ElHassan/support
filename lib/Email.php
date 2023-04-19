<?php
	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\SMTP;
	//use PHPMailer\PHPMailer\Exception;

	class Email 
	{
		private $mailer;
		private $Error = "";
		private $config= array();
		private $db;
		 
		
		function __construct()
		{
			//require LIB.'PHPMailer/Exception.php';
			require LIB.'PHPMailer/PHPMailer.php';
			require LIB.'PHPMailer/SMTP.php';
			
			$this->mailer = new PHPMailer();
			
			//Get Config
			require_once LIB.'database.php';
			$this->db = new database();
			
			$configs = $this->db->select("SELECT conf_name, conf_val 
											FROM ".DB_PREFEX."config 
											WHERE conf_name LIKE '%EMAIL%' " ,array());
			foreach($configs as $val)
			{
				$this->config[$val['conf_name']] = $val['conf_val'];
			}
			
			try {
				//Server settings
				
				$this->mailer->isSMTP();                        // Send using SMTP
	            $this->mailer->CharSet      = 'UTF-8';						
				//$this->mailer->SMTPDebug    = 2;		// FOR ONLINE
				$this->mailer->SMTPDebug    = SMTP::DEBUG_OFF;		
				
				$this->mailer->Host 		= $this->config['EMAIL_HOST'];		// Set the SMTP server to send through
				$this->mailer->SMTPAuth 	= $this->config['EMAIL_SMTP_AUTH'] == 1;	// Enable SMTP authentication
				$this->mailer->Port 		= $this->config['EMAIL_PORT'];
				$this->mailer->Username   	= $this->config['EMAIL_SEND_ADD'];	// SMTP username
				$this->mailer->Password		= $this->config['EMAIL_SEND_PASS'];	// SMTP password
				//$this->mailer->SMTPSecure 	= 'ssl';            // FOR ONLINE Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$this->mailer->SMTPSecure 	= PHPMailer::ENCRYPTION_STARTTLS;
				
				$this->mailer->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
            }catch (Exception $e) {
				echo $e.ErrorMessage;
				$this->Error = $this->mailer->ErrorInfo;
			}
		}
		
		//Send Email Message
		public function send_email($TO,$TITLE,$MSG,$from= null,$from_title = TITLE,$ATTACH=array())
		{
			if(!empty($this->Error))
			{
				return $this->Error;
			}
			if(empty($from))
			{
				$from = $this->config['EMAIL_SEND_ADD'];
			}
			try{
				//Recipients
				$this->mailer->setFrom($from, session::get('TITLE'));   
				//This is the email your form sends From

                //$this->mailer->addReplyTo($from, $from_title);

				//Add Recipients
				if(is_array($TO))
				{
					foreach($TO as $val)
					{
						$this->mailer->addAddress($val,'مستخدم '); 
					}
				}else
				{
					$this->mailer->addAddress($TO,'مستخدم '); 
				}
			
				//Add Attachments
				if(!empty($ATTACH))
				{
					if(is_array($ATTACH))
					{
						foreach($ATTACH as $val)
						{
							$this->mailer->addAttachment($val); 
						}
					}else
					{
						$this->mailer->addAttachment($ATTACH);  
					}
				}
			
				// Content
				$this->mailer->isHTML(true);                                  // Set email format to HTML
				$this->mailer->Subject	= $TITLE;
				//$this->mailer->msgHTML	= $MSG;
				//$this->mailer->AltBody	= $MSG;
				$this->mailer->Body		= $MSG;
				if(!$this->mailer->send())
				{
					$this->Error .="Mailer Error: " . $this->mailer->ErrorInfo;
				}
				
			}catch (Exception $e) {
				return array('Error'=>"Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
			}
			
			if(!empty($this->Error))
			{
				return $this->Error;
			}else
			{
				return true;
			}
		}
		
		//Send SMS Message
		public function send_SMS($to,$MSG)
		{
			return true;
		}
		
		public function forget($name,$email,$id,$time,$from = EMAIL_ADD)
		{
			$MSG = "<html><body>
					<div dir='rtl'>
						الزميل $name <br/>
						لقد طلبت اعادة ضبط كلمة الدخول الخاصة بك<br/>
						اذا كان هذا الطلب منك, بامكانك اعادة ضبط كلمة المرور خلال 24 ساعة من $time باستخدام الرابط: 
                        <a href='".URL."login/resetpassword/".$id."'>".URL."login/resetpassword/".$id."</a><br/>
						اذا لم تكن انت , تجاهل هذا الايميل <br/>
					</div>
					</body></html>";
			
            return $this->send_email($email,"إعادة ضبط كلمة المرور",$MSG,$from = EMAIL_SEND_ADD,$from_title = TITLE,$ATTACH=array());

			
		}
	}
?>