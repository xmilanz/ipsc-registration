<?php
$table = isset($_SESSION['zavod_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_SESSION['zavod_id']) : '';

$table_matches = "match_config";
$table_admins = "site_admins";

$reg_redirect_url = "https://registrace.domena.cz/";

$table_divisions = $table . "_divisions";
$table_categories = $table . "_categories";
$table_squads = $table . "_squads";
$table_fee = $table . "_fee";

$admin_roles = array(
    "admin" => "přístup ke všem funkcím registračního systému",
    "editor" => "nastavení závodu; správa závodníků; squadů, kategorií, divizí, startovného; tisk startovních listin; export seznamu",
    "viewer" => "zobrazení informací o závodníkovi; tisk startovních listin; export seznamu"
);

// omezení přístupu admistrátora pro různé závody
$zavody_prefix = [
    'eggenberg' => 'eggenberg',
    'prachatice' => 'ssas',
    'pelhrimov'  => 'pelhrimov',
    'all'        => '', // zobrazení všech závodů
];

// zpracovani adres zavodu (příklad)
$custom_urls = [
    'ssas_odstrelovacka_1_2026' => 'odstrelovacka-1-kolo',
];


function tableToUrl(string $table, array $custom_urls): string
{
    // výjimky mají přednost
    if (isset($custom_urls[$table])) {
        return $custom_urls[$table];
    }

    // standardní scénář - prefix tabulky závodu podle pořadatele - pro ssas 
    return preg_replace(
        ['/^ssas_/', '/_\d{4}$/', '/_/'],
        ['', '', '-'],
        $table
    );
}

$web_adresa = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$web_adresa_admin = str_replace('admin', 'registrace', $web_adresa);

$slug = tableToUrl($table, $custom_urls);

$web_adresa_admin .= $slug;
$web_adresa_admin .= "/";

$reg_redirect_url .= $slug;
$reg_redirect_url .= "/";

$vyvojar = "webdesign@milanz.org";
?>