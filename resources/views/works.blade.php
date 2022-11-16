@extends("app")

@section("body")
<div class="container mt-5">
    <form  action="{{route('works.list')}}" method="GET">

       <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="start_date">Start Time</label>
                        <input type="date"  class="form-control" id="start_date" name="start_date" value="{{$start_date}}"  />


                      </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="stop_date">Stop Time</label>
                        <input type="date"  class="form-control" id="stop_date" name="stop_date" value="{{$stop_date}}" />


                      </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h1 class="text-center mt-3"><button type="submit" class="btn btn-primary">Filter</button></h1>
        </div>
       </div>





      </form>
</div>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
               <th>Id</th>
               <th>Start Time</th>
               <th>End Time</th>
               <th>Work Time</th>
               <th>Description</th>
               <th>Reason</th>
            </tr>
        </thead>
        <tbody>
 @php
     function millisecsBetween($dateOne, $dateTwo, $abs = true) {
    $func = $abs ? 'abs' : 'intval';
    return $func(strtotime($dateOne) - strtotime($dateTwo)) * 1000;
}

function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;


    return ($hours . "hours " . $minutes . "minutes " . $seconds . "seconds");


    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);

    return rtrim($time, '0');
}
            @endphp

@php
    $total["time"] = 0;
@endphp



            @foreach ($works as $work)
            @php
            $datetime1 = new DateTime($work->start_time);//start time
        $datetime2 = new DateTime($work->stop_time);//end time
        $interval = $datetime1->diff($datetime2);

        $millisecs = millisecsBetween($work->start_time,$work->stop_time);

        $total["time"] += $millisecs;

        @endphp
            <tr>
                <td>{{$work->id}}</td>
                <td>{{$work->start_time}}</td>
                <td>{{$work->stop_time}}</td>
                <td>{{$interval->format('%H hours %i minutes %s seconds') }}
                    {{-- || {{formatMilliseconds($milli)}} --}}

                </td>
                <td>{{$work->work_description}}</td>
                <td>{{$work->reason_of_stop}}</td>
            </tr>

            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>{{formatMilliseconds($total["time"]) }}
                    {{-- || {{formatMilliseconds($milli)}} --}}

                </td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>


    </table>



</div>
@endsection
