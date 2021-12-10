//set hidden datetime input to current datetime
var dateInput = document.getElementsByClassName('date-input');
var currentDate = moment().format('YYYY-MM-DD');

for (let element of dateInput) {
    element.setAttribute('value', currentDate);
}
