<?php
IncludeModuleLangFile(__FILE__);

use \Bitrix\Main\EventManager;

class filshin_seo extends CModule
{
    var $MODULE_ID = 'filshin.seo';
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;

    public function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__."/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = GetMessage("MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("MODULE_DESCRIPTION");
    }

    public function DoInstall()
    {
        $this->installEvents();
        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    public function installEvents() {
        EventManager::getInstance()->registerEventHandler(
            'main',
            'OnEpilog',
            $this->MODULE_ID,
            'Filshin\\Seo\\Events',
            'changeSeoParams'
        );
    }

    public function DoUninstall()
    {
        $this->uninstallEvents();
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        return true;
    }

    public function uninstallEvents() {
        EventManager::getInstance()->unRegisterEventHandler(
            'main',
            'OnEpilog',
            $this->MODULE_ID,
            'Filshin\\Seo\\Events',
            'changeSeoParams'
        );
    }
}