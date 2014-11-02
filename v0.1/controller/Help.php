<?php

require_once './lib/ApiHelper.php';
require_once './model/Help.php';

class HelpCtrl {
	public function Init() {
		ApiHelper::MethodSwitch('Help');
	}

	public function GETHelp() {
		$data = new HelpModel();
	    ApiHelper::HttpResponse('success', null, $data->Get());
	}
}