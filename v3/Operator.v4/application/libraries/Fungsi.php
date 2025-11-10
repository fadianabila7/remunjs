<?php

class Fungsi
{

	private $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		date_default_timezone_set("Asia/Jakarta");
	}

	public function buat_Captcha()
	{
		$options = array(
			'img_path'    => './assets/captcha/',
			'img_url'     => base_url() . 'assets/captcha/',
			'img_width'   => '150',
			'img_height'  => 35,
			'expiration'  => 7200,
			'font_size'   => 30,
			'word_length' => 4,
			'pool'        => '0123456789',

			// White background and border, black text and red grid
			'colors' => array(
				'background' => array(255, 255, 255),
				'border'     => array(255, 255, 255),
				'text'       => array(0, 0, 0),
				'grid'       => array(255, 40, 40)
			)
		);

		$files    = glob('assets/captcha/*'); //get all file names
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file); //delete file
			}
		}
		$cap      = create_captcha($options);
		$image    = $cap['image'];
		$this->ci->session->unset_userdata('captchaCode');
		$this->ci->session->set_userdata('captchaCode', $cap['word']);

		return $image;
	}

	public function refresh_Captcha()
	{
		$options = array(
			'img_path'    => './assets/captcha/',
			'img_url'     => base_url() . 'assets/captcha/',
			'img_width'   => '150',
			'img_height'  => 35,
			'expiration'  => 7200,
			'font_size'   => 30,
			'word_length' => 4,
			'pool'        => '0123456789',

			// White background and border, black text and red grid
			'colors' => array(
				'background' => array(255, 255, 255),
				'border'     => array(255, 255, 255),
				'text'       => array(0, 0, 0),
				'grid'       => array(255, 40, 40)
			)
		);

		$files    = glob('assets/captcha/*'); //get all file names
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file); //delete file
			}
		}
		$cap      = create_captcha($options);
		$image    = $cap['image'];
		$this->ci->session->unset_userdata('captchaCode');
		$this->ci->session->set_userdata('captchaCode', $cap['word']);

		echo $image;
	}

	function time_expire($from, $to = null)
	{
		$output = "";
		$to = (($to === null) ? (time()) : ($to));
		$to = ((is_int($to)) ? ($to) : (strtotime($to)));
		$from = ((is_int($from)) ? ($from) : (@strtotime($from)));

		$units = array(
			"Tahun"  => 29030400,   // seconds in a year   (12 months)
			"Bulan"  => 2419200,    // seconds in a month  (4 weeks)
			"Minggu" => 604800,     // seconds in a week   (7 days)
			"Hari"   => 86400,      // seconds in a day    (24 hours)
			"Jam"    => 3600,       // seconds in an hour  (60 minutes)
			"Menit"  => 60,         // seconds in a minute (60 seconds)
			"Detik"  => 1           // 1 second
		);

		$diff   = abs($from - $to);
		$suffix = (($from > $to) ? ("dari sekarang") : ("yang lalu"));
		$ex     = (($from > $to) ? ("") : ("Hangus"));

		foreach ($units as $unit => $mult)
			if ($diff >= $mult) {
				$and = (($mult != 1) ? ("") : (" "));
				$output .= ", " . $and . intval($diff / $mult) . " " . $unit . ((intval($diff / $mult) == 1) ? ("") : (" "));
				$diff -= intval($diff / $mult) * $mult;
			}
		$output .= " " . $suffix;
		$output = substr($output, strlen(", "));

		if ($from > $to) {
			return $output;
		} else {
			return $ex;
		}
	}

	function real_time($from, $to = null)
	{
		$output = "";
		$to = (($to === null) ? (time()) : ($to));
		$to = ((is_int($to)) ? ($to) : (strtotime($to)));
		$from = ((is_int($from)) ? ($from) : (strtotime($from)));

		$units = array(
			"Tahun"  => 29030400,   // seconds in a year   (12 months)
			"Bulan"  => 2419200,    // seconds in a month  (4 weeks)
			"Minggu" => 604800,     // seconds in a week   (7 days)
			"Hari"   => 86400,      // seconds in a day    (24 hours)
			"Jam"    => 3600,       // seconds in an hour  (60 minutes)
			"Menit"  => 60,         // seconds in a minute (60 seconds)
			"Detik"  => 1           // 1 second
		);

		$diff   = abs($from - $to);
		$suffix = (($from > $to) ? ("dari sekarang") : ("yang lalu"));

		foreach ($units as $unit => $mult)
			if ($diff >= $mult) {
				$and = (($mult != 1) ? ("") : (" "));
				$output .= ", " . $and . intval($diff / $mult) . " " . $unit . ((intval($diff / $mult) == 1) ? ("") : (""));
				$diff -= intval($diff / $mult) * $mult;
			}
		$output .= " " . $suffix;
		$output = substr($output, strlen(", "));

		return $output;
	}
}
