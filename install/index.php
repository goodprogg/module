<?php

class doors_mycommerce extends CModule
{
	public $MODULE_ID = 'doors.mycommerce';
	public $MODULE_NAME = 'Коммерческое предложение';
	public $MODULE_DESCRIPTION = "Модуль коммерческого предложения";
	public $MODULE_VERSION = "0.3";
	public $MODULE_VERSION_DATE = "2023-10-20 11:00:00";
	public $PARTNER_NAME = 'Вячеслав Килин';
	public $PARTNER_URI = 'vyacheslaw.kili@mail.ru';

	function DoInstall()
	{
		RegisterModule($this->MODULE_ID);
	}

	function DoUninstall()
	{
		UnRegisterModule($this->MODULE_ID);
	}
}