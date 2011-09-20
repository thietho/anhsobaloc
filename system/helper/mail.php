<?php
final class HelperMail {

	//Ham send mac dinh cho linux
	static public function send($to, $subject, $message, $headers, $servertype = "mail") {
		$mail = new Mail();
		
		$mail->IsHTML(true);
		
		if($servertype == "mail")
		{
			$mail->IsMail();
		}
		else
		{
			$mail->IsSMTP();
		}
		
		
		$mail->AddAddress($to, "");
		
		$mail->Subject = $subject;
		
		$mail->Body = $message;
		
		$mail->Headers = $headers;
		
		$mail->Send();
	}

	
	//Ham send ho tro tao header
	static public function sendmail($to, $subject, $message, $from_email, $servertype = "mail", $sender_name = "", $reply_email = ""  ) {
		$mail = new Mail();
		
		$mail->IsHTML(true);
		
		if($servertype == "mail")
		{
			$mail->IsMail();
		}
		else
		{
			$mail->IsSMTP();
		}
		
		if(is_array($to))
		{
			foreach($to as $item)
			{
				$mail->AddAddress($item[0], $item[1]);
			}
		}
		else
		{
			$mail->AddAddress($to, "");
		}
		
		if($from_email != "") 
		{
			$mail->From = $from_email;
		}
		else
		{
			$mail->From = "support@ben-solution.com";
		}
		
		
		
		if($sender_name != "") 
		{
			$mail->FromName = $sender_name;
		}
		else
		{
			$mail->FromName = "Cong thong tin anh";
		}
			
		if($reply_email != "") 
			$mail->Sender = $reply_email;
		
		
		$mail->Subject = $subject;
		
		$mail->Body = $message;
		
		$mail->Headers = $headers;
		
		return $mail->Send();
	}

}