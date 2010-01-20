<?php
                $oldtime = microtime(true);

                $query = 'select title,link from rss where url="http://feeds2.feedburner.com/Woork" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds2.feedburner.com/CssTricks" limit 7;';

                $query .= 'select title,link from rss where url="http://www.phpied.com/feed" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/ajaxian" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/AjaxRain" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/nettuts" limit 7;';

                $query .= 'select title,link from rss where url="http://mootools.net/forge/feed/recent" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/mootools-blog" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/wait-till-i/gwZf" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.yuiblog.com/YahooUserInterfaceBlog" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.developer.yahoo.net/YDNBlog" limit 7;';

                $query .= 'select title,link from rss where url="http://feeds.feedburner.com/JohnResig" limit 7';

                $root = 'http://query.yahooapis.com/v1/public/yql?q=';

                $yql = "select * from query.multi where queries='".$query."'";

                $url = $root . urlencode($yql) . '&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&diagnostics=false';  

                $content = get($url);

                $data = json_decode($content);

                $results = $data->query->results->results;

                $woorks = '<h2>woorks.com</h2><ul>';
 
                        foreach($results[0]->item as $r) {

                              $woorks .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $woorks .= '</ul>';

                $csstricks = '<h2>css-tricks.com</h2><ul>';
 
                        foreach($results[1]->item as $r) {

                              $csstricks .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $csstricks .= '</ul>';


                $phpied = '<h2>phpied.com</h2><ul>';
 
                        foreach($results[2]->item as $r) {

                              $phpied .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $phpied .= '</ul>';


                $ajaxian = '<h2>ajaxian.com</h2><ul>';
 
                        foreach($results[3]->item as $r) {

                              $ajaxian .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $ajaxian .= '</ul>';


                $ajaxrain = '<h2>ajaxrain.com</h2><ul>';
 
                        foreach($results[4]->item as $r) {

                              $ajaxrain .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $ajaxrain .= '</ul>';


                $nettuts = '<h2>nettuts.com</h2><ul>';
 
                        foreach($results[5]->item as $r) {

                              $nettuts .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $nettuts .= '</ul>';


                $mooforge = '<h2>mootools.com/forge</h2><ul>';
 
                        foreach($results[6]->item as $r) {

                              $mooforge .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $mooforge .= '</ul>';

                $mootools = '<h2>mootools.com/blog</h2><ul>';
 
                        foreach($results[7]->item as $r) {

                              $mootools .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $mootools .= '</ul>';

                  $waiticome = '<h2>wait-till-i.com</h2><ul>';
 
                        foreach($results[8]->item as $r) {

                              $waiticome .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $waiticome .= '</ul>';


              $yuiblog = '<h2>yuiblog.com</h2><ul>';
 
                        foreach($results[9]->item as $r) {

                              $yuiblog .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $yuiblog .= '</ul>';


              $ydn = '<h2>ydn.com</h2><ul>';
 
                        foreach($results[10]->item as $r) {

                              $ydn .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $ydn .= '</ul>';


              $jeresig = '<h2>jeresig.com</h2><ul>';
 
                        foreach($results[11]->item as $r) {

                              $jeresig .='<li><a href="'.$r->link.'">'.$r->title.'</a></li>';
                        }

                        $jeresig .= '</ul>';


                       
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
   <title>24ways.org RSS Reader PHP</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
    html,body{color:#fff;background:#222;font-family:calibri,verdana,arial,sans-serif;}
    h1{font-size:300%;margin:0;text-align:right;color:#3c3}
    h2{background:#369;padding:5px;color:#fff;font-weight:bold;-moz-box-shadow: 0px 4px 2px -2px #000;-moz-border-radius:5px;-webkit-border-radius:5px;text-shadow: #000 1px 1px}
    h3 a{color:#69c;text-decoration:none;}
    h3{margin:0 0 .2em 0}
    ul,ul li{margin:0;padding:0;list-style:none;}
    p span{display:block;text-align: left;margin-top:.5em;font-size:90%;color:#999;}
    #woorks,#ajaxian,#mooforge,#yuiblog{height: 220px;}
    #woorks a{color:#c6c;}
    #woorks h2{background:#c6c;}
    #css-tricks a{color:#72D215;}
    #css-tricks h2{background:#72D215;}
    #phpied a{color:#60FFE9;}
    #phpied h2{background:#60FFE9;}
    #ajaxian a{color:#21B964;}
    #ajaxian h2{background:#21B964;}
    #ajaxrain a{color:#C741BE;}
    #ajaxrain h2{background:#C741BE;}
    #nettuts a{color: #D3D2FA;}
    #nettuts h2{background: #D3D2FA;}
    #mooforge a{color: #7443A5;}
    #mooforge h2{background: #7443A5;}
    #mootools a{color: #7443A5;}
    #mootools h2{background: #7443A5;}
    #waiticome a{color: #707300;}
    #waiticome a:hover{color: #fff;}
    #waiticome h2{background: #707300;}
    #yuiblog a{color: #CAD600;}
    #yuiblog h2{background: #CAD600;}
    #ydn a{color: #CAD600;}
    #ydn h2{background: #CAD600;}
    #jeresig a{color: #CAD600;}
    #jeresig h2{background: #CAD600;}
    #ft p{color:#ccc;text-align: right;}
    #ft a{color:#ccc;}
    #timespent{color: #ccc;font-family: calibri;font-size: 200%}
   </style>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>RSS Reader PHP</h1></div>
   <div id="bd" role="main">
     <div class="yui-gb">
        <div class="yui-u first" id="woorks">
        <?php echo$woorks; ?>
        </div>
        <div class="yui-u" id="css-tricks">
        <?php echo$csstricks; ?>
        </div>
        <div class="yui-u" id="phpied">
        <?php echo$phpied; ?>
        </div>
    </div>
    <div class="yui-gb">
        <div class="yui-u first" id="ajaxian">
        <?php echo$ajaxian; ?>
        </div>
        <div class="yui-u" id="ajaxrain">
        <?php echo$ajaxrain; ?>
        </div>
        <div class="yui-u" id="nettuts">
        <?php echo$nettuts; ?>
        </div>
    </div>
    <div class="yui-gb">
        <div class="yui-u first" id="mooforge">
        <?php echo$mooforge; ?>
        </div>
        <div class="yui-u" id="mootools">
        <?php echo$mootools; ?>
        </div>
        <div class="yui-u" id="waiticome">
        <?php echo$waiticome; ?>
        </div>
    </div>
    <div class="yui-gb">
        <div class="yui-u first" id="yuiblog">
        <?php echo$yuiblog; ?>
        </div>
        <div class="yui-u" id="ydn">
        <?php echo$ydn; ?>
        </div>
        <div class="yui-u" id="jeresig">
        <?php echo$jeresig; ?>
        </div>
    </div>

   </div>
   <div id="timespent">Time spent: <?php echo microtime(true) - $oldtime; ?></div>
   <div id="ft" role="contentinfo"><p>Created By Adrian Statescu using YUI, YQL and query.multi</p></div>
</div>

</body>
</html>
