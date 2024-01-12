<?php

namespace Doors\MyCommerce;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\UserTable;

class User
{
	public function getUserPersonalData(): array
	{
		$userId = $this->getUserId();

		$user = UserTable::getList([
			'filter' => ['ID' => $userId],
			'select' => ['ID',
                'NAME',
                'LAST_NAME',
                'EMAIL', 'PERSONAL_PHONE',
                'WORK_COMPANY',
                'WORK_DEPARTMENT',
                'WORK_FAX',
                'WORK_PHONE',
                'WORK_POSITION',
                'WORK_PAGER',
                'WORK_LOGO',
                'WORK_WWW',
                'WORK_MAILBOX',
                'WORK_NOTES'
            ],
		])->fetch();

		if ($user) {
			$userName = $user['NAME'];
			$userLastName = $user['LAST_NAME'];
			$userEmail = $user['EMAIL'];
			$userPhone = $user['PERSONAL_PHONE'];

            $userWorkCompany = $user['WORK_COMPANY'];
            $userWorkFax = $user['WORK_FAX'];
            $userWorkPhone = $user['WORK_PHONE'];
            $userWorkPosition = $user['WORK_POSITION'];
            $userWorkDepartment = $user['WORK_DEPARTMENT'];
            $userWorkPages = $user['WORK_PAGER'];
            $userWorkLogo = $user['WORK_LOGO'];
            $userWorkWWW = $user['WORK_MAILBOX'];
            $userWorkNotes = $user['WORK_NOTES'];

			return [
				'NAME' => $userName,
				'LAST_NAME' => $userLastName,
				'EMAIL' => $userEmail,
				'PERSONAL_PHONE' => $userPhone,

				'WORK_COMPANY' => $userWorkCompany,
				'WORK_FAX' => $userWorkFax,
				'WORK_PHONE' => $userWorkPhone,
				'WORK_POSITION' => $userWorkPosition,
				'WORK_DEPARTMENT' => $userWorkDepartment,
				'WORK_PAGER' => $userWorkPages,
				'WORK_LOGO' => $userWorkLogo,
				'WORK_MAILBOX' => $userWorkWWW,
				'WORK_NOTES' => $userWorkNotes,

			];
		}
		return []; // Return an empty array if the user is not found
	}

	public function getUserPartnerLogo($companyId)
	{
		$el = ElementTable::getList([
			'filter' => ['=ID' => $companyId],
			'select' => ['ID','PREVIEW_PICTURE','DETAIL_PICTURE'],
		])->fetch();

		if ($el['DETAIL_PICTURE'] > 0) {
			$fileData = \CFile::GetFileArray($el['DETAIL_PICTURE']);
			if ($fileData) {
				return $fileData;
			}
		}
		return null;
	}

	public function getUserCompanyId()
	{
		return $GLOBALS['USER_INFO']['COMPANY_INFO']['ID'];
	}

	public function getUserCompanyName()
	{
		return $GLOBALS['USER_INFO']['COMPANY_INFO']['NAME'];
	}

	private function getUserId()
	{
		/** @var \CUser $USER */
		global $USER;
		return $USER->GetID();
	}
}