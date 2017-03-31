<?php

// Fragment - START
$content .= '
<p>
    Bei der Installation wurden mehrere Effekte beim Media Manager AddOn hinzugefügt:
<ul>
    <li><strong>Galerie:</strong> lightgallery_0450,lightgallery_0650,lightgallery_0900,lightgallery_1100</li>
    <li><strong>Scrolling:</strong> parallax</li>
</ul>
    Sollten diese fehlen, bitte ein reinstall durchführen!
</p>

<p>
    Bei der Installation wurden mehrere PlugIns im Asset-Ordner des Addons unter "./plugins/" hinzugefügt:
<ul>
    <li><strong>Frontend:</strong> jquery,bootstrap3,awesome</li>  
    <li><strong>Extras:</strong> animate,aniview,ismobile,retina,lazyload,modal</li>
    <li><strong>Slider:</strong> owl,vegas</li>  
</ul>
    <i>Werden aktuell teilweise für Projekte genutzt! (Könnten zukünfig entfallen.)</i>
</p>
';

if (rex::getUser()->isAdmin()) {

    // SQL :: rex_modul => 03 . Bilder / Galerie
    $module = rex_sql::factory();
    #$module->setDebug();
    $module->setTable(rex::getTablePrefix().'module');
    $module->setQuery("SELECT * FROM rex_module WHERE output LIKE '%MODUL | 03 . Galerie%'");

    $module_id = 0;
    $module_name = '';
    $module_id = $module->getValue('id');
    $module_name = $module->getValue('name');

    if (rex_request('install_module',"integer") == 1) {

        try {

            // SQL :: rex_modul => 03 . Bilder / Galerie
            $module = rex_sql::factory();
            #$module->setDebug();
            $module->setTable(rex::getTablePrefix().'module');

            $module->setValue('input', rex_file::get(rex_path::addon('lightgallery','pages/help_modul_install_input.inc')));
            $module->setValue('output', rex_file::get(rex_path::addon('lightgallery','pages/help_modul_install_output.inc')));

            if ( $module_id == rex_request('module_id','integer',-1) ) {

                $module->setWhere(['id' => $module_id]);
                $module->update();

                echo rex_view::success('Modul "' . $module_name . '" wurde aktualisiert');

            } else {

                $module_name = '03 . Bilder / Galerie';
                $module->setValue('name', $module_name);
                $module->insert();

                echo rex_view::success('Modul wurde angelegt unter "' . $module_name . '"');

            }

        } catch (rex_sql_exception $e) {

            echo rex_view::warning('Das Modul "'.$module_name.'" konnte nicht angelegt werden.<br/>Details siehe Fehlermeldung.<br>'.$e->getMessage());

        }

    }

    $content .= '<p>'.$this->i18n('modul_install_description').'</p>';

    if ($module_id > 0) {
        $content .= '<p><a class="btn btn-primary" href="index.php?page=lightgallery/help&amp;install_module=1&amp;module_id=' . $module_id . '" class="rex-button">' . $this->i18n('modul_update', htmlspecialchars($module_name)) . '</a></p>';

    }else {
        $content .= '<p><a class="btn btn-primary" href="index.php?page=lightgallery/help&amp;install_module=1" class="rex-button">' . $this->i18n('modul_install', $module_name) . '</a></p>';

    }


    // SQL :: rex_template => TEMPLATE | LIGHTGALLERY
    $template = rex_sql::factory();
    #$template->setDebug();
    $template->setTable(rex::getTablePrefix().'template');
    $template->setQuery("SELECT * FROM rex_template WHERE content LIKE '%TEMPLATE | LIGHTGALLERY%'");

    $template_id = 0;
    $template_name = '';
    $template_id = $template->getValue('id');
    $template_name = $template->getValue('name');

    if (rex_request('install_template',"integer") == 1) {

        try {

            // SQL :: rex_modul => 03 . Bilder / Galerie
            $template = rex_sql::factory();
            #$template->setDebug();
            $template->setTable(rex::getTablePrefix().'template');

            $template->setValue('content', rex_file::get(rex_path::addon('lightgallery','pages/help_template_install.inc')));

            if ( $template_id == rex_request('template_id','integer',-1) ) {

                $template->setWhere(['id' => $template_id]);
                $template->update();

                echo rex_view::success('Template "' . $template_name . '" wurde aktualisiert');

            } else {

                $template_name = 'tpl : addon lightgallery (js)';
                $template->setValue('name', $template_name);
                $template->insert();

                echo rex_view::success('Template wurde angelegt unter "' . $template_name . '"');

            }

        } catch (rex_sql_exception $e) {

            echo rex_view::warning('Das Template "'.$template_name.'" konnte nicht angelegt werden.<br/>Details siehe Fehlermeldung.<br>'.$e->getMessage());

        }

    }

    $content .= '<p>'.$this->i18n('template_install_description').'</p>';

    if ($template_id > 0) {
        $content .= '<p><a class="btn btn-primary" href="index.php?page=lightgallery/help&amp;install_template=1&amp;template_id=' . $template_id . '" class="rex-button">' . $this->i18n('template_update', htmlspecialchars($template_name)) . '</a></p>';

    }else {
        $content .= '<p><a class="btn btn-primary" href="index.php?page=lightgallery/help&amp;install_template=1" class="rex-button">' . $this->i18n('template_install', $template_name) . '</a></p>';

    }

}

$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', $this->i18n('help'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
// Fragment - ENDE


// Fragment - START
$content_collapse1 = '
<p>Folgendes im Template einfügen:</p>
';

$content_collapse1 .= rex_string::highlight(rex_file::get(rex_path::addon('lightgallery','pages/help_template.inc')));

$content_collapse1 .= '
<p>Bei der Installation wurden Effekte beim Media Manager AddOn hinzugefügt. Sollte dieser fehlen, bitte ein reinstall durchführen</p>
<p>Diese Ausgabe dient als Beispiel für ein Modul:</p>

';

$fragment = new rex_fragment();
$fragment->setVar('collapse', true, false);
$fragment->setVar('collapsed', true, false);
$fragment->setVar('class', 'default', false);
$fragment->setVar('title', $this->i18n('help_template'), false);
$fragment->setVar('body', $content_collapse1, false);
echo $fragment->parse('core/page/section.php');
// Fragment - ENDE


// Fragment - START
$content_collapse2 .= '
<p>Diese Ausgabe dient als Beispiel für ein Modul:</p>

';
$content_collapse2 .= rex_string::highlight(rex_file::get(rex_path::addon('lightgallery','pages/help_modul.inc')));

$fragment = new rex_fragment();
$fragment->setVar('collapse', true, false);
$fragment->setVar('collapsed', true, false);
$fragment->setVar('class', 'default', false);
$fragment->setVar('title', $this->i18n('help_modul'), false);
$fragment->setVar('body', $content_collapse2, false);
echo $fragment->parse('core/page/section.php');
// Fragment - ENDE