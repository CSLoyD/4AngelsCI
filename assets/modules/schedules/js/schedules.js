document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {

selectable: true,

dateClick: function(info) {
    $('input[name=DateShift]').val(info.dateStr);
    // $('input[name=DateShift]').val('2014-01-08');
    $("#modal_addUser").modal();

    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    // alert('Current view: ' + info.view.type);
    // change the day's background color just for fun
    // info.dayEl.style.backgroundColor = 'red';
},


initialView: 'dayGridMonth',
initialDate: '2021-11-07',
headerToolbar: {
left: 'prev,next today',
center: 'title',
right: 'dayGridMonth,timeGridWeek,timeGridDay'
},
events: [
{
  title: 'All Day Event',
  start: '2021-11-01'
},
{
  title: 'Long Event',
  start: '2021-11-07',
  end: '2021-11-10'
},
{
  groupId: '999',
  title: 'Repeating Event',
  start: '2021-11-09T16:00:00'
},
{
  groupId: '999',
  title: 'Repeating Event',
  start: '2021-11-16T16:00:00'
},
{
  title: 'Conference',
  start: '2021-11-11',
  end: '2021-11-13'
},
{
  title: 'Meeting',
  start: '2021-11-12T10:30:00',
  end: '2021-11-12T12:30:00'
},
{
  title: 'Lunch',
  start: '2021-11-12T12:00:00'
},
{
  title: 'Meeting',
  start: '2021-11-12T14:30:00'
},
{
  title: 'Birthday Party',
  start: '2021-11-13T07:00:00'
},
{
  title: 'Click for Google',
  url: 'http://google.com/',
  start: '2021-11-28'
}
]
});


calendar.render();
});


$(document).ready(function(){


});
