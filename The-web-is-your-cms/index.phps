<?php

    $oldtime = microtime(true);

    /* Endpoint YQL */
    $root = 'http://query.yahooapis.com/v1/public/yql?q=';

    /* Blog RSS */
    $query = 'select title,link from rss where url="http://feeds.feedburner.com/wait-till-i/gwZf";';

    /* Del.icio.us RSS */
    $query .= 'select title,link from rss where url="http://feeds.delicious.com/v2/rss/codepo8?count=15";';


    /* Flickr Search By ID */
    $query .= 'select farm,id,owner,secret,server,title from flickr.photos.search(20) where user_id="11414938@N00";';


    /* Youtube RSS */
    $query .= 'select description from rss(5) where url="http://gdata.youtube.com/feeds/base/users/chrisheilmann/uploads?alt=rss&v=2&orderby=published&client=ytapi-youtube-profile";';


    /* using table query.multi */
    /* 
       Each of these queries  can be run inside YQL itself.
       The benefit of using this table is that we don't make individual requests for each query 
       but we get all the data in one single request which means a much better performing solution as the YQL server
       farm is faster on the web than our servers.
     */
    $yql = "select * from query.multi where queries='".$query."'";
     

    /* Assemble the query with JSON as the output */
    $url = $root . urlencode($yql). '&format=json&diagnostics=false&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';

    /* Do the cURL call */
    $output = get($url);

    $data = json_decode($output);

    $results = $data->query->results->results;

    /* Blog output */
       $blog = '<ul id="blog">';

    foreach($results[0]->item as $r) {
 
       $blog .= '<li><a href="'.$r->link.'">'.$r->title.'</a></li>';           
    }  

       $blog .= '</ul>'; 

    /* Delicious output */

       $delicious = '<ul id="delicious">';

    foreach($results[1]->item as $r) {
 
       $delicious .= '<li><a href="'.$r->link.'">'.$r->title.'</a></li>';           
    }  

       $delicious .= '</ul>'; 


    /* Flickr output */

       $flickr = '<ul id="flickr">';

    foreach($results[2]->photo as $r) {
 
       $flickr .= '<li><a href="http://www.flickr.com/photos/statescua/'.$r->id.'/"><img src="http://farm'.$r->farm.'.static.flickr.com/'.$r->server.'/'.$r->id.'_'.$r->secret.'_s.jpg" alt="'.$r->title.'" />';

       $flickr .= '</a></li>';
    }  

       $flickr .= '</ul>'; 

    /* Youtube output */

       $youtube = '<ul id="youtube">';

       foreach($results[3]->item as $r) {

           $clearHTML = resetYoutubeMarkup($r->description);

           $youtube .= '<li>'.$clearHTML.'</li>';
       }

       $youtube .= '</ul>';

 
    function get($url) {

          $ch = curl_init();

          curl_setopt($ch,CURLOPT_URL,$url);

          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

          $data = curl_exec($ch);

          curl_close($ch);  

          if(empty($data)) {

            return 'Error retrieve data, please try again.';

          } else {return $data;}   

    }//endfunction

    function resetYoutubeMarkup($str){

          $cleaner = str_replace('555px','100%',$str);

          $cleaner = preg_replace('/width="[^"]"/','',$cleaner);

          $cleaner = preg_replace('/<tbody>/','<colgroup><col width="20%"><col width="50%"><col width="30%"></colgroup><tbody>',$cleaner);

      return $cleaner;
    }  

     
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
   <title>Christian Heilmann on the web PHP</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <style type="text/css">
   html,body{background:#5B82D5;color:#fff;}
   #doc2{border:1em solid #fff;background:#fff; color:#000;font-family:calibri,helvetica,sans-serif;-moz-border-radius:5px;-webkit-border-radius:5px}
   h1{font-size:240%;font-weight:bold;padding:.2em 0;font-family: calibri}
   h2{margin:.5em 0;font-size:150%;background: #5B82D5;padding:.2em;-moz-border-radius:5px;color:#fff;font-weight:bold;-moz-box-shadow: 0px 4px 2px -2px #333;-moz-border-radius:5px;-webkit-border-radius:5px;text-shadow: #333 1px 1px;clear:both}
   #ft p{border-top:1px solid #ccc;margin-top:2em;padding:.5em;color: #ccc}
   ul li{padding:.2em 0;line-height:1.3em}
   a:link{color:#369;}
   a:visited{color:#666;}
   a:hover,a:active{color:#69c;}
   #blog{clear:both}
   #flickr li{float:left;}
   #flickr img,#youtube img{display:block;padding:2px;border:1px solid #ccc;margin:2px;}
   #timespent{font-family: calibri;font-size: 200%;color: #ccc;font-weight: bold;text-decoration: none;text-align: right}
   </style>
</head>
<body>
<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>Adrian Statescu On The Web PHP</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">
    <div class="yui-u first">

      <h2>My Blog</h2>
         <?php echo$blog; ?>
         
      <h2>My Bookmarks</h2>
         <?php echo$delicious; ?>

     <h2>My Photos</h2>
           <?php echo$flickr; ?> 
    </div>

    <div class="yui-u">

     <h2>youtube RSS</h2>
           <?php echo$youtube; ?> 

    </div>
</div>
   <div id="timespent">Time spent: <?php echo microtime(true) - $oldtime;?></div>
</div>
   <div id="ft" role="contentinfo"><p>Created By Adrian Statescu using YUI and YQL</p></div>
</div>

</body>
</html>
