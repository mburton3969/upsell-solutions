//Globals...
var ebay_auth = 'AgAAAA**AQAAAA**aAAAAA**0nzuXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4aiCZSApA2dj6x9nY+seQ**TAIFAA**AAMAAA**SeXtz4D90Ni5UScy06a+BJ4ocWOj0Y4tNdYxUV7ZGDgtAVr+rlhz8vA4v7egqZL7lw+u9YIZutr80icVQs3LCpGNf8hOY19NfK/AgG1mL6EYnPdIFsvRJhu8YUPUeZGlQWry0eoPerb/3L7m3PrcMu0DAXRMpWSFPSNQC1bd/e13Qwj6fxxyTncCEc1ATcS9IxLaLmExl6mxtp3/zee2i+Bg9VBe44m51EaQhycWaFApmSI03DiUO1KE9AS3qaqS+GkEZF3F/rGIotpSkNHCiMP4nlaZvF0L/INws3eWEiVggObarqDi0u+afwAWT5CIUqnJbAfQyQ+Qdl3K5Eoqjaa1sAQIQJDD26WJ0PhrP/cxYK1LZ72CMtBRUWJcMI+6bF76773dWUEQXHEqFT0PO27IC03m6ZHze6dhR62XoRLBDoD2y13EjXNQO2CKJrvAtDufY+Fx57onT6jQMsU7mTjrQyEa6awFYnvJ2ocbjZ17/DPfwuQanva35C4v/ONE6QqrVxIeqY1pTo1FiVDdgLxSQFjoyPK6SI9J8hypdItVR9JvFcZNC5gdxqjANrSg71H2Ow4mGPXHWiEFQ0qiqM1eyO9pVjHGuTTwR1c26AHzPirdj3BIhyDVDUwyBqDpHUIh7I9YcJzGhkhxu0H9PvxRa9HeIu13wiDSlL5Ju6sShfDwowWN9yhYw+XQlHJ9OYlmixTjSWXBYL5i42lBqpT9wOqf3hFMsEu4JRmxxBLvR1XBgKW7Iaedh/tT5/qM';

var payload = 
{
    "availability": {
        "shipToLocationAvailability": {
            "quantity": 50
        }
    },
    "condition": "NEW",
    "product": {
        "title": "GoPro Hero4 Helmet Cam",
        "description": "New GoPro Hero4 Helmet Cam. Unopened box.",
        "aspects": {
            "Brand": [
                "GoPro"
            ],
            "Type": [
                "Helmet/Action"
            ],
            "Storage Type": [
                "Removable"
            ],
            "Recording Definition": [
                "High Definition"
            ],
            "Media Format": [
                "Flash Drive (SSD)"
            ],
            "Optical Zoom": [
                "10x"
            ]
        },
        "brand": "GoPro",
        "mpn": "CHDHX-401",
        "imageUrls": [
            "http://i.ebayimg.com/images/i/182196556219-0-1/s-l1000.jpg",
            "http://i.ebayimg.com/images/i/182196556219-0-1/s-l1001.jpg",
            "http://i.ebayimg.com/images/i/182196556219-0-1/s-l1002.jpg"
        ]
    }
};

var qs = "category_ids=108765&q=Beatles&filter=price:[200..500]&filter=priceCurrency:USD&limit=10";
function ebay_add_item(){
	var upc = document.getElementById('product_code').value;
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      console.log(this.responseText);

    }
  }
  //xmlhttp.open("POST","https://api.sandbox.ebay.com/sell/inventory/v1/inventory_item/"+upc,true);
  xmlhttp.open("GET","https://api.sandbox.ebay.com/buy/browse/v1/item_summary/search?"+qs,true);
  xmlhttp.setRequestHeader('Authorization',ebay_auth);
  //xmlhttp.setRequestHeader('X-EBAY-C-MARKETPLACE-ID','EBAY_US');
  //xmlhttp.setRequestHeader('Content-Language','en-US');
  xmlhttp.send();
}





