@extends("app")

@section("body")
<div class="container">
    <a href="{{route('projects.create')}}" class="btn btn-primary ms-auto">create</a>
</div>
<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
               <th>Id</th>
               <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>{{$project->name}}</td>
            </tr>

            @endforeach
        </tbody>


    </table>

    {{$projects->links()}}

</div>
@endsection
