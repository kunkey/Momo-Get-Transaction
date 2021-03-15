<?php

Class Momo_Get_Contents {
	public $string;

	public function export_contents() {
		$this->string = str_replace("\n", "", $this->string);
		$this->string = str_replace("\"", "", $this->string);
		$this->string = trim($this->string, '\t');
		$this->string = trim($this->string, '\t');
		$this->string = trim($this->string, '\n');
		$this->string = trim($this->string, '\x0B');
		$this->string = trim($this->string, '\r');
		$mm = strip_tags($this->string);

		$momo['money'] = str_replace(".", "", trim($this->cut($mm, "Số tiền", "Người gửi")));
		$momo['from'] = trim($this->cut($mm, "Người gửi", "Số điện thoại người gửi"));
		$momo['phone'] = trim($this->cut($mm, "Số điện thoại người gửi", "Thời gian"));
		$momo['time'] = strtotime(str_replace("/", "-", str_replace("-", "", trim($this->cut($mm, "Thời gian", "Lời nhắn")))));
		$momo['note'] = trim($this->cut($mm, "Lời nhắn", "Mã giao dịch"));
		$momo['trans_id'] = trim($this->cut($mm, "Mã giao dịch", "Công ty"));
		return $momo;
	}

	public function cut($string, $start, $end) {
		$nd = explode($start,$string); 
		$re = explode($end,$nd[1]); 
		return $re[0];
	}

	public function tim_chuoi($chuoi_ban_dau, $chuoi_con) {
		$pos = strpos($chuoi_ban_dau, $chuoi_con);
		if ($pos !== false) return true; else return false;
	}

}