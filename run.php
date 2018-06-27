<?php
//documentation
//http://simplehtmldom.sourceforge.net/manual.htm
include_once('simpleDomParser/simple_html_dom.php');

$linksPath = "links/";
$linksFile = "links.csv";

$outputPath = "output/";
$outputFile = "output.csv";

//clear output file first
file_put_contents($outputPath.$outputFile, "");

//execute script
run($linksPath, $linksFile, $outputPath, $outputFile);

function run($linksPath, $linksFile, $outputPath, $outputFile)
{
    //build array of links
    echo $linksPath.$linksFile;
    $csv = array_map('str_getcsv', file($linksPath.$linksFile));

    //loop through array
    foreach ($csv as $key => $value) {
        //get link
        $url = ($value['0']);
        //show current loop number in console
        echo "\n".$key."\n";
        //show current link in console
        echo $url ."\n";

        //run selector function script on current url
        $returned = selector($url);

        //put result from selector and the url in the output.csv
        file_put_contents($outputPath.$outputFile, $url."\t" .$returned . "\n", FILE_APPEND);
    }
}

function selector($url) {
    // create HTML DOM
    $html = @file_get_html($url);
    //find bodytag in the html
    $body['content'] = $html->find('body', 0);
    //select classes from body tag
    $returned = $body['content']->class;
    //show classes in console
    echo $returned;
    //return selector result
    return $returned;
}


