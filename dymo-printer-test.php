<?php
include 'assets/php/connection.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
    <head>
        <title>Sample DYMO Label Plug-In</title>


            <script src="http://labelwriter.com/software/dls/sdk/js/DYMO.Label.Framework.latest.js"
            type="text/javascript" charset="UTF-8"></script>

    </head>
    <body>
         <form action="" method="post" id="DYMOLabel">
        <center>
        <h2>DYMO Label  Example</h2>
         <input type=button value="Get DYMO Printers" onClick="printTags();">
          <br><br><br><br>
          <div id="console">
            
          </div>
     </center>
    </form>
      
      <?php
        $label_original_price = number_format(99.99,2);
        $label_current_price = number_format(39.99,2);
        $label_upc_code = '123456789123';
        $label_ebay_title = 'Terra & Sky Clothing';
        $label_website_title = 'Terra & Sky Clothing';
      ?>
      
      <?php include 'assets/dymo/label-templates/hang-tag-1.php'; ?>
      <?php include 'assets/dymo/label-templates/hang-tag-2.php'; ?>
      <?php include 'assets/dymo/label-templates/test.php'; ?>
      
    <script>
    function GetDYMOPrinters(tag){   
      
      if(tag === 1){ 
        var label = dymo.label.framework.openLabelXml(hang_tag_1);
        console.log('Tag 1');
      }
      if(tag === 2){
        var label = dymo.label.framework.openLabelXml(hang_tag_2);
        console.log('Tag 2');
      }
      if(tag === 3){
        var label = dymo.label.framework.openLabelXml(hang_tag_3);
        console.log('Tag 3');
      }

        var printers = dymo.label.framework.getPrinters();
        if (printers.length == 0){
          document.getElementById('console').innerHTML = '<h1 style="color:red;">No Printers Found...</h1>';
        }
        if (printers.length == 0)
        throw "No DYMO printers are installed. Install DYMO printers.";
        var printerName = "";
        console.log(printers);
        console.log(label);
        for (var i = 0; i < printers.length; ++i)
        {
            var printer = printers[i];
            if (printer.printerType == "LabelWriterPrinter")
            {
                printerName = printer.name;
                label.print(printerName);
                //break;
            }
        }
      //label.print(printerName);
      document.getElementById('console').innerHTML = '<h1>Printer Found: '+printerName+'</h1>';
      
      
    }  
      
    function printTags(){
      GetDYMOPrinters(1);
      //GetDYMOPrinters(2);
      //GetDYMOPrinters(3);
    }
    </script>


    </body>
</html>