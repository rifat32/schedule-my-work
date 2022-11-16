@extends("app")

@section("body")
<div class="container">
    <h2>Crate Project</h2>
    <form  action="{{route('projects.store')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name"  placeholder="Name">
        </div>
  <br>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection
