<div id="myEvent"></div>

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.css') }}">
<style>

.fc-event {
    margin: 2px;
    box-shadow: none !important;
}

.fc-time-grid .fc-slats td {
  height: 3em; // Change This to your required height
  border-bottom: 0;
}

.risk {
    text-decoration: line-through
}
    
</style>
@overwrite

@section('scripts')
    @parent


<script src="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale/pt-br.js"></script>

<script>
    $(document).ready(function () {

        var calendar = $('#myEvent').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    height: 'auto',
                    defaultView: 'agendaWeek',
                    editable: false,
                    selectable: true,
                    allDaySlot: false,
                    displayEventTime : false,
                    minTime: "06:00:00",
                    maxTime: "21:00:00",
                    slotDuration: '00:60:00',
                    // eventLimit: true,
                    timeFormat: 'H(:mm)',
                    slotEventOverlap:false,
                    hiddenDays: [0],
                    slotLabelFormat: [
                        'HH:mm', // top level of text
                        ],
                    events: {
                        url: '{{ route('class.index') }}',
                        data: function() {
                            obj = {}
                            $('.calendar-comp').each(function (index, element) {
                                name = $(this).attr('name');
                                obj[name] = $(element).val()
                            });

                            return obj
                        }
                    },

                    eventRender: function(event, element) {
                        element.find(".fc-title").html(event.title);
                    },
                    eventClick:  function(event, jsEvent, view) {
                        
                        showClass(event.id)
                    },
                    dayClick: function(date, jsEvent, view) {

                        // alert('Clicked on: ' + date.format());

                        // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                        // alert('Current view: ' + view.name);

                        // change the day's background color just for fun
                        // $(this).css('background-color', 'red');

                    }
                    
                });


                


                function getEvents() {
                    return  {
                         url: '{{ route('class.index') }}',
                        data: {
                            instructor: $('[name=instructor]').val()
                        }
                    }
                }

        
                $('.calendar-comp').change(function (e) { 
                    console.log(calendar)
                    calendar.fullCalendar('refetchEvents');
                });

    });

    function showClass(id) {
        $.ajax({
                type: "get",
                url: "class/" + id,
                success: function (response) {

                    // $('#modelId').modal('hide');
                    $('#modelId .modal-content').html(response);
                    $('#modelId').modal('show')
                }
            });
    }
</script>
@overwrite