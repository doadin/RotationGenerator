<?php
require_once __DIR__.'/vendor/autoload.php';

use BlizzardApi\Enumerators\Region;

BlizzardApi\Configuration::$apiKey = getenv('apiKey');
BlizzardApi\Configuration::$apiSecret = getenv('apiSecret');
BlizzardApi\Configuration::$region = Region::US;

$api_client = new \BlizzardApi\Wow\GameData\Spell;
#$data = $api_client->search(function($queryOptions) {
#    $queryOptions->where('name.en_US', 'Smite')->order_by('id');
#});
function stdToArray($obj){
    $reaged = (array)$obj;
    foreach($reaged as $key => &$field){
      if(is_object($field))$field = stdToArray($field);
    }
    return $reaged;
}
$dir = new DirectoryIterator(realpath(__DIR__ . "/output"));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        #var_dump($fileinfo->getFilename());
        $fp = fopen("output/".$fileinfo->getFilename(), "r");
        while (($line = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            #echo $line . PHP_EOL;
            if (($pos = strpos($line, ":")) !== FALSE) { 
                $simspell = substr($line, $pos+1);
                #echo $simspell . PHP_EOL;
                $spell = str_replace("_"," ",$simspell);
                $spell = trim($spell);
                $spell = ucwords($spell);
                #if ($spell == ""){
                #    break;
                #}
                print("asking blizz for spell {$spell}" . PHP_EOL);
                $data = $api_client->search(function($queryOptions) {
                    $queryOptions->where('name.en_US', $GLOBALS["spell"])->order_by('id');
                });
                #var_dump($data);
                #$array = json_decode(json_encode($data), true);
                $array = stdToArray($data);
                $array2 = json_decode(json_encode($data), true);
                #var_dump($array);
                if (isset($array["results"])){
                    $i = 0;
                    while($i < count($array))
                    {   
                        if (isset($array2["results"][$i]["data"]["name"]["en_US"])){
                    	    #echo "blizz returned " . $array2["results"][$i]["data"]["name"]["en_US"]."\n";
                            if ( similar_text($spell , $array2["results"][$i]["data"]["name"]["en_US"], $percent) ) {
                                if ($percent >= 90) {
                                    echo "we found a match"."\n";
                                    #var_dump($array2["results"][$i]["data"]["id"]);
                                    $myfile = fopen("output/".$fileinfo->getFilename().".csv", "a");
                                    $txt = $array2["results"][$i]["data"]["id"] . "," . $spell . ",0,0,0,0,0,0,\n";
                                    fwrite($myfile, $txt);
                                    fclose($myfile);
                                    break;
                                }
                            }
                    	    
                        }
                        $i++;
                    }
                }
                #break;
            }
        }
    }
}

#$dataaray = (array) $data;
#$results = $dataaray["results"];
#var_dump($data["results"]);
#$array = json_decode(json_encode($data), true);
#var_dump($array);
#if (isset($array["results"])){
#    if (isset($array["results"][0])){
#        #print("results");
#        if (isset($array["results"][0]["data"])){
#            #print("data");
#            if (isset($array["results"][0]["data"]["name"])){
#                #print("name");
#                if (isset($array["results"][0]["data"]["name"]["en_US"])){
#                    #print("english");
#                    if ($array["results"][0]["data"]["name"]["en_US"] == $spell) {
#                        print("we found a match");
#                        #$fp = fopen("/path/to/the/file", "r");
#                        #while (($line = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
#                        #  echo $line;
#                        #}
#                        #fclose($fp);
#                    }
#                }
#            }
#        }
#    }
#}

//  Scan through outer loop
#foreach ($dataaray as $inner) {
#    //  Check type
#    if (is_array($inner)) {
#        //  Scan through inner loop
#        foreach ($inner[1] as $value) {
#           echo "$value \n";
#        }
#    }
#}

#var_dump($dataaray[5]);


#var_dump((array) $data);