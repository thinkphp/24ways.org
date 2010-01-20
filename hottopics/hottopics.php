<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Hot Topics (PHP - Solution)</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>Hot Topics news.bbc.co.uk (PHP)</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">
        <ul id="hottopics"><li>
        <?php

         $endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

         $yql = 'select content from search.termextract where context in (select content from html where url="http://news.bbc.co.uk" and xpath="//table[@width=800]//a")';
 
         $query = $endpoint . urlencode($yql) . '&format=json&diagnostics=false';

         $content = get($query);

         $data = json_decode($content);

         $topics = array_unique($data->query->results->Result); 

         echo join("</li><li>",$topics);

         ?>
         </li></ul>
	</div>
	</div>
   <div id="ft" role="contentinfo"><p>Written By Adrian Statescu</p></div>
</div>
</body>
</html>

<?php

      function get($url) {

          $ch = curl_init();

          curl_setopt($ch,CURLOPT_URL,$url);

          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

          $data = curl_exec($ch);

          curl_close($ch);  

          if(empty($data)) {

            return 'Error retrieve data, please try again.';

          } else {return $data;}   

     }//endfunction
?>