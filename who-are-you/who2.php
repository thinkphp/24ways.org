<?php

    $oldtime = microtime(true);

    /* Endpoint YQL */
    $root = 'http://query.yahooapis.com/v1/public/yql?q=';

    /* Blog RSS */
    $query = 'select title,link from rss where url="http://feeds.feedburner.com/Thinkphpro";';

    /* Del.icio.us RSS */
    $query .= 'select title,link from rss where url="http://feeds.delicious.com/v2/rss/thinkphp?count=15";';

    /* Slideshare RSS */
    $query .= 'select title,link,content.thumbnail from rss where url="http://www.slideshare.net/rss/user/thinkphp/presentations";';

    /* Flickr Search By ID */
    $query .= 'select farm,id,owner,secret,server,title from flickr.photos.search(20) where user_id="23455178@N06";';

    /* GitHub RSS */
    $query .= 'select repository.name,repository.url from github.user.repos where id="thinkphp";';

    /* Picasa RSS */
    $query .= 'select description,group.thumbnail.url from rss where url="http://picasaweb.google.com/data/feed/base/user/mergesortv?category=album&alt=rss"'; 
 
    $yql = "select * from query.multi where queries='".$query."'";

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


    /* Slideshare output */

       $slideshare = '<ul id="slideshare">';

    foreach($results[2]->item as $r) {
 
       $slideshare .= '<li><a href="'.$r->link.'">'.$r->title.'</a><br/><img src="'.$r->content->thumbnail->url.'" alt="'.$r->title.'"></li>';           
    }  

       $slideshare .= '</ul>'; 

    /* Flickr output */

       $flickr = '<ul id="flickr">';

    foreach($results[3]->photo as $r) {
 
       $flickr .= '<li><a href="http://www.flickr.com/photos/statescua/'.$r->id.'/"><img src="http://farm'.$r->farm.'.static.flickr.com/'.$r->server.'/'.$r->id.'_'.$r->secret.'_s.jpg" alt="'.$r->title.'" />';

       $flickr .= '</a></li>';
    }  

       $flickr .= '</ul>'; 

 
       /* Github repositories */

       $github = '<ul id="github">';
       
       foreach($results[4]->repositories as $r) {        

           $github .= '<li><a href="'.$r->repository->url.'">'.$r->repository->name.'</a></li>';           
       }  
         
       $github .= '</ul>';


       /* Picasa Photos RSS */

       $picasa = '<ul id="picasa">';
       
       foreach($results[5]->item as $r) {        

           $picasa .= '<li>'.$r->description.'</li>';           
       }  
         
       $picasa .= '</ul>';


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

     
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
   <title>Adrian Statescu on the web PHP</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <style type="text/css">
   html,body{background: #8B34C9;color:#fff;font-family: helvetica}
   #doc2{border:1em solid #fff;background:#fff; color:#000;font-family:calibri,helvetica,sans-serif;-moz-border-radius:5px;-webkit-border-radius:5px;margin-top: 4px}
   h1{font-size:240%;font-weight:bold;padding:.2em 0;font-family: calibri}
   h2{margin:.5em 0;font-size:150%;background: #8B34C9;padding:.2em;-moz-border-radius:5px;color:#fff;font-weight:bold;-moz-box-shadow: 0px 4px 2px -2px #ccc;-moz-border-radius:5px;-webkit-border-radius:5px;text-shadow: #ccc 1px 1px;clear:both}
   #ft p{border-top:1px solid #ccc;margin-top:2em;padding:.5em;color: #ccc}
   ul li{padding:.2em 0;line-height:1.3em}
   a:link{color:#369;}
   a:visited{color:#666;}
   a:hover,a:active{color:#69c;}
   #blog{clear:both}
   #flickr li{float:left;}
   #flickr img{display:block;padding:2px;border:1px solid #ccc;margin:2px;}
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

      <h2>My Projects</h2>
         <?php echo$github; ?>

      <h2>My Picasa</h2>
      <div id="picasa">
         <?php echo$picasa; ?>
      </div>        

    </div>

    <div class="yui-u">
     <h2>My Photos</h2>
           <?php echo$flickr; ?> 

       <h2>My Presentations</h2>
            <?php echo$slideshare; ?>

    </div>
</div>
   <div id="timespent">Time spent: <?php echo microtime(true) - $oldtime;?></div>
</div>
   <div id="ft" role="contentinfo"><p>Created By Adrian Statescu using YUI and YQL</p></div>
</div>

</body>
</html>
