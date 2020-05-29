function get_current_selling() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if (r.response == 'GOOD') {

        console.log('DONE');
        for(var i = 0; i < r.item.length; i++){
          create_card(r.item[i].item_data);
        }

      }

    }
  }
  xmlhttp.open('GET', "assets/ebay/get-ebay-current-selling.php", true);
  xmlhttp.send();
}


function create_card(data) {
  console.log(data);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if (r.response == 'GOOD') {
        var x = r.item_data;
        //Create the card elements...
        var card = document.createElement('div');
        card.setAttribute('class','col-lg-2 col-md-4 col-sm-4 col-xs-6');
        var panel = document.createElement('div');
        panel.setAttribute('class','panel panel-default card-view pa-0');
        panel.setAttribute('style','height:346px;');
        var wrapper = document.createElement('div');
        wrapper.setAttribute('class','panel-wrapper collapse in');
        var body = document.createElement('div');
        body.setAttribute('class','panel-body pa-0');
        var article = document.createElement('article');
        article.setAttribute('class','col-item');
        var photo = document.createElement('div');
        photo.setAttribute('class','photo');
        var options = document.createElement('div');
        options.setAttribute('class','options');
        var edit_btn = document.createElement('a');
        edit_btn.setAttribute('href','index.php?edit_ebay_listing='+data.ItemID);
        edit_btn.setAttribute('class','font-18 txt-grey mr-10 pull-left');
        var edit_icon = document.createElement('i');
        edit_icon.setAttribute('class','zmdi zmdi-edit');
        var rm_btn = document.createElement('a');
        rm_btn.setAttribute('href','#');
        rm_btn.setAttribute('class','font-18 txt-grey pull-left sa-warning');
        var rm_icon = document.createElement('i');
        rm_icon.setAttribute('class','zmdi zmdi-close');
        var import_btn = document.createElement('a');
        import_btn.setAttribute('href','index.php?import_ebay_listing='+data.ItemID);
        import_btn.setAttribute('class','font-18 txt-grey pull-left sa-primary');
        var import_icon = document.createElement('i');
        import_icon.setAttribute('class','zmdi zmdi-download');
        var img_link = document.createElement('a');
        img_link.setAttribute('href','javascript:void(0);');
        var img = document.createElement('img');
        img.setAttribute('style','width:100%;height:196px;');
        if(x.PictureURL[0]){
          img.setAttribute('src',x.PictureURL[0]);
        }else{
          img.setAttribute('src','https://via.placeholder.com/500');
        }
        img.setAttribute('class','img-responsive');
        img.setAttribute('alt','Product Image');
        var info = document.createElement('div');
        info.setAttribute('class','info');
        var h6 = document.createElement('h6');
        h6.innerHTML = data.Title;
        var price = document.createElement('span');
        price.setAttribute('class','head-font block text-warning font-16');
        price.innerHTML = '$'+data.SellingStatus.CurrentPrice.value;

        //Compile the Card...
        //edit_btn.appendChild(edit_icon);
        //options.appendChild(edit_btn);
        import_btn.appendChild(import_icon);
        options.appendChild(import_btn);
        //rm_btn.appendChild(rm_icon);
        //options.appendChild(rm_btn);
        photo.appendChild(options);
        img_link.appendChild(img);
        photo.appendChild(img_link);
        info.appendChild(h6);
        info.appendChild(price);
        article.appendChild(photo);
        article.appendChild(info);
        body.appendChild(article);
        wrapper.appendChild(body);
        panel.appendChild(wrapper);
        card.appendChild(panel);

        //Add Card to Container...
        var container = document.getElementById('item-card-container');
        container.appendChild(card);

      }

    }
  }
  xmlhttp.open('GET', "assets/ebay/get-ebay-listing-by-id.php?iid="+data.ItemID, true);
  xmlhttp.send();
}

(function() {
  get_current_selling();
})();