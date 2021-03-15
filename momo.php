<?php
error_reporting(0);
set_time_limit(0); // set time excute browser
require 'Class/Class.Imap.php'; /* connect to gmail */
require 'Class/Class.Momo.Get.Transaction.php'; /* Momo support get contents */

$imap = new Imap(); // gọi tới thư viện Imap
$connection_result = $imap->connect(
	'{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', // cái này là imap của gmail(ko được thay)
	'email@gmail.com', // email
	'osrgdldbrxgwvgxj' // mật khẩu ứng dụng
);



$messages = $imap->	setLimit(1) // giới hạn lấy ra tin nhắn từ momo
				 ->	getMessages(
						'desc', // Sắp Xếp => desc là gần đây nhất, asc là cũ nhất
						'FROM "no-reply@momo.vn"' // query lọc thư đến - ALL là không lọc
					);
$momo = new Momo_Get_Transaction();
$momo->message = $messages;
$transaction = $momo->Momo_Transaction();

$data = file_get_contents('data.txt');


if($transaction['status']) {
	if($transaction['data'][0]) {
		if(tim_chuoi($data, $transaction['data'][0]['trans_id']) == false) {

			$nd = $transaction['data'][0]['trans_id']."|".$transaction['data'][0]['money']."|".$transaction['data'][0]['from']."|".$transaction['data'][0]['phone']."|".$transaction['data'][0]['note']."|".$transaction['data'][0]['time']."*";
			
			$f = fopen('data.txt', 'a');
			fwrite($f, $nd);
			fclose($f);
			echo $nd;
		}else {
			echo 'chưa có giao dịch mới!';
		}
	}
}else {
	echo 'email mới nhất không phải là email cộng tiền!';
}


function tim_chuoi($chuoi_ban_dau, $chuoi_con) {
	$pos = strpos($chuoi_ban_dau, $chuoi_con);
	if ($pos !== false) return true; else return false;
}
