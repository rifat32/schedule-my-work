@extends("app")

@section("body")
<div class="container mt-5">

    <form  action="{{route('works.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="work_description">Project</label>
            <select  class="form-control" id="project_id" name="project_id" >
                <option value="">
                    please select
                </option>
                @foreach ($projects as $project)
                <option value="{{$project->id}}">
                    {{$project->name}}
                </option>
                @endforeach
            </select>

          </div>
<h1 class="text-center"><button type="submit" class="btn btn-lg btn-danger">Start Work</button></h1>

      </form>
</div>
@endsection
