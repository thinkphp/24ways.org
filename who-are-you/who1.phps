<?php

    $oldtime = microtime(true);

    $feeds = array("http://feeds.feedburner.com/Thinkphpro",
                   "http://feeds.delicious.com/v2/rss/thinkphp?count=15",
                    "http://www.slideshare.net/rss/user/thinkphp/presentations");

    $root = 'http://query.yahooapis.com/v1/public/yql?q=';

    $urls = '("'.join($feeds,'","').'")';

    $yql = 'select title,link,guid.content,content.thumbnail.url from rss where url in '.$urls;

    $url = $root . urlencode($yql). '&format=json&diagnostics=false';

    $out = array(); 

    $arr = renderFeed($url);

    $blog = $arr['blog'];    

    $slideshare = $arr['slideshare'];   

    $delicious = $arr['delicious'];    

    function renderFeed($url) {
 
          $content = get($url);

          $x = json_decode($content);

          if($x->query->results) {

                 foreach($x->query->results->item as $r) {

                         if(strstr($r->link,'feedproxy.google')) {

                              $out['blog'] .= '<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                         }//endif

                         if(strstr($r->guid,'slideshare.net/thinkphp')) {

                              $src = $r->content->thumbnail->url;

                              $out['slideshare'] .= '<li><a href="'.$r->link.'">'.$r->title.'</a><p><img src="'.$src.'" alt="slideshare" /></p></li>';
                         }//endif

                         if(strstr($r->guid,'delicious.com')) {

                              $out['delicious'] .= '<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                         }//endif

                 }//endforeach
          }//endif

       return $out;

    }//end function

    $url_flickr = 'http://thinkphp.ro/apps/YQL/getFlickrBy/getFlickrBy.php?user=statescua&format=html&amount=15&size=s';

    $flickr = get($url_flickr);

    $flickr = preg_replace('/\<ul\>/','<ul id="flickr">',$flickr);  

    $url_github = 'http://query.yahooapis.com/v1/public/yql?q=select%20repository.name%2Crepository.url%20from%20github.user.repos%20where%20id%3D%22thinkphp%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';

    $github = renderProjects($url_github);

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

    function renderProjects($url) {

          $x = get($url);

          $out = '';

          $result = json_decode($x);

          if($result->query->results->repositories) {

                 foreach($result->query->results->repositories as $r) {

                         $x = $r->repository;

                         $out .= '<li><a href="'.$x->url.'">'.$x->name.'</a></li>'; 
                 } 
          }

        return $out;

    }//end function

    $url_picasa = 'http://query.yahooapis.com/v1/public/yql?q=select%20description%2Cgroup.thumbnail.url%20from%20rss%20where%20url%3D%22http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fbase%2Fuser%2Fmergesortv%3Fcategory%3Dalbum%26alt%3Drss%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';

    $picasa = renderPicasa($url_picasa);

    function renderPicasa($url) {

          $x = get($url);

          $out = '';

          $result = json_decode($x);

          if($result->query->results) {

                 foreach($result->query->results->item as $r) {

                         $out .= $r->description; 
                 } 
          }

        return $out;

    }//end function
     
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
   <title>Adrian Statescu on the web</title>
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
   #flickr img{display:block;padding:2px;border:1px solid #ccc;margin:2px;}
   #timespent{font-family: calibri;font-size: 200%;color: #ccc;font-weight: bold;text-decoration: none;text-align: right}
   </style>
</head>
<body>
<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>Adrian Statescu On The Web</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">
    <div class="yui-u first">

      <h2>My Blog</h2>
      <ul id="blog">
         <?php echo$blog; ?>
      </ul>        
 
      <h2>My Bookmarks</h2>
      <ul id="delicious">
         <?php echo$delicious; ?>
      </ul>        

      <h2>My Projects</h2>
      <ul id="github">
         <?php echo$github; ?>
      </ul>        

      <h2>My Picasa</h2>
      <div id="picasa">
         <?php echo$picasa; ?>
      </div>        

    </div>

    <div class="yui-u">
     <h2>My Photos</h2>
           <?php echo$flickr; ?> 

       <h2>My Presentations</h2>
          <ul id="slideshare">
            <?php echo$slideshare; ?>
         </ul>        

    </div>
</div>
</div>
   <div id="timespent">Time spent: <?php echo microtime(true) - $oldtime;?></div>
   <div id="ft" role="contentinfo"><p>Created By Adrian Statescu using YUI and YQL</p></div>
</div>

</body>
</html>
