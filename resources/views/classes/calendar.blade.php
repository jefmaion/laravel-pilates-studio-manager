<div id="myEvent"></div>

@section('css')
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
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale/pt-br.js"></script>

<script>
    $(document).ready(function () {


        // $.ajax({
        //     type: "get",
        //     url: "{{ route('class.index') }}",
        //     dataType: "json",
        //     success: function (response) {
                

        //         var calendar = $('#myEvent').fullCalendar({
        //             height: 'auto',
        //             defaultView: 'agendaWeek',
        //             editable: true,
        //             selectable: true,
        //             allDaySlot: false,
        //             minTime: "06:00:00",
        //             maxTime: "21:00:00",
        //             slotDuration: '00:30:00',
        //             // eventLimit: true,
        //             timeFormat: 'H(:mm)',
        //             slotEventOverlap:false,
        //             slotLabelFormat: [
        //                 'HH:mm', // top level of text
        //                 ],
        //             events: response,
        //             eventRender: function(event, element) {
        //                     element.find(".fc-title").html(event.title);
        //             },
        //             header: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'month,agendaWeek,agendaDay'
        //             },
        //         });

        //     }
        // });


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
                        url: '{{ route('class.index') }}'
                    },
                    eventRender: function(event, element) {
                        element.find(".fc-title").html(event.title);
                    },
                    eventClick:  function(event, jsEvent, view) {
                        $.ajax({
                            type: "get",
                            url: "class/" + event.id,
                            success: function (response) {
                                $('#modelId .modal-content').html(response);
                                $('#modelId').modal('show')
                            }
                        });
                        
                    },
                    dayClick: function(date, jsEvent, view) {

                        // alert('Clicked on: ' + date.format());

                        // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                        // alert('Current view: ' + view.name);

                        // change the day's background color just for fun
                        // $(this).css('background-color', 'red');

                    }
                    
                });

        

    });
</script>
@endsection