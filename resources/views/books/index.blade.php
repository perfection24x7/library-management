@extends('layouts.app')

@section('content')
<table class="table" id="book-table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Book Name</th>
      <th scope="col">Book Year</th>
      <th scope="col">Author Name</th>
      <th scope="col">Author Genre</th>
      <th scope="col">Library Name</th>
      <th scope="col">Library Address</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<div class="modal" tabindex="-1" role="dialog" id="delete-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
      </div>
      <div class="modal-body">
      <input type="hidden" id="book-id">
          <p>
    Are you sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="deleteBook()">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    const fetch_books_url = "{!! route('book.index') !!}";
    $(document).ready(function() {
        commonAjax({},fetch_books_url,"GET",bookSuccessListResult,bookErrorListResult);
    });

    function bookSuccessListResult(data)
    {
        var edit_url = '{ url("books/edit/") }';
        if(data.status){
            const result = data.data;
            var count = 0;
            $("#book-table").find('tbody').empty();
            $.each(result,function(key,value){
                count += 1;
                var delete_btn = "<a href='#' onclick=deleteDialog("+value.id+")><i class='fa fa-trash'></i></a>";
                var edit_btn = "<a onclick=edit("+value.id+") href='#'><i class='fa fa-pencil'></i></a>";
                var libraries = [];
                var libraries_address = [];
                var library_name = "";
                var library_address = "";
                if(value.book_library.length > 0){
                    for(var i=0;i<value.book_library.length;i++){
                        libraries.push(value.book_library[i].library.library_name);
                        libraries_address.push(value.book_library[i].library.library_address);
                    }

                    library_name = libraries.toString();
                    library_address = libraries_address.toString();
                } else {
                    library_name = "-";
                    library_address = "-";
                }

                $("#book-table").find('tbody')
                .append($('<tr>')
                .append($('<td>')
                .append($('<span>'))
                .text(count)
                )
                .append($('<td>')
                        .append($('<span>'))
                        .text(value.book_name)
                        )
                        .append($('<td>')
                        .append($('<span>'))
                        .text(value.book_year)
                        )
                        .append($('<td>')
                        .append($('<span>'))
                            .text(value.author.name)
                    )
                    .append($('<td>')
                        .append($('<span>'))
                            .text(value.author.genre)
                    )
                    .append($('<td>')
                        .append($('<span>'))
                            .text(library_name)
                    )
                    .append($('<td>')
                        .append($('<span>'))
                            .text(library_address)
                    )
                    .append($('<td>')
                        .append($(edit_btn+'&nbsp;'+delete_btn))
                    )
                );
            });
        }
    }

    function deleteDialog(id) {

        $("#book-id").val(id);
        $('#delete-modal').modal('toggle');
        $('#delete-modal').modal('show');
  };

    function bookErrorListResult(data)
    {
        alert(data.message);
    }

    function edit(id)
    {
        window.location.href = '{!! url("books/edit") !!}' + "/" + id;
    }
    function deleteBook(){
        const bookId = $("#book-id").val();
        const url = "api/book/"+bookId;
        commonAjax({},url,"DELETE",deleteBookSuccess,deleteBookError);
    }

    function deleteBookSuccess(data)
    {
        $('#delete-modal').modal('hide');
        alert(data.message);
        commonAjax({},fetch_books_url,"GET",bookSuccessListResult,bookErrorListResult);
    }

    function deleteBookError(data)
    {
        alert(data.message);
    }
</script>
@endpush
