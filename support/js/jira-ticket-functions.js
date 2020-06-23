//Global Variables...
var project_key = 'RSA';

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
      if(r.issues.length > 0){
        var ticket_count = 0;
        for(var i = 0; i < r.issues.length; i++){
          var rr = r.issues[i];
          add_ticket(rr);
          ticket_count++;
        }
        //Handle Pagination...
        //if(r.pagination.page < r.pagination.pages){
        //  var p = r.pagination.page + 1;
        //  get_tickets(p);
        //}else{
          $("#support_table").dataTable({
            "paging": false,
            "order": [[ 0, "desc" ]]
          });
          document.getElementById('support_table_filter').style.float = 'left';
        //}
        //Set the total ticket count...
        //alert(ticket_count);
      }else{
        console.warn(r.message);
      }
    }
  }
  xmlhttp.open("GET","support/jira-api/get-all-open-issues.php?project="+project_key,true);
  xmlhttp.send();
}



function add_ticket(t){
  if(t.id !== undefined){
    var tbody = document.getElementById('ticket_table_tbody');

    var row = document.createElement('tr');

    //Ticket ID...
    var cell = document.createElement('td');
    var link = document.createElement('a');
    var agent;
    if(t.fields.assignee === null){
      agent = 'Not Set';
    }else{
      agent = t.fields.assignee.displayName;
    }
    link.setAttribute('href','javascript:load_ticket_modal(\''+t.key+'\',\''+t.fields.reporter.displayName+'\',\''+agent+'\');');
    //link.href = t.self;
    link.setAttribute('style','color:blue;text-decoration:underline;');
    link.innerHTML = t.key;
    cell.appendChild(link);
    row.appendChild(cell);

    //Customer...
    var cell = document.createElement('td');
    cell.innerHTML = t.fields.reporter.displayName;
    row.appendChild(cell);

    //Created Date...
    var cell = document.createElement('td');
    var d = new Date(t.fields.created);
    cell.innerHTML = d.getMonth() + '/' + d.getDate() + '/' + d.getFullYear();
    row.appendChild(cell);

    //Ticket Type...
    var cell = document.createElement('td');
    cell.innerHTML = t.fields.issuetype.name;
    row.appendChild(cell);

    //Issue...
    var cell = document.createElement('td');
    var pb = document.createElement('p');
    pb.setAttribute('style','font-weight:bold;color:#FFF;');
    pb.innerHTML = t.fields.summary;
    var p = document.createElement('p');
    p.innerHTML = '"'+t.fields.description+'"';
    cell.appendChild(pb);
    cell.appendChild(p);
    row.appendChild(cell);

    //Updated Date...
    var cell = document.createElement('td');
    var d = new Date(t.fields.updated);
    cell.innerHTML = d.getMonth() + '/' + d.getDate() + '/' + d.getFullYear();
    row.appendChild(cell);

    //Agent...
    var cell = document.createElement('td');
    if(t.fields.assignee !== null){
      var agent = t.fields.assignee.displayName;
    }else{
      var agent = 'Not Set';
    }
    cell.innerHTML = agent;
    row.appendChild(cell);

    //Priority...
    var cell = document.createElement('td');
    //var icon = document.createElement('i');
    //icon.setAttribute('class','fas fa-exclamation-triangle');
    //icon.setAttribute('style','white-space: nowrap;');
    var div = document.createElement('div');
    div.setAttribute('style','white-space:nowrap;');
    var img = document.createElement('img');
    img.src = t.fields.priority.iconUrl;
    img.setAttribute('width','16px');
    img.setAttribute('height','16px');
    var text = document.createTextNode(' '+t.fields.priority.name.toUpperCase());
    div.appendChild(img);
    div.appendChild(text);
    cell.appendChild(div);
    row.appendChild(cell);

    //Status...
    var cell = document.createElement('td');
    var bClass = 'default';
    var bColor = '#000';
    if(t.fields.status.name === 'Waiting for support'){
      bClass = 'warning';
      bColor = '#000';
    }
    if(t.fields.status.name === 'Open'){
      bClass = 'default';
      bColor = '#000';
    }
    if(t.fields.status.name === 'On-hold'){
      bClass = 'danger';
      bColor = '#FFF';
    }
    if(t.fields.status.name === 'Waiting on customer'){
      bClass = 'warning';
      bColor = '#000';
    }
    if(t.fields.status.name === 'Work in progress'){
      bClass = 'primary';
      bColor = '#FFF';
    }
    var badge = document.createElement('span');
    badge.setAttribute('class','badge badge-'+bClass);
    badge.setAttribute('style','font-weight:bold;font-size:15px;color:'+bColor+';');
    badge.innerHTML = t.fields.status.name;
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
      if(r.key !== ''){
        //PUT DESCRIPTION HERE...
        document.getElementById('ticket_notes_box').innerHTML = '';
        if(r.total > 0){
          document.getElementById('ticket_notes_box').innerHTML = '';
          for(var i = r.comments.length; i > 0; i--){
            var rr = r.comments[i-1];
            add_message(rr,user,agent);
          }
        }
        document.getElementById('ticket_num').innerHTML = tid;
        $('#viewTicketModal').modal('show');
      }else{
        console.warn('No Data Found...');
      }
    }
  }
  xmlhttp.open("GET","support/jira-api/get-issue-details.php?issue="+tid,true);
  xmlhttp.send();
}


function add_message(d,user,agent){
  var tb = document.getElementById('ticket_notes_box');
  
  //Event Info Box...
    //Note Box...
    if(d.jsdPublic === false){
      var bg = 'background:yellow;';
      var title_icon = 'far fa-sticky-note';
    }

    //Message Box...
    if(d.jsdPublic === true){
      var bg = '';
      var title_icon = 'far fa-comments';
    }

    if(d.author.displayName === user){
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
    icon.innerHTML = ' '+name+' -- '+moment(d.created).format('M/D/Y, hh:mm A');
    var div = document.createElement('div');
    div.setAttribute('class','well well-sm');
    div.setAttribute('style','color:#000 !Important;border-radius:10px;'+bg);
    div.innerHTML = d.renderedBody;
    //Compile...
    span.appendChild(icon);
    h4.appendChild(span);
    tb.appendChild(h4);
    tb.appendChild(div);
      
}