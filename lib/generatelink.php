<?php


namespace Jsp\TgAuth;


use Bitrix\Main\UserTable;

class GenerateLink
{
    protected $userID;

    const USER_FIELD_TG_ID = "UF_TG_ID";

    public function checkAccess($tgID)
    {
        $arUser = UserTable::getList([
            "filter" => [
                self::USER_FIELD_TG_ID => $tgID
            ],
            "select" => ["ID"]
        ])->fetch();
        $this->userID = $arUser ? $arUser["ID"] : false;
        return $this->userID;
    }

    public function generateLink()
    {
        return '/';
    }

}