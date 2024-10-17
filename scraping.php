<?php

const MOVIE_MAX_COUNT = 12;

$dom = new DOMDocument('1.0', 'UTF-8');
$html = file_get_contents("https://filmarks.com/list/now");
@$dom->loadHTML($html);
$xpath = new DOMXpath($dom);

$page_title = $xpath->query("//title")->item(0)->nodeValue;

$i = 0;
$movie_data = array();
while ($i < MOVIE_MAX_COUNT):
  $title = $xpath->query("//h3[@class='p-content-cassette__title']")->item($i)->nodeValue;

  $rating = $xpath->query("//div[@class='p-content-cassette__rate']/div/div[2]")->item($i)->nodeValue;

  $actor_nodes = $xpath->query("//h4[contains(text(), '出演者')]")->item($i)->nextSibling->childNodes;
  $actors = array();
  foreach ($actor_nodes as $node) {
    $actors[] = $node->nodeValue;
  }

  $movie_data[] = array("title"=>$title, "rating"=>$rating, "actors"=>implode(', ', $actors));

  $i++;
endwhile;

print($page_title. "\n"."\n");
foreach ($movie_data as $data) {
  print($data["title"].' ');
  print($data["rating"]."\n");
  print($data["actors"]."\n"."\n");
}

