<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
    <head>
        <title>Sample DYMO Label Plug-In</title>


            <script src="http://labelwriter.com/software/dls/sdk/js/DYMO.Label.Framework.latest.js"
            type="text/javascript" charset="UTF-8"></script>

    </head>
    <body onload="GetDYMOPrinters()">
         <form action="" method="post" id="DYMOLabel">
        <center>
        <h2>DYMO Label  Example</h2>
         <input type=button value="Get DYMO Printers" onClick="GetDYMOPrinters()">
     </center>
    </form>

    <script>
    function GetDYMOPrinters(){   
      var labelXml = `
 <DieCutLabel Version="8.0" Units="twips">
 <PaperOrientation>Landscape</PaperOrientation>
 <Id>Address</Id>
 <PaperName>30252 Address</PaperName>
 <DrawCommands/>
 <ObjectInfo>
 <TextObject>
 <Name>Text</Name>
 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />
 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />
 <LinkedObjectName></LinkedObjectName>
 <Rotation>Rotation0</Rotation>
 <IsMirrored>False</IsMirrored>
 <IsVariable>True</IsVariable>
 <HorizontalAlignment>Left</HorizontalAlignment>
 <VerticalAlignment>Middle</VerticalAlignment>
 <TextFitMode>ShrinkToFit</TextFitMode>
 <UseFullFontHeight>True</UseFullFontHeight>
 <Verticalized>False</Verticalized>
 <StyledText/>
 </TextObject>
 <Bounds X="332" Y="150" Width="4455" Height="1260" />
 </ObjectInfo>
 </DieCutLabel>`;
var label = dymo.label.framework.openLabelXml(labelXml);
      label.setObjectText("Text", "Testing");

                var printers = dymo.label.framework.getPrinters();
                if (printers.length == 0)
                throw "No DYMO printers are installed. Install DYMO printers.";
                var printerName = "";
                for (var i = 0; i < printers.length; ++i)
                {
                    var printer = printers[i];
                    if (printer.printerType == "LabelWriterPrinter")
                    {
                        printerName = printer.name;
                        break;
                    }
                }

              

              label.print(printerName);
            }  
    </script>


    </body>
</html>