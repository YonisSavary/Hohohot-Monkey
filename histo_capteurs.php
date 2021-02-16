<?php

use Models\Configuration;
use Models\HistoCapteurs;
use Monkey\Config;
use Monkey\Dist\DB;

require_once "core/monkey.php";

const CLEAR = "\033[0K";

const GREEN = "\033[1;32m";
const YELLOW = "\033[1;33m";
const RESET = "\033[0m";


echo YELLOW. "Outil Historisation des Capteurs \n". RESET;

$c = new Configuration();
$configs = $c->get("DISTINCT api_url","devices_key","devices_name","devices_value")->execute();

echo "Configurations récupérées : ". GREEN . count($configs) . RESET . "\n";

echo "Domaines Concernées : \n";
foreach($configs as $c){
    $c->domain = preg_replace("/.+:\/\//", "", $c->api_url);
    $c->domain = preg_replace("/\/.+/", "", $c->domain);
    echo " - " . $c->domain . "\n";
}

echo YELLOW . " --- DEBUT DU TRAITEMENT --- \n" . RESET;

try 
{
    foreach ($configs as $c){
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)'); 
        $data = json_decode(file_get_contents($c->api_url));

        $dk = $c->devices_key;
        $dn = $c->devices_name;
        $dv = $c->devices_value;

        $capteurs = $data->$dk;

        foreach ($capteurs as $capteur){
            $h = new HistoCapteurs();
            $h->insert("domain", "nom", "temperature", "date")
            ->values($c->domain, $capteur->$dn, $capteur->$dv, time())->execute();
        }
        echo time() ." - Capteur récupérés pour " . $c->domain . "\t : " . YELLOW . count($capteurs) . RESET . "\n";
    }
}
catch (Exception $e)
{
    echo "\033[31;1m ERREUR : " . $e->getMessage() . RESET . "\n";
}