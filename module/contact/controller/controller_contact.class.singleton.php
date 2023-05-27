<?php
	class controller_contact {
		
        static $_instance;

		function __construct() {
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		function view(){
			common::load_view('top_page_contact.php', VIEW_PATH_CONTACT . 'contact_list.html');
		}
		
		function send_contact_us(){
			$message = ['type' => 'contact',
						'inputName' => $_POST['name'], 
						'fromEmail' => $_POST['email'], 
						'inputSubject' => $_POST['subject'], 
						'inputMessage' => $_POST['message']];

			$email = json_decode(mail::send_email($message), true);
			
			if (!empty($email)) {
				echo json_encode('Done!');
				return;  
			} else {
				echo json_encode('Error!');
			}
		}
	}
?>
