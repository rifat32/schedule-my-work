@extends("app")

@section("body")
<script defer type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container mt-5">
    <form  action="{{route('works.list')}}" method="GET">

       <div class="row">
        <div class="col-9">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="start_date">Start Time</label>
                        <input type="date"  class="form-control" id="start_date" name="start_date" value="{{$start_date}}"  />


                      </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="stop_date">Stop Time</label>
                        <input type="date"  class="form-control" id="stop_date" name="stop_date" value="{{$stop_date}}" />


                      </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="work_description">Project</label>
                        <select  class="form-control" id="project_id" name="project_id" >
                            <option value="">
                                please select
                            </option>
                            @foreach ($projects as $project)
                            <option value="{{$project->id}}" @if ($project_id == $project->id)
                                selected
                            @endif>
                                {{$project->name}}
                            </option>
                            @endforeach
                        </select>

                      </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <h1 class="text-center mt-3"><button type="submit" class="btn btn-primary">Filter</button></h1>
        </div>
       </div>





      </form>
</div>

<div class="container">
    <table class="table table-striped" id="works_table">
        <thead>
            <tr>
               <th>Id</th>
               <th>Project</th>
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
    if(!$dateTwo){
        $dateTwo = now();
    }
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
    $start_dates = "";
@endphp



            @foreach ($works as $work)
            @php
            $datetime1 = new DateTime($work->start_time);//start time
        $datetime2 = new DateTime($work->stop_time);//end time
        $interval = $datetime1->diff($datetime2);

        $millisecs = millisecsBetween($work->start_time,$work->stop_time);

        $total["time"] += $millisecs;

        $start_dates_obj = new DateTime($work->start_time);

$start_dates_obj2 = new DateTime($work->start_time);
$stop_dates_obj2 = new DateTime($work->stop_time);


        @endphp

        @if ($start_dates_obj->format("d/m/Y") != $start_dates)
            @php
                $start_dates = $start_dates_obj->format("d/m/Y");
            @endphp
               <tr class="bg-success">
                <td></td>
                <td></td>
                <td>{{$start_dates}}-{{date('l', strtotime($work->start_time))}} </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
            <tr>
                <td>{{$work->id}}</td>
                <td>{{$work->project->name}}</td>
                <td>{{$start_dates_obj2->format("H:i:s")}}</td>
                <td>{{$stop_dates_obj2->format("H:i:s")}}</td>
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
                <td></td>
                <td>{{formatMilliseconds($total["time"]) }}
                    {{-- || {{formatMilliseconds($milli)}} --}}

                </td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>


    </table>

    <button onclick="ExportToExcel('xlsx')">Export table to excel</button>
    <button id="download" onclick="ExportPdf()">Download as PDF</button>
</div>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('works_table');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
<script type="text/javascript">
    function ExportPdf() {
         window.print();


        html2canvas(document.getElementById('works_table'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("Working.pdf");
            }
        });
    }
</script>
@endsection
