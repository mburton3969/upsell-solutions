//Globals...
var ebay_user_auth = 'v^1.1#i^1#r^0#f^0#p^1#I^3#t^H4sIAAAAAAAAAOVYa2wUVRTu9rFYofgDRUJMWEYEtJnZOzudbWfobty+QgOlhS0IGKjzuLMdmZ0Z5t6hXY1aamzkTSAhMSaGEEOBEIwJfwghhkQMoIRGUBL4ISGImKj8wFAVA96ZPthWUpZSsIn7ZzL3nnvud77znblnL+gIFr/SNb+rtyQwIX93B+jIDwTYiaA4WFQ6uSB/elEeyDII7O6Y1VHYWXC9EklpwxaXQGRbJoKh9rRhItEfjFGuY4qWhHQkmlIaIhErYjLRsFCMMEC0HQtbimVQofqaGKVxarkqCxqvKJqmKRoZNQd8NlsxSuajvMaBcp6TokCSysk8Qi6sNxGWTByjIoAVaMDTHGhmoyLgRFZgOK5sJRVaBh2kWyYxYQAV9+GK/lonC+vIUCWEoIOJEypen6hLNibqa2oXNVeGs3zF+3lIYgm7aOhbtaXC0DLJcOHI2yDfWky6igIRosLxvh2GOhUTA2BGAd+nmlf5MkFho5qssAIrjAmTdZaTlvDIMLwRXaU131SEJtZx5kGEEjLkN6GC+98WERf1NSHvsdiVDF3ToROjaqsSKxJNTVS8QVdaJWhU0UttBA0jadHJquW0oMqaAACQaQmWsYCVlf6N+rz1szxsp2rLVHWPMxRaZOEqSFDDodzwIp/FDTFqNBudhIY9RNl2FQMcRohdeCCJLm41vbTCNCEi5L8+OAODqzF2dNnFcNDD8Amfohgl2bauUsMnfSn2q6cdxahWjG0xHG5ra2PaOMZyUuEIAGx4ecPCpNIK0xLl2Xq17tvrD15A634oCiQrkS7ijE2wtBOpEgBmiopzkYpItKKf96Gw4sNH/zWQFXN4aEGMWYFwkspXSBoQ5EhUANJYVEi8X6RhDweUpQydlpw1ENuGpEBaITpz09DRVZHjtQhXoUFajQoaXSZoGi3zapRmNQgBhLKsCBX/p0LJVepJxbJhk2XoSmZsBD9mYnfUJsnBmSo3Q96ThG7yyFX79w0VeaE+ziC9Wn/4QD0fiDiRbJ3xFM4oVjpsSeTT5g21+KhDuRiFZTfDpFyIMIGtktMl50U6kQhDCkXNfUlfGZIAcl9COhfVVfCoNvLrnSFM6qlWjB5qz/ZRkOJVN2NYKR1hXUGM7arWI0kvYdv16bSLJdmA9WN0svw3p8p9w9NJ2zWuYiI57UuurvY1TIyfYQatUxgHIst1SKvINHr9Q7O1Bprka4wdyzCgs4zNjQmv1kdI9jjL8UMeXKNTwRh2TeNI24qhEwm1jLfInkhGdQmPr6hZnhciXIQVhEeKq9rPaXMmx3agcP23TyzC+RbCUH0MPX546IVDPM//sZ2BY6AzcCQ/EADlgGZLwcvBgqWFBZMoRJoCBkmmKlvtjC5pDDl6TfJ/2oHMGpixJd3JDwb0i+eVP7KuOnavAtMGLzuKC9iJWTcf4IV7M0XsM8+XsALgOcBGAccKK8GL92YL2amFz+7YuT70w5mb702OXDh6Saxh5uzftQmUDBoFAkV5hZ2BvOdM6mp0zt6nPzvo9m5atXrC6q55N0r1bVUpY850uL1ixgcbT+fvqcXv7AhuOXHk6BcrnPjN7h2vlbcc/aWzeWfogLuvmP0mteHA+VfvbJkCZlX+nHr9kPz58ruT7xzv+u3vnu3JtecmJY+3vd+25LsrJyZtFb4M3u4+J75RfbJ4z5EpT82tOnbuk7qfzt46fblr8+ZI5dy5293SFrmhI/LSqd+v3T0b3XRo26dXU8lob6z40q9vX/t6w9pua92CK7s+Ork0/vEFdfGpYN33vVdn1h7Yu+/wvJ7Vm4IXu2+LtxaceHfm4cNv/XV9dvmlG39W6gfrjI1np11+6TqzrmfG1MRXZ/ZvrfuwcXbJhEjPj31p/AfKobxmhBIAAA==';
var ebay_auth = 'v^1.1#i^1#p^3#f^0#r^0#I^3#t^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';
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





