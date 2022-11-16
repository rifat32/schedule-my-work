@extends("app")

@section("body")
@php
    $datetime1 = new DateTime($work->start_time);//start time
$datetime2 = new DateTime(now());//end time
$interval = $datetime1->diff($datetime2);

@endphp

<div class="container">
    <h4 class="text-center">Start Time: {{$datetime1->format('Y/m/d H:i:s')}} </h4>
    <h2 class="text-center">Time: {{$interval->format('%H hours %i minutes %s seconds')}} </h2>
    <form  action="{{route('works.custom.stop.store')}}" method="POST">

        <div class="form-group">
            <label for="work_description">Description</label>
            <textarea  class="form-control" id="work_description" name="work_description"  placeholder="work_description">

            </textarea>
          </div>
          <div class="form-group">
            <label for="reason_of_stop">Reason</label>
            <textarea  class="form-control" id="reason_of_stop" name="reason_of_stop"  placeholder="reason_of_stop">

            </textarea>
          </div>
          <div class="form-group">
            <label for="stop_time">Stop Time</label>
            <input type="datetime-local"  class="form-control" id="stop_time" name="stop_time"  />


          </div>

        @csrf
<h1 class="text-center"><button type="submit" class="btn btn-lg btn-success">Stop</button></h1>

      </form>
</div>

@endsection
