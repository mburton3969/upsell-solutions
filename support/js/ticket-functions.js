//Global Variables...
var inboxID = '27290';

(function(){
  get_tickets(1);
})();


function get_tickets(page){
  
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
			//console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if(r.response === 'GOOD'){
        var ticket_count = 0;
        for(var i = 0; i < r.tickets.length; i++){
          var rr = r.tickets[i];
          add_ticket(rr);
          ticket_count++;
        }
        //Handle Pagination...
        if(r.pagination.page < r.pagination.pages){
          var p = r.pagination.page + 1;
          get_tickets(p);
        }else{
          $("#support_table").dataTable({
            "paging": false,
            "order": [[ 0, "desc" ]]
          });
          document.getElementById('support_table_filter').style.float = 'left';
        }
        //Set the total ticket count...
        //alert(ticket_count);
      }else{
        console.warn(r.message);
      }
    }
  }
  xmlhttp.open("GET","support/teamwork-api/get-support-tickets.php?pageNum="+page+"&inboxID="+inboxID,true);
  xmlhttp.send();
}



function add_ticket(t){
  if(t.ticket_id !== undefined){
    var tbody = document.getElementById('ticket_table_tbody');

    var row = document.createElement('tr');

    //Ticket ID...
    var cell = document.createElement('td');
    var link = document.createElement('a');
    link.setAttribute('href','javascript:load_ticket_modal('+t.ticket_id+',\''+t.customer_name+'\',\''+t.agent+'\');');
    link.setAttribute('style','color:blue;text-decoration:underline;');
    link.innerHTML = t.ticket_id;
    cell.appendChild(link);
    row.appendChild(cell);

    //Customer...
    var cell = document.createElement('td');
    cell.innerHTML = t.customer_name;
    row.appendChild(cell);

    //Created Date...
    var cell = document.createElement('td');
    cell.innerHTML = t.created_date;
    row.appendChild(cell);

    //Ticket Type...
    var cell = document.createElement('td');
    cell.innerHTML = t.ticket_type;
    row.appendChild(cell);

    //Issue...
    var cell = document.createElement('td');
    var pb = document.createElement('p');
    pb.setAttribute('style','font-weight:bold;color:#FFF;');
    pb.innerHTML = t.subject;
    var p = document.createElement('p');
    p.innerHTML = '"'+t.preview+'"';
    cell.appendChild(pb);
    cell.appendChild(p);
    row.appendChild(cell);

    //Updated Date...
    var cell = document.createElement('td');
    cell.innerHTML = t.updated_date;
    row.appendChild(cell);

    //Agent...
    var cell = document.createElement('td');
    cell.innerHTML = t.agent;
    row.appendChild(cell);

    //Priority...
    var cell = document.createElement('td');
    var icon = document.createElement('i');
    icon.setAttribute('class','fas fa-exclamation-triangle');
    icon.setAttribute('style','white-space: nowrap;color:'+t.priority_bg+';');
    var text = document.createTextNode(' '+t.priority.toUpperCase());
    icon.appendChild(text);
    cell.appendChild(icon);
    row.appendChild(cell);

    //Status...
    var cell = document.createElement('td');
    var bClass;
    var bColor;
    if(t.ticket_status === 'Pending'){
      bClass = 'success';
      bColor = '#000';
    }
    if(t.ticket_status === 'In-Progress'){
      bClass = 'primary';
      bColor = '#FFF';
    }
    if(t.ticket_status === 'On-hold'){
      bClass = 'danger';
      bColor = '#FFF';
    }
    if(t.ticket_status === 'Waiting on customer'){
      bClass = 'warning';
      bColor = '#000';
    }
    var badge = document.createElement('span');
    badge.setAttribute('class','badge badge-'+bClass);
    badge.setAttribute('style','font-weight:bold;font-size:15px;color:'+bColor+';');
    badge.innerHTML = t.ticket_status;
    cell.appendChild(badge);
    row.appendChild(cell);

    //Actions...
    //var cell = document.createElement('td');
    //cell.innerHTML = '';
    //row.appendChild(cell);

    //Add Row to table...
    tbody.appendChild(row);
  }
}


function load_ticket_modal(tid,user,agent){
  
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
			//console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if(r.response === 'GOOD'){
        if(r.ticket_data.included.messages){
          document.getElementById('ticket_notes_box').innerHTML = '';
          for(var i = r.ticket_data.included.messages.length; i > 0; i--){
            var rr = r.ticket_data.included.messages[i-1];
            add_message(rr,user,agent);
          }
        }
        document.getElementById('ticket_num').innerHTML = r.ticket_data.ticket.id;
        $('#viewTicketModal').modal('show');
      }else{
        console.warn(r.message);
      }
    }
  }
  xmlhttp.open("GET","support/teamwork-api/get-ticket-by-id.php?ticket_id="+tid+"&inboxID="+inboxID,true);
  xmlhttp.send();
}


function add_message(d,user,agent){
  var tb = document.getElementById('ticket_notes_box');
  
  //Event Info Box...
  if(d.threadType === 'eventinfo'){
    var alert = document.createElement('div');
    alert.setAttribute('class','alert alert-default');
    alert.setAttribute('style','border-radius:10px;');
    var icon = document.createElement('i');
    icon.setAttribute('class','fas fa-info-circle mr-15');
    alert.appendChild(icon);
    var text = document.createTextNode(moment(d.createdAt).format('M/D/Y, hh:mm A')+': '+d.textBody);
    alert.appendChild(text);
    tb.appendChild(alert);
  }else{
  
    //Note Box...
    if(d.threadType === 'note'){
      var bg = 'background:yellow;';
      var title_icon = 'far fa-sticky-note';
    }

    //Message Box...
    if(d.threadType === 'message'){
      var bg = '';
      var title_icon = 'far fa-comments';
    }

    if(d.createdBy.type === 'customers'){
      var ta = 'right';
      var lc = 'info'
      var name = user;
    }else{
      var ta = 'left';
      var lc = 'primary'
      var name = agent;
    }
    var h4 = document.createElement('h4');
    h4.setAttribute('style','margin-bottom:0px;text-align:'+ta+';');
    var span = document.createElement('span');
    span.setAttribute('class','label label-'+lc);
    span.setAttribute('style','font-size:20px;');
    var icon = document.createElement('i');
    icon.setAttribute('class',title_icon+' ml-5');
    icon.innerHTML = ' '+name+' -- '+moment(d.createdAt).format('M/D/Y, hh:mm A');
    var div = document.createElement('div');
    div.setAttribute('class','well well-sm');
    div.setAttribute('style','color:#000;border-radius:10px;'+bg);
    div.innerHTML = d.textBody
    //Compile...
    span.appendChild(icon);
    h4.appendChild(span);
    tb.appendChild(h4);
    tb.appendChild(div);
      
  }
  
}