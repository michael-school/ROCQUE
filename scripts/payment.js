//set hidden datetime input to current datetime
var datetimeInput = document.getElementById('datetime-input');
var currentDatetime = moment().format('YYYY-MM-DD HH:mm:ss');
datetimeInput.setAttribute('value', currentDatetime);