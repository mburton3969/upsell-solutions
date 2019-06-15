//Globals...
var ebay_user_auth = 'v^1.1#i^1#r^0#f^0#p^1#I^3#t^H4sIAAAAAAAAAOVYa2wUVRTu9rFYofgDRUJMWEYEtJnZOzudbWfobty+QgOlhS0IGKjzuLMdmZ0Z5t6hXY1aamzkTSAhMSaGEEOBEIwJfwghhkQMoIRGUBL4ISGImKj8wFAVA96ZPthWUpZSsIn7ZzL3nnvud77znblnL+gIFr/SNb+rtyQwIX93B+jIDwTYiaA4WFQ6uSB/elEeyDII7O6Y1VHYWXC9EklpwxaXQGRbJoKh9rRhItEfjFGuY4qWhHQkmlIaIhErYjLRsFCMMEC0HQtbimVQofqaGKVxarkqCxqvKJqmKRoZNQd8NlsxSuajvMaBcp6TokCSysk8Qi6sNxGWTByjIoAVaMDTHGhmoyLgRFZgOK5sJRVaBh2kWyYxYQAV9+GK/lonC+vIUCWEoIOJEypen6hLNibqa2oXNVeGs3zF+3lIYgm7aOhbtaXC0DLJcOHI2yDfWky6igIRosLxvh2GOhUTA2BGAd+nmlf5MkFho5qssAIrjAmTdZaTlvDIMLwRXaU131SEJtZx5kGEEjLkN6GC+98WERf1NSHvsdiVDF3ToROjaqsSKxJNTVS8QVdaJWhU0UttBA0jadHJquW0oMqaAACQaQmWsYCVlf6N+rz1szxsp2rLVHWPMxRaZOEqSFDDodzwIp/FDTFqNBudhIY9RNl2FQMcRohdeCCJLm41vbTCNCEi5L8+OAODqzF2dNnFcNDD8Amfohgl2bauUsMnfSn2q6cdxahWjG0xHG5ra2PaOMZyUuEIAGx4ecPCpNIK0xLl2Xq17tvrD15A634oCiQrkS7ijE2wtBOpEgBmiopzkYpItKKf96Gw4sNH/zWQFXN4aEGMWYFwkspXSBoQ5EhUANJYVEi8X6RhDweUpQydlpw1ENuGpEBaITpz09DRVZHjtQhXoUFajQoaXSZoGi3zapRmNQgBhLKsCBX/p0LJVepJxbJhk2XoSmZsBD9mYnfUJsnBmSo3Q96ThG7yyFX79w0VeaE+ziC9Wn/4QD0fiDiRbJ3xFM4oVjpsSeTT5g21+KhDuRiFZTfDpFyIMIGtktMl50U6kQhDCkXNfUlfGZIAcl9COhfVVfCoNvLrnSFM6qlWjB5qz/ZRkOJVN2NYKR1hXUGM7arWI0kvYdv16bSLJdmA9WN0svw3p8p9w9NJ2zWuYiI57UuurvY1TIyfYQatUxgHIst1SKvINHr9Q7O1Bprka4wdyzCgs4zNjQmv1kdI9jjL8UMeXKNTwRh2TeNI24qhEwm1jLfInkhGdQmPr6hZnhciXIQVhEeKq9rPaXMmx3agcP23TyzC+RbCUH0MPX546IVDPM//sZ2BY6AzcCQ/EADlgGZLwcvBgqWFBZMoRJoCBkmmKlvtjC5pDDl6TfJ/2oHMGpixJd3JDwb0i+eVP7KuOnavAtMGLzuKC9iJWTcf4IV7M0XsM8+XsALgOcBGAccKK8GL92YL2amFz+7YuT70w5mb702OXDh6Saxh5uzftQmUDBoFAkV5hZ2BvOdM6mp0zt6nPzvo9m5atXrC6q55N0r1bVUpY850uL1ixgcbT+fvqcXv7AhuOXHk6BcrnPjN7h2vlbcc/aWzeWfogLuvmP0mteHA+VfvbJkCZlX+nHr9kPz58ruT7xzv+u3vnu3JtecmJY+3vd+25LsrJyZtFb4M3u4+J75RfbJ4z5EpT82tOnbuk7qfzt46fblr8+ZI5dy5293SFrmhI/LSqd+v3T0b3XRo26dXU8lob6z40q9vX/t6w9pua92CK7s+Ork0/vEFdfGpYN33vVdn1h7Yu+/wvJ7Vm4IXu2+LtxaceHfm4cNv/XV9dvmlG39W6gfrjI1np11+6TqzrmfG1MRXZ/ZvrfuwcXbJhEjPj31p/AfKobxmhBIAAA==';
var ebay_auth = 'v^1.1#i^1#p^3#r^0#I^3#f^0#t^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';
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
  xmlhttp.open("POST","https://api.sandbox.ebay.com/sell/inventory/v1/inventory_item/"+upc,true);
  //xmlhttp.open("GET","https://api.sandbox.ebay.com/buy/browse/v1/item_summary/search?"+qs,true);
  xmlhttp.setRequestHeader('Authorization','Bearer '+ebay_auth);
  //xmlhttp.setRequestHeader('X-EBAY-C-MARKETPLACE-ID','EBAY_US');
  //xmlhttp.setRequestHeader('Content-Language','en-US');
  xmlhttp.send();
}





