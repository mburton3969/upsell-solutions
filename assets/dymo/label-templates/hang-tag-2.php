<?php
/*
**  Variables Required...
**  $label_ebay_title
**  $label_website_title
*/
echo '<script>
var hang_tag_2 = `
<DieCutLabel Version="8.0" Units="twips" MediaType="Default">
  <PaperOrientation>Landscape</PaperOrientation>
  <Id>Appointment</Id>
  <PaperName>30374 Appointment Card</PaperName>
  <DrawCommands>
    <Rectangle X="0" Y="0" Width="2880" Height="5040"/>
  </DrawCommands>
  <ObjectInfo>
    <TextObject>
      <Name>Text</Name>
      <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>
      <BackColor Alpha="255" Red="255" Green="255" Blue="255"/>
      <LinkedObjectName></LinkedObjectName>
      <Rotation>Rotation0</Rotation>
      <IsMirrored>False</IsMirrored>
      <IsVariable>True</IsVariable>
      <HorizontalAlignment>Center</HorizontalAlignment>
      <VerticalAlignment>Middle</VerticalAlignment>
      <TextFitMode>ShrinkToFit</TextFitMode>
      <UseFullFontHeight>True</UseFullFontHeight>
      <Verticalized>False</Verticalized>
      <StyledText>
        <Element>
          <String>
          (eBay)' . mysqli_real_escape_string($conn, htmlspecialchars($label_ebay_title)) . '
          
          (81O)' . mysqli_real_escape_string($conn, htmlspecialchars($label_website_title)) . '
          </String>
          <Attributes>
            <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False"/>
            <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>
          </Attributes>
        </Element>
      </StyledText>
    </TextObject>
    <Bounds X="538" Y="187" Width="4415.6" Height="2520.2"/>
  </ObjectInfo>
</DieCutLabel>
      `;
</script>';