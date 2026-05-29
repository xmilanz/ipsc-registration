<?php
$table = "table_name";

$table_matches = "match_config";
$table_admins = "site_admins";

$table_setting = $table . "_setting";

$table_divisions = $table."_divisions";
$table_categories = $table."_categories";
$table_squads = $table."_squads";
$table_fee = $table."_fee";

$reg_url = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); // pro zobrazení v emailu (link na odhlášení ze závodu) musí být absolutní URL

$admin_url = "https://admin.domena.cz/";

$admin_roles = array(
    "admin" => "přístup ke všem funkcím registračního systému",
    "editor" => "nastavení závodu; správa závodníků; squadů, kategorií, divizí a disciplín; tisk startovních listin; export seznamu",
    "viewer" => "zobrazení informací o závodníkovi; tisk startovních listin; export seznamu"
);

$zavody_prefix = [
    'prachatice' => 'ssas',
    'pelhrimov'  => 'pelhrimov',
    'all'        => '', // zobrazení všech závodů
];

// zpracovani adres zavodu
$custom_urls = [
    'ssas_odstrelovacka_1_2026' => 'odstrelovacka-1-kolo',
];


function tableToUrl(string $table, array $custom_urls): string
{
    // výjimky mají přednost
    if (isset($custom_urls[$table])) {
        return $custom_urls[$table];
    }

    // scénář pro strelnice Prachatice (odstraní prefix "ssas_" a suffix "_202X" a zbytek nahradí pomlčkami), eggewnbeegrg a pelhrimov pouzivaji jiny format nazvu, ktery se nemusi upravovat (tam se jen nahradi podtrzitka pomlckami)
    return preg_replace(
        ['/^ssas_/', '/_\d{4}$/', '/_/'],
        ['', '', '-'],
        $table
    );
}

$web_adresa = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$web_adresa_admin = str_replace('admin', 'registrace', $web_adresa);

$slug = tableToUrl($table, $custom_urls);

//echo "$slug";

$web_adresa_admin .= $slug;
$web_adresa_admin .= "/";

$vyvojar = "webdesign@milanz.org";
?>