<?php


namespace Jsp\TgAuth;


use Bitrix\Main\UserTable;

class GenerateLink
{
    protected $userID;
    protected $tgID;

    const USER_FIELD_TG_ID = "UF_TG_ID";

    public static function homePageLink()
    {
        return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    }

    public function checkAccess($tgID)
    {
        $arUser = UserTable::getList([
            "filter" => [
                self::USER_FIELD_TG_ID => $tgID
            ],
            "select" => ["ID"]
        ])->fetch();
        $this->userID = $arUser ? $arUser["ID"] : false;
        $this->tgID = $arUser ? $arUser["ID"] : false;
        return $this->userID;
    }

    public function generateLink()
    {
        $redirectLink = self::homePageLink();
        if($this->tgID && $this->userID) {
            $mToken = \Bitrix\Main\Config\Option::get('jsp.tgauth', 'JSP_AUTHORIZE_TOKEN');
            $redirectLink .= "/?" . http_build_query(['token' => $mToken, 'tgID' => $this->tgID]);
        }
        $shortUri = \CBXShortUri::GenerateShortUri();
        $rs = \CBXShortUri::Add([
            "URI" => $redirectLink,
            "SHORT_URI" => $shortUri,
            "STATUS" => "301",
        ]);

        return $rs ? self::homePageLink() . '/' . $shortUri : self::homePageLink();
    }

}