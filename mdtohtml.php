<?php
include 'parsedown-1.7.4/Parsedown.php'; /* this parses the md note into html */

/* iterate through folder and get file name */
// Counts all files and directories in directory except "." and "..".

$path = '../../Documents/tonsobsidian/obsidian/Schrijven/blogdit'; /* the path to the folder that has your md files to post, relative from this scripts location */
$pathf = $path."/";
$filecount = 0;
foreach (new DirectoryIterator($path) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    $testname = $fileInfo->getFilename();
    /* .md files only considered */
    if (mb_substr($testname, -3)==".md") {
    	$testtime = $fileInfo->getMTime();
    	$nutime = time()-14400; /* only newer than 4hrs ago considered*/
    	if ($testtime>$nutime) {
    $filelist[$filecount] = $fileInfo->getFilename();
    $filecount = $filecount+1;
    }
    }
}
$totalfiles = $filecount-1; //count from 0
$filecount = 0;

/* now I have an array with the file names of the file to be posted */

while ($filecount <= $totalfiles) {
/*checking whether status draft*/
/*for which I need the first line of the file, and the second for categories, third the site (remove if only 1), fourth page or post, the rest is content */
if ($file = fopen($pathf.$filelist[$filecount], "r")) {
    $regel1[$filecount] = fgets($file);
    if (mb_substr($regel1[$filecount], 9, -1) == "draft") {
    	$regel1[$filecount] = "draft";
    	$regel2[$filecount] = fgets($file);
    	$regel2[$filecount] = mb_substr($regel2[$filecount], 7, -1);
    	$regel3[$filecount] = fgets($file);
    	$regel3[$filecount] = mb_substr($regel3[$filecount], 7, -1);
    	$regel4[$filecount] = fgets($file);
    	$regel4[$filecount] = mb_substr($regel4[$filecount], 7, -1);
    	$regelrest[$filecount] = "";
    	while (!feof($file)) {
    	$regelrest[$filecount] = $regelrest[$filecount].fgets($file);
    	}
    	$regel1nw[$filecount] = "status:: posted\n";
    echo "I have read ".$filelist[$filecount]."<br/>\n";
    }  
    }
    fclose($file);


if ($regel1[$filecount] == "draft") {
/*for every detected draft a number of steps*/
/*first the original md file first line status will be set to published and save so it won't get picked up again*/
$nieuwefile = $regel1nw[$filecount]."cats:: ".$regel2[$filecount]."\nsite:: ".$regel3[$filecount]."\ntype:: ".$regel4[$filecount]."\n".$regelrest[$filecount];
$fileeind = fopen($pathf.$filelist[$filecount], "w");
fwrite($fileeind, $nieuwefile);
fclose($fileeind);

/*now post draft to site*/

/* per file read file content and set the variables needed, then push to micropub */
$posttitel = $filelist[$filecount];
$posttitel = mb_substr($posttitel, 0, -3);
$cats = explode(", ", $regel2[$filecount]);
$site = $regel3[$filecount];
$type = $regel4[$filecount];
$contentspulm = $regelrest[$filecount];

$Parsedown = new Parsedown();
$contentspul = $Parsedown->text($contentspulm);

include 'jsonfilegetcontents.php'; /* this is the php script that only does the micropub posting*/
}
    $filecount=$filecount+1;
}

?>
