// please note, 
// that IE11 now returns undefined again for window.chrome
// and new Opera 30 outputs true for window.chrome
// but needs to check if window.opr is not undefined
// and new IE Edge outputs to true now for window.chrome
// and if not iOS Chrome check
// so use the below updated condition
var isChromium = window.chrome;
var winNav = window.navigator;
var vendorName = winNav.vendor;
var isOpera = typeof window.opr !== "undefined";
var isIEedge = winNav.userAgent.indexOf("Edge") > -1;
var isIOSChrome = winNav.userAgent.match("CriOS");
if (isIOSChrome) {
   // is Google Chrome on IOS
} else if(
  isChromium !== null &&
  typeof isChromium !== "undefined" &&
  vendorName === "Google Inc." &&
  isOpera === false &&
  isIEedge === false
) {
   // is Google Chrome
  localStorage.setItem('isChrome','true');
  //addChromeNotification();
} else { 
   // not Google Chrome 
  localStorage.setItem('isChrome','false');
  addChromeNotification();
}


function addChromeNotification(){
  var noteBox = document.getElementById('chromeNotification');
  
  var divCol = document.createElement('div');
  divCol.setAttribute('class','col-lg-12');
  var divAlert = document.createElement('div');
  divAlert.setAttribute('class','alert alert-danger alert-dismissable');
  var btn = document.createElement('button');
  btn.setAttribute('type','button');
  btn.setAttribute('class','close');
  btn.setAttribute('data-dismiss','alert');
  btn.setAttribute('aria-hidden','true');
  btn.innerHTML = '&times;';
  var i = document.createElement('i');
  i.setAttribute('class','fa fa-exclamation-triangle');
  var strong = document.createElement('strong');
  strong.innerHTML = 'WARNING: MarketForce Detected that you are not using <a href="https://www.google.com/chrome/" target="_blank" style="color:blue;">Google Chrome</a> as your browser.'+
                      ' We suggest that you use <a href="https://www.google.com/chrome/" target="_blank" style="color:blue;">Google Chrome</a> as some features of MarketForce are only supported by'+
                      ' <a href="https://www.google.com/chrome/" target="_blank" style="color:blue;">Google Chrome</a>';
  //Build Notification...
  divAlert.appendChild(btn);
  divAlert.appendChild(i);
  divAlert.appendChild(strong);
  divCol.appendChild(divAlert);
  noteBox.appendChild(divCol);
  console.log('Chrome Alert Displayed...');
}