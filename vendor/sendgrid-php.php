<?php
	error_reporting(0);
	header("Access-Control-Allow-Origin: http://cookspringfw.com");
	//header("Access-Control-Allow-Origin: http://localhost:4000");
	header('Access-Control-Allow-Headers: X-Requested-With');
	// respond to preflights
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		// return only the headers and not the content
		// only allow CORS if we're doing a GET - i.e. no saving for now.
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
			header("Access-Control-Allow-Origin: http://cookspringfw.com");
			//header("Access-Control-Allow-Origin: http://localhost:4000");			
			header('Access-Control-Allow-Headers: X-Requested-With');
		}
		exit;
	}
	
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		header('Content-Type: application/json');	
		require 'vendor/autoload.php';
		require 'lib/SendGrid.php';
		$template = file_get_contents("http://cookspringfw.com/email-template.html");
		$title = isset($_GET["title"]) ? $_GET["title"] : "Thanks for your contact!";
		$body =  isset($_GET["body"]) ? $_GET["body"] : "We'll contact you shortly.";
		$subject = isset($_GET["subject"]) ? $_GET["subject"] : "CookSpring Contact";
		$to = isset($_GET["to"]) ? $_GET["to"] : "info@cookspringfw.com";
		
		$name = isset($_GET["name"]) ? $_GET["name"] : "No Name";
		$phone = isset($_GET["phone"]) ? $_GET["phone"] : "No Phone";
		
		$msg = str_ireplace("<%body%>",$body,$template);
		$msg = str_ireplace("<%title%>",$title,$msg);
		$al = "";
		
		$status = $_GET["app"] ? 'We\'ve received your application.  We\'ll review it get back to you in the next couple of days!' : 'Thanks for reaching out! We\'ll be in touch.';
		if(isset($_GET["app"])){
			foreach($_GET as $key=>$val){
				$al .= "<strong>" . $key . ":</strong> " . $val . "<br />";
			}
			$al = str_ireplace("<%body%>",$al,$template);
			$al = str_ireplace("<%title%>","A New Application.",$al);
			$adminSub = "Application for ";
		}
		else{
			$al = str_ireplace("<%body%>",$name . " is interested in CookSpring.  They can be contacted at " . $phone . " or " . $to . ".",$template);
			$al = str_ireplace("<%title%>","A New Contact.",$al);
			$adminSub = "Interest in ";
		}
		
		
		
		
		$sendgrid = new SendGrid('summit-tech', '$nF7dEDi1uMSpyu#',array("turn_off_ssl_verification" => true));
		$email = new SendGrid\Email();
		$email->addTo($to)->
		setFrom('info@cookspringfw.com')->
		setSubject($subject)->
		setText(strip_tags($body))->
		setHtml($msg);
		$sendgrid->send($email);
		
		$alert = new SendGrid\Email();
		$alert->addTo('info@cookspringfw.com')->
		setFrom('info@cookspringfw.com')->
		setSubject($adminSub . "Cookspring")->
		setHtml($al);
		
		$sendgrid->send($alert);
		echo json_encode(array(
		'status' => $status,
		'statusTitle' => 'Success!',
		'to' => $to,
		'title' => $title,
		'body' => $body,
		'message' => $msg
		));
		}else{
		header('HTTP/1.1 403 Forbidden');
		echo "<code>Sorry hacker, this is only available to our people!</code>";
	}
	
?>			