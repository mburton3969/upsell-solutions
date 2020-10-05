function add_specific(mode,value){
    field = document.getElementById('new_'+mode+'_option');
    value = field.value;
    if(value === ''){
        toast_alert('ERROR','Please enter a valid option...','top-right','error',false);
        return;
    }
    var url = 'specifics/php/add-specifics.php';
    var params = 'mode='+mode+'&value='+value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 4 && xhr.status == 200) {
            var r = JSON.parse(this.responseText);
            if(r.response === 'GOOD'){
                toast_alert('Success',r.message,'top-right','success',false);
                field.value = '';
                add_to_list(mode,value,r.ID);
            }else{
                toast_alert('ERROR',r.message,'top-right','error',false);
            }
        }
    }
    xhr.open('POST', url, true);
    //Send the proper header information along with the request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    
}

function add_to_list(mode,value,id){

    var list = document.getElementById(mode+'_tbody');
    
    //Insert item to the list...
    var row = document.createElement('tr');
    row.setAttribute('style','padding:5px;');
    row.id = 'option_'+id;
    var option = document.createElement('td');
    option.setAttribute('style','padding:5px;');
    option.innerHTML = value;
    var action = document.createElement('td');
    action.setAttribute('style','color:#FFF;');
    var btn = document.createElement('button');
    btn.setAttribute('type','button');
    btn.setAttribute('class','btn btn-danger btn-sm');
    btn.setAttribute('style','padding: 0px 5px;');
    btn.setAttribute('onclick','remove_specific('+id+');');
    btn.innerHTML = 'X';
    row.appendChild(option);
    action.appendChild(btn);
    row.appendChild(action);
    list.appendChild(row);
    console.log('Addition Complete...');
}


function remove_specific(sid){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
              var r = JSON.parse(this.responseText);
              if(r.response === 'GOOD'){
                toast_alert('Success',r.message,'top-right','success',false);
                document.getElementById('option_'+sid).remove();
              }else{
                toast_alert('ERROR',r.message,'top-right','error',false);
              }
        }
    }
    xmlhttp.open('GET', 'specifics/php/remove-specifics.php?sid='+sid, true);
    xmlhttp.send();
}


(function load_specifics(){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
              var r = JSON.parse(this.responseText);
              if(r.response === 'GOOD'){
                  console.log(r.data);
                r.data.forEach(function(opt){
                    add_to_list(opt.filter_group_id,opt.name,opt.filter_id);
                });
                console.log('Specifics Loaded...');
              }else{
                toast_alert('ERROR',r.message,'top-right','error',false);
              }
        }
    }
    xmlhttp.open('GET', 'specifics/php/get-specifics.php', true);
    xmlhttp.send();
})();