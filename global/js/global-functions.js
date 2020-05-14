function urlEncode(url){
		url = url.replace(/&/g, '%26'); 
		url = url.replace(/#/g, '%23');
		return url;
	}

function toast_alert(title,mess,pos,mode){
  $.toast({
		heading: title,
		text: mess,
		position: pos,
		loaderBg:'#f2b701',
		icon: mode,//success, error, info, warning...
		hideAfter: 3500, 
		stack: 6
	});
}


$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function init_tooltips(){
  $('[data-toggle="tooltip"]').tooltip();
}