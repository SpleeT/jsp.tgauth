<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$token = $_REQUEST['token'];
$tgID = $_REQUEST['tgID'];

if(!\Bitrix\Main\Loader::includeModule('jsp.tgauth')) die();
$redirectUrl = \Jsp\TgAuth\GenerateLink::homePageLink();

if($token && $tgID) {
    $mToken = \Bitrix\Main\Config\Option::get('jsp.tgauth', 'JSP_AUTHORIZE_TOKEN');
    $mRedirectUrl = \Bitrix\Main\Config\Option::get('jsp.tgauth', 'JSP_REDIRECT_URL');
    if($token == $mToken) {
        global $USER;
        $objLink = new Jsp\TgAuth\GenerateLink;
        $uID = $objLink->checkAccess($tgID);
        if($uID) {
            $USER->Authorize($uID);
            LocalRedirect($mRedirectUrl);
        }
    }
} else {
    LocalRedirect($redirectUrl);
}

?>