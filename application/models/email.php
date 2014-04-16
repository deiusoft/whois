<?php

class Email extends Eloquent
{
	public static $timestamps = false;

	public static function email_to_img($email, $font_size = 13)
	{
		$exists = Email::where('email', '=', $email)->first();

		if (!$exists)
		{
			//create image
			$width = imagefontwidth($font_size) * strlen($email);
			$height = imagefontheight($font_size);

			$im = imagecreate($width, $height);

			$bg = imagecolorallocate($im, 255, 255, 255);
			$textcolor = imagecolorallocate($im, 0, 0, 0);

			imagestring($im, 5, 0, 0, $email, $textcolor);
			
			//get image contents
			ob_start();
			imagepng($im);
			$contents =  ob_get_contents();
			ob_end_clean();

			imagedestroy($im);
			
			$image_code = base64_encode($contents);

			Email::create(array('email' => $email, 'image_code' => $image_code));	
			
			return $image_code;
		}

		return $exists->image_code;
	}
}