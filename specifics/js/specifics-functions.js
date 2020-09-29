function add_specific(){
    
    var url = 'specifics/php/specifics-controller.php';
    var params = Params;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 4 && xhr.status == 200) {
            var r = JSON.parse(this.responseText);
            
        }
    }
    xhr.open('POST', url, true);
    //Send the proper header information along with the request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    
}