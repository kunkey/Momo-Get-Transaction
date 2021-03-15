<?php
require 'Class.Momo.Get.Content.php';

Class Momo_Get_Transaction extends Momo_Get_Contents {
	public $message;
	public function Momo_Transaction() {
		$i = 0;
		$data['total_money'] = 0;
		foreach ($this->message as $_trans) {
			if($this->tim_chuoi($_trans['subject'], 'Bạn vừa nhận được tiền từ')) {
				$this->string = $_trans['message'];
				$ex_trans[$i] = $this->export_contents();
				$data['total_money'] = $data['total_money'] + $ex_trans[$i]['money'];
				$i++;
			}
		}

		if(count($ex_trans) > 0) {
			$data['status'] = true;
			$data['message'] = 'Lấy lịch sử thành công!';
			$data['count'] = count($ex_trans);
		}else {
			$data['status'] = false;
			$data['message'] = 'Lấy lịch sử thất bại';
			$data['count'] = 0;
		}
		$data['data'] = $ex_trans;

		return $data;
	}
}