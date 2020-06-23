//Global Variables...
var current_channel_id = '0';
var current_channel_name = 'Chat';

function set_current_channel(channel_id,channel_name){
  current_channel_id = channel_id;
  current_channel_name = channel_name;
  document.getElementById('chat_name_title').innerHTML = channel_name;
}

function load_chat(mode){
  if(mode === 'ALL'){
    document.getElementById('chat_window').innerHTML = '<li></li>';
  }
  var params = 'mode='+mode;
  params += '&channel_id='+current_channel_id;
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
      if(r.response === 'GOOD'){
        if(r.messages.length > 0 && mode === 'Fetch'){
          playAudio();
        }
        for(var i = r.messages.length; i > 0; i--){
          var m = r.messages[i-1];
          add_message(m.mode,m.message,m.time,m.user,m.initials);
        }
        if(r.messages.length > 0){
          var objDiv = document.getElementById("chat_window");
          objDiv.scrollTop = objDiv.scrollHeight;
        }
      }else{
        toast_alert('Chat Error','Message not Delivered...','top-right','error');
      }
      
    }
  }
  xmlhttp.open('POST', "global/php/chat.php", true);
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xmlhttp.send(params);
}


function load_notify(mode){
  var params = 'mode='+mode;
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
      if(r.response === 'GOOD'){
        var nb = document.getElementById('chat-badge');
        if(r.notifications > 0 && r.notifications !== parseInt(nb.innerHTML)){
          notify(r.notifications);
          playAudio();
        }else{
          if(r.notifications === 0){
            nb.style.display = 'none';
          }
        }
      }else{
        console.log('Nofication Error...');
      }
      
    }
  }
  xmlhttp.open('POST', "global/php/chat.php", true);
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xmlhttp.send(params);
}



/*Chat Functions*/
	$(document).on("keypress","#input_msg_send",function (e) {
		if ((e.which == 13)&&(!$(this).val().length == 0)) {
      var mBox = $(this);
      var m = $(this).val();
      var params = 'mode=Add';
      params += '&message='+$(this).val();
      params += '&channel_id='+current_channel_id;
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
          if(r.response === 'GOOD'){
            var cur_time = getTimestamp(new Date);
            $('<li class="self mb-10"><div class="self-msg-wrap"><div class="msg block pull-right">' + m + '<div class="msg-per-detail mt-5"><span class="msg-time txt-grey">' + cur_time + '</span></div></div></div><div class="clearfix"></div></li>').insertAfter(".fixed-sidebar-right .chat-content  ul li:last-child");
			      document.getElementById('input_msg_send').value = '';
            var objDiv = document.getElementById("chat_window");
            objDiv.scrollTop = objDiv.scrollHeight;
          }else{
            toast_alert('Chat Error','Message not Delivered...','top-right','error');
          }
          
        }
      }
      xmlhttp.open('POST', "global/php/chat.php", true);
      xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlhttp.send(params);
			
		} else if(e.which == 13) {
			toast_alert('Chat Error','Please type something!','top-right','error');
		}
		return;
	});



function add_message(mode,mess,time,user,initials){
  if(mode == 'self'){
    $('<li class="self mb-10"><div class="self-msg-wrap"><div class="msg block pull-right">' + mess + '<div class="msg-per-detail mt-5"><span class="msg-time txt-grey">' + time + '</span></div></div></div><div class="clearfix"></div></li>').insertAfter(".fixed-sidebar-right .chat-content  ul li:last-child");
  }
  if(mode == 'friend'){
    $('<li class="friend"><div class="friend-msg-wrap"><img class="user-img img-circle block pull-left" src="https://via.placeholder.com/100/FF0000/000000?text=' + initials + '" alt="user"><div class="msg pull-left"><p>' + mess + '</p><div class="msg-per-detail  text-right"><span class="msg-time txt-grey">' + user + ' - ' + time + '</span></div></div><div class="clearfix"></div></div></li>').insertAfter(".fixed-sidebar-right .chat-content  ul li:last-child");
  }
}


function getTimestamp(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}



function playAudio() { 
  var x = document.getElementById("chat-notification"); 
  x.play(); 
} 

function pauseAudio() { 
  var x = document.getElementById("chat-notification"); 
  x.pause(); 
} 

function notify(num){
  var nb = document.getElementById('chat-badge');
  nb.innerHTML = num;
  nb.style.display = 'inline';
}

(function(){
  if(current_channel_id != '' && current_channel_id != '0'){
    load_chat('ALL');
  }else{
    load_notify('Notify');
    console.log('Chat is off...');
  }
  setInterval(function(){
    if(current_channel_id != '' && current_channel_id != '0'){
      load_chat('Fetch');
    }else{
      load_notify('Notify');
      console.log('Chat is off...');
    }
  },3000);
})();