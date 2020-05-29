var sub_btn_txt = 'Submit Item';

//Delay Function...
function sleep(milliseconds) {
  console.warn('Sleeping For '+milliseconds+' milliseconds...');
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}