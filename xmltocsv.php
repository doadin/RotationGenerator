<?php

$xmlstring = file_get_contents("{$argv[1]}.xml");
$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

$talentxmlstring = file_get_contents("{$argv[1]}-talent.xml");
$talentxml = simplexml_load_string($talentxmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
$talentjson = json_encode($talentxml);
$talentarray = json_decode($talentjson,TRUE);
file_put_contents("{$argv[1]}.csv","id,name,castTime,minRange,maxRange,isPassive,isTalent,cooldown,costs\n");
#id,name,castTime,minRange,maxRange,isPassive,isTalent,cooldown,costs
$costs = NULL;
$isTalent = NULL;
foreach ($array['spell'] as $spell) {
    $id = $spell["@attributes"]["id"] ?? 0;
    $name = $spell["@attributes"]["name"] ?? "";
    $casttime = $spell["@attributes"]["cast_time_else"] ?? 0;
    $minRange = $spell["@attributes"]["range_min"] ?? 0;
    $maxRange = $spell["@attributes"]["range"] ?? 0;
    if (isset($spell["@attributes"]["passive"])){
        $isPassive = 1;
    } else {
        $isPassive = 0;
    }
    foreach ($talentarray['talent'] as $talent) {
        if ($talent["@attributes"]["spell"] == $id){
            $isTalent = 1;
            break;
        } else {
            $isTalent = 0;
        }
    }    
    $cooldown = $spell["@attributes"]["cooldown"] ?? 0;
    if (isset($spell["resource"])) {
        foreach ($spell["resource"] as $resource) {
            if (isset($resource["type"])) {
                switch($resource["type"]){
                    case 0:
                        $type = "MANA";
                        $costs = $type . ":" . $resource["cost_mana_flat"];
                        break;
                    case 1:
                        $type = "RAGE";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 2:
                        $type = "FOCUS";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 3:
                        $type = "ENERGY";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 4:
                        $type = "COMBO_POINTS";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 5:
                        $type = "RUNE";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 6:
                        $type = "RUNIC_POWER";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 7:
                        $type = "SOUL_SHARD";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 8:
                        $type = "ASTRAL_POWER";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 9:
                        $type = "HOLY_POWER";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 11:
                        $type = "MAELSTROM";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 12:
                        $type = "CHI";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 13:
                        $type = "INSANITY";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 17:
                        $type = "FURY";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    case 19:
                        $type = "ESSENCE";
                        $costs = $type . ":" . $resource["cost"];
                        break;
                    default:
                        #$type = $resource["type"];
                        #$typename = $resource["type_name"];
                        #$costs = "({$type}){$typename}" . ":" . $resource["cost"];
                        #print("-------" . PHP_EOL);
                        #print_r($resource["type"]);
                        #print_r($resource["type_name"]);
                        #print("-------" . PHP_EOL);
                        break;
                }
            }
        }
    } else {
        $costs = "";
    }
    #print_r($id . "," . $name . "," . $casttime  . "," . $minRange  . "," . $maxRange  . "," . $isPassive  . "," . $isTalent  . "," . $cooldown  . "," . $costs . PHP_EOL);
    file_put_contents("{$argv[1]}.csv","{$id},{$name},{$casttime},{$minRange},{$maxRange},{$isPassive},{$isTalent},{$cooldown},{$costs}\n", FILE_APPEND);
}


?>


