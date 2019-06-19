function throwError(title,mess,btnt){
  document.getElementById('eTitle').innerHTML = title;
  document.getElementById('eMess').innerHTML = mess;
  document.getElementById('eBtn').innerHTML = btnt;
  $("#errorModal").modal("show");
}