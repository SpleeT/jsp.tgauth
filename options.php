<?php
defined('B_PROLOG_INCLUDED') || die;
use Bitrix\Main\Localization\Loc;

$moduleID = 'jsp.tgauth';

$aTabs = array(
    array(
        'DIV' => 'jsp_tgauth_options',
        'TAB' => Loc::getMessage('JSP_AUTH.MAIN_TAB'),
        'OPTIONS' => array(
            array(
                'JSP_AUTHORIZE_TOKEN',
                Loc::getMessage('JSP_AUTH.JSP_AUTHORIZE_TOKEN'),
                null,
                array('text')
            ),
            array(
                'JSP_REDIRECT_URL',
                Loc::getMessage('JSP_AUTH.JSP_REDIRECT_URL'),
                '/',
                array('text')
            )
        )
    )
);

if ($USER->IsAdmin()) {
    if (check_bitrix_sessid() && strlen($_POST['save']) > 0) {
        foreach ($aTabs as $aTab) {
            __AdmSettingsSaveOptions($moduleID, $aTab['OPTIONS']);
        }
        LocalRedirect($APPLICATION->GetCurPageParam());
    }
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);
?>
<form method="POST" action="">
    <? $tabControl->Begin();

    foreach ($aTabs as $aTab) {
        $tabControl->BeginNextTab();
        __AdmSettingsDrawList($moduleID, $aTab['OPTIONS']);
    }

    $tabControl->Buttons(array('btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false)); ?>

    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form>