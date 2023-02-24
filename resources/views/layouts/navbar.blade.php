<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Library Demo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{url('/')}}">Books</a>
      </li>
    </ul>
</div>
@if(\Request::route()->getName() == 'books.index')
<div class="float-right">
    <a class="btn btn-primary ml-1" class="" href="{{route('books.create')}}"><i class="fa fa-plus"></i> Add Book</a>
</div>
@endif
</nav>
