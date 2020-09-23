<?php
$cache_buster = uniqid();
?>
<html>
  <head>
    <title>Retrofit</title>
  </head>
  <body>
    
    <h1>
      Retrofit Ebay Items in SellBrite:
    </h1>
    
    <div id="main_display">
      <p>
        SellBrite Items Loaded: <span id="sb_loaded">0</span>
      </p>
      <p>
        SellBrite Items Updated: <span id="sb_updated">0</span>
      </p>
    </div>
    
    <button onclick="init_retrofit();">
      Init Retrofit
    </button>
    
    <button onclick="download_nf_items();">
      Download Not Found
    </button>
    
  </body>
  <script src="retrofit-functions.js?cb=<?php echo $cache_buster; ?>"></script>
</html>