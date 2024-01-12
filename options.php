<?php
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$module_id = 'doors.mycommerce';

$tabs = [
	[
		'DIV' => 'settings',
		'TAB' => 'Главная',
		'TITLE' => 'Главные настройки модуля КП',
		'OPTIONS' => [
			[
				'catalog_group_id',
				'ID типа цены для товара в КП',
				13, // Значение по умолчанию
				['text', 5],
                'title' => 'Подсказка',
			],
		],
	],
];

if ($request->isPost() && check_bitrix_sessid()) {
	foreach ($tabs as $tab) {
		__AdmSettingsSaveOptions($module_id, $tab['OPTIONS']);
	}
}

$tabControl = new CAdminTabControl('tabControl', $tabs);

$tabControl->Begin();
?>

<form method="post"
      action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($request->get('mid')) ?>&amp;lang=<?= LANGUAGE_ID ?>">
	<?= bitrix_sessid_post() ?>
	<?php
	foreach ($tabs as $tab) {
		$tabControl->BeginNextTab();
		foreach ($tab['OPTIONS'] as $option) {
			$val = Option::get($module_id, $option[0]);
			$type = $option[3];
			?>
            <tr>
                <td width="40%" nowrap <?= $type[0] == 'textarea' ? 'class="adm-detail-valign-top"' : '' ?>>
                    <label for="<?= htmlspecialcharsbx($option[0]) ?>"><?= htmlspecialcharsbx($option[1]) ?></label>
                </td>
                <td width="60%">
					<?php if ($type[0] == 'checkbox'): ?>
                        <input type="checkbox" name="<?= htmlspecialcharsbx($option[0]) ?>"
                               id="<?= htmlspecialcharsbx($option[0]) ?>" value="Y"
							<?= $val == 'Y' ? 'checked' : '' ?>>
					<?php elseif ($type[0] == 'text'): ?>
                        <input type="text" size="<?= $type[1] ?>" maxlength="255"
                               value="<?= htmlspecialcharsbx($val) ?>"
                               name="<?= htmlspecialcharsbx($option[0]) ?>">
					<?php elseif ($type[0] == 'textarea'): ?>
                        <textarea rows="<?= $type[1] ?>" cols="<?= $type[2] ?>"
                                  name="<?= htmlspecialcharsbx($option[0]) ?>"><?= htmlspecialcharsbx($val) ?></textarea>
					<?php endif ?>
                </td>
            </tr>
			<?php
		}
	}
	$tabControl->Buttons(); ?>
    <input type="submit" name="apply" class="adm-btn-save" value="<?= Loc::getMessage('MAIN_SAVE') ?>"/>
    <input type="reset" name="reset" value="<?= Loc::getMessage('MAIN_RESET') ?>"/>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>"/>
</form>

<?php
$tabControl->End();
?>
