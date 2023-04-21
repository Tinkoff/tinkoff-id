<?php

namespace TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders;

class SettingsTabsBuilder extends Builder
{
    /** @var TabBuilder[] */
    private $tabs = [];
    private $headline = '';

    public function build($APPLICATION)
    {
        IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/options.php");

        $rights = $APPLICATION->GetGroupRight("subscribe");
        if ($rights == "D") {
            $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
        }

        $tabs = [];
        foreach ($this->tabs as $tab) {
            $tabs[] = [
                'DIV'   => $tab->getId(),
                'TAB'   => $tab->getName(),
                'ICON'  => 'perfmon_settings',
                'TITLE' => $tab->getHeadline()
            ];
        }
        $tabs = new \CAdminTabControl("tabControl", $tabs);

        \CModule::IncludeModule($this->getModuleID());

        $formURL = $this->getFormURL($APPLICATION, LANGUAGE_ID);

        echo '<h1>' . $this->getHeadline() . '</h1>';

        echo '<form action="' . $formURL . '" method="POST">';
        $tabs->Begin();
        foreach ($this->tabs as $tab) {
            $tabs->BeginNextTab();
            echo bitrix_sessid_post();
            $tab->build();
//            $tab->build();
        }

        $tabs->Buttons(
            array(
                "disabled" => $rights < "W",
                "back_url" => "settings.php?mid=" . $this->moduleID . "&lang=" . LANG,

            )
        );
        $tabs->End();
        echo '</form>';

//        foreach ($this->tabs as $tab){
//            $tab->build();
//            $tabs->Buttons();
//
//            echo '<input type="submit" name="Update" value="'.GetMessage("MAIN_SAVE").'" title="'.GetMessage("MAIN_OPT_SAVE_TITLE").'" class="adm-btn-save">';
//            echo '<input type="submit" name="Apply" value="'.GetMessage("MAIN_OPT_APPLY").'" title="'.GetMessage("MAIN_OPT_APPLY_TITLE").'">';
//
//            if ($_REQUEST["back_url_settings"] > 0){
//                echo '<input type="button" name="Cancel" value="'.GetMessage("MAIN_OPT_CANCEL").'" title="'.GetMessage("MAIN_OPT_CANCEL_TITLE").'" onclick="window.location=\''. htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"])).'\'">';
//                echo '<input type="hidden" name="back_url_settings" value="'.htmlspecialcharsbx($_REQUEST["back_url_settings"]).'">';
//                echo '<input type="submit" name="RestoreDefaults" title="'.GetMessage("MAIN_HINT_RESTORE_DEFAULTS").'" onClick="confirm(\''.AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")).'\')" value="'.GetMessage("MAIN_RESTORE_DEFAULTS").'">';
//                echo bitrix_sessid_post();
//            }
//        }
    }

    private function getFormURL($APPLICATION, $langID)
    {
        $formQuery = http_build_query([
            'mid'  => $this->getModuleID(),
            'lang' => $langID
        ]);

        return $APPLICATION->GetCurPage() . '?' . $formQuery;
    }

    public function addTab($tab)
    {
        $this->tabs[] = $tab;
    }

    /**
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param string $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }


}