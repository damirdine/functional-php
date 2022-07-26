<?php
$csvFile = 'jf.csv';
// function csvToArray($fname) {
//     // open csv file
//     if (!($fp = fopen($fname, 'r'))) {
//         die("Can't open file...");
//     }
    
//     //read csv headers
//     $key = fgetcsv($fp,"1024",",");
    
//     // parse csv rows into array
//     $json = array();
//         while ($row = fgetcsv($fp,"1024",",")) {
//         $json[] = array_combine($key, $row);
//     }
    
//     // release file handle
//     fclose($fp);
    
//     // encode array to json
//     return $json;
// }

function csvToArray($file){
    return array_map("str_getcsv", file($file));
}
function JFerie( string $date){
    $data = csvToArray('jf.csv');
    //return in_array($date,$data);
    foreach($data as $jourFerie){
        if($date == $jourFerie[0]){
            return true;
        }
    }
    return false;
}

function AllJFerie(){
    return array_map("str_getcsv", file('jf.csv'));
}

function NSisValid($num){
    $regexPattern = "/[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})/";
    preg_match($regexPattern, $num,$match);
    if(count($match)>0){
       return true;
    }
    return false;
}

function getDepName($DepNum){
    $data = csvToArray('departement.csv');
    foreach($data as $dep){
        if((string)$DepNum == $dep[0]){
            return $dep[3];
        }
    }
    return false;
}

function getCityByDep($DepNum){
    $data = csvToArray('villes_france.csv');
    $citysDep = [];
    foreach($data as $city){
        if((string)$DepNum == $city[1]){
            var_dump($city[2]);
            array_push($citysDep,$city[5]);
        }
    }
    return $citysDep;
}

function getDay($date){
    $fmt = new IntlDateFormatter("fr_FR" ,0,0,NULL,NULL,"EEEE");
    return datefmt_format( $fmt , strtotime($date));
}

function isOpen($parkName){
    $rows = array_map(function($v){return str_getcsv($v, ";");}, file('opr.csv'));
    $header = array_shift($rows);
    $data = [];
    foreach($rows as $row) {
        $data[] = array_combine($header, $row);
    }
    ///---- 
    foreach ($data as $park){
        if($park['nom_parking']==$parkName && $park['Etat']!="0"){
            return true;
        }
    }
    return false;

}
function availablePlace($parkName){
    $rows = array_map(function($v){return str_getcsv($v, ";");}, file('opr.csv'));
    $header = array_shift($rows);
    $data = [];
    foreach($rows as $row) {
        $data[] = array_combine($header, $row);
    }
    return $data;
    ///---- 
    foreach ($data as $park){
        if($park['nom_parking']==$parkName && $park['Etat']!="0"){
            return (int)$park['Libre'];
        }
    }
    return false;
}
echo('<pre>');
var_dump(availablePlace('Parking Centre Opéra Broglie'));