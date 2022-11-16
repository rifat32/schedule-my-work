@extends("app")

@section("body")
<div class="container mt-5">

    <form  action="{{route('works.store')}}" method="POST">
        @csrf
<h1 class="text-center"><button type="submit" class="btn btn-lg btn-danger">Start Work</button></h1>

      </form>
</div>
@endsection
