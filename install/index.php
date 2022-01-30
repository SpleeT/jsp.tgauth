<?
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;

Class jsp_tgauth extends CModule
{
    const MODULE_ID = "jsp.tgauth";
    var $MODULE_ID = self::MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . "/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = Loc::getMessage('JSP_TGAUTH.MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('JSP_TGAUTH.MODULE_NAME');
        $this->PARTNER_NAME = Loc::getMessage('JSP_TGAUTH.PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('JSP_TGAUTH.PARTNER_URI');
    }

    function DoInstall()
    {
        RegisterModule(self::MODULE_ID);
        \Bitrix\Main\Loader::includeModule(self::MODULE_ID);
        $this->InstallEvents();
        $this->installUserFields();
    }

    function DoUninstall()
    {
        $this->UnInstallEvents();
        UnRegisterModule(self::MODULE_ID);
    }

    function InstallEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible(
            'rest',
            'OnRestServiceBuildDescription',
            self::MODULE_ID,
            \Jsp\TgAuth\RestHandler::class,
            'init'
        );
    }

    function UnInstallEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            self::MODULE_ID,
            \Jsp\TgAuth\RestHandler::class,
            'init'
        );
    }

    function installUserFields()
    {
        $userFields = new \CUserTypeEntity();
        $userFields->Add([
            "ENTITY_ID"       => "USER",
            "FIELD_NAME"      => \Jsp\TgAuth\GenerateLink::USER_FIELD_TG_ID,
            "USER_TYPE_ID"    => "string",
            "EDIT_FORM_LABEL" => [
                "ru"  => Loc::getMessage('JSP_TGAUTH.TG_ID_RU'),
                "en"  => Loc::getMessage('JSP_TGAUTH.TG_ID_EN')
            ],
            'LIST_COLUMN_LABEL' => array(
                'ru'    => Loc::getMessage('JSP_TGAUTH.TG_ID_RU'),
                'en'    => Loc::getMessage('JSP_TGAUTH.TG_ID_EN'),
            ),
            'LIST_FILTER_LABEL' => array(
                'ru'    => Loc::getMessage('JSP_TGAUTH.TG_ID_RU'),
                'en'    => Loc::getMessage('JSP_TGAUTH.TG_ID_EN'),
            ),
        ]);
    }

    function InstallFiles()
    {
        CopyDirFiles(
            __DIR__ . '/files/jsp_auth',
            $_SERVER["DOCUMENT_ROOT"] . '/jsp_auth',
            true,
            true
        );
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx('/jsp_auth');
    }
}
?>