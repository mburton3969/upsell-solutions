//Global Variables...
var item_specifics = [];

function add_specific(){
    var sName = prompt("Name of Item Specific:");
    if(sName === '' || sName === null){
        alert('Please Enter an Item Specific Category');
        return;
    }
    //Create Input to add...
    var input = document.createElement('input');
    input.setAttribute('type','text');
    input.setAttribute('id','product_'+sName);
    input.setAttribute('style','width:32%;display:inline;');
    input.setAttribute('name','product_'+sName);
    input.setAttribute('class','form-control');
    input.setAttribute('placeholder',sName);

    var div = document.getElementById('item_specifics');
    div.appendChild(input);
    item_specifics.push(sName);
    document.getElementById('item_specifics_array').value = item_specifics;
    console.log('Input added to the application');
}