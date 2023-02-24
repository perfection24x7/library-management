@extends('layouts.app')

@section('content')
    <form autocomplete="false" id="book-form">
        <fieldset>
            <legend>Author Information:</legend>
            <div class="form-group">
                <label for="booknameInput">Choose Author</label>
                <div class="form-check">
                    <input class="form-check-input author_type" type="radio" name="author_type" id="author_type_one"
                        value="existing_author" checked>
                    <label class="form-check-label">
                        Existing Author
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input author_type" type="radio" name="author_type" id="author_type_2" value="new_author">
                    <label class="form-check-label">
                        New Author
                    </label>
                </div>
            </div>
            <div id="exist-author-section">
                <div class="form-group">
                    <label for="booknameInput">Author *</label>
                    <select name="author_id" class="form-control" id="author-id" required>
                        <option value="">Select Author</option>
                    </select>
                </div>
            </div>
            <div id="new-author-section" style="display:none">
                <div class="form-group">
                    <label for="booknameInput">Author Name *</label>
                    <input type="text" name="name" class="form-control" id="author-name">
                </div>
                <div class="form-group">
                    <label for="booknameInput">Author Birth Date *</label>
                    <input type="date" name="birth_date" class="form-control" id="author-date">
                </div>
                <div class="form-group">
                    <label for="booknameInput">Genre *</label>
                    <input type="text" name="genre" class="form-control" id="author-genre">
                </div>
            </div>
        </fieldset>
        <br>
        <fieldset>
            <legend>Book Information:</legend>
            <div class="form-group">
                <label for="booknameInput">Book Name *</label>
                <input type="text" name="book_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="booknameInput">Book Year *</label>
                <input type="number" name="book_year" class="form-control" required>
            </div>
        </fieldset>
        <br>
        <fieldset>
            <legend>Library Information:</legend>
            <div class="form-group">
                <label for="booknameInput">Choose Library</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="library_type" id="library_type_one"
                        value="existing_library" checked>
                    <label class="form-check-label">
                        Existing Library
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="library_type" id="library_type_2"
                        value="new_library">
                    <label class="form-check-label">
                        New Library
                    </label>
                </div>
            </div>
            <div id="exist-library-section">
                <div class="form-group">
                    <label for="booknameInput">Library</label>
                    <select name="library_id[]" id="library-id" class="form-control select2" multiple>
                        <option value="">Select Library</option>
                    </select>
                </div>
            </div>
            <div id="new-library-section" style="display:none">
                <div class="multi-rows">
                <div class="row multirows" id="row-1">
                    <div class="form-group col-md-5">
                        <label for="booknameInput">Library Name</label>
                        <input type="text" name="library_name[]" id="libraryname-1" class="form-control name">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="booknameInput">Library Address</label>
                        <input type="text" name="library_address[]" id="libraryaddress-1" class="form-control address">
                    </div>
                    <div class="form-group col-md-2">
                        <label></label>
                        <button type="button" class="btn btn-danger deletebtn" id="delete-1" onclick="removeRow(this)"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                </div>
                <br>
                <button type="button" onclick="addRow()" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add Library</button>
            </div>
        </fieldset>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('scripts')
    <script>
        const save_books_url = '{!! route('book.store') !!}';
        const fetch_author_libraries_url = '{!! route('book.fetch-authors-libraries') !!}';
        $(document).ready(function() {
            $('.select2').select2();
            commonAjax({}, fetch_author_libraries_url, "GET", initialDataSuccess, initialDataError);

            $('input[type=radio][name=author_type]').change(function() {
                if (this.value == 'existing_author') {
                    $("#exist-author-section").show();
                    $("#new-author-section").hide();
                    setRequired('author-id');
                    removeRequired('author-name');
                    removeRequired('author-date');
                    removeRequired('author-genre');
                    $("#author-name").val();
                    $("#author-date").val();
                    $("#author-genre").val();
                } else if (this.value == 'new_author') {
                    $("#exist-author-section").hide();
                    $("#new-author-section").show();
                    setRequired('author-name');
                    setRequired('author-date');
                    setRequired('author-genre');
                    removeRequired('author-id');
                    $('#author-id').val();
                }
            });

            $('input[type=radio][name=library_type]').change(function() {
                if (this.value == 'existing_library') {
                    $("#exist-library-section").show();
                    $("#new-library-section").hide();
                } else if (this.value == 'new_library') {
                    $("#exist-library-section").hide();
                    $("#new-library-section").show();
                }
            });
        });

        $('#book-form').submit(function(e) {
            e.preventDefault();
            var formData = $("#book-form").serialize();
            commonAjax(formData, save_books_url, "POST", saveBookSuccess, saveBookError)
        });

        function initialDataSuccess(data) {
            if (data.status) {
                const authors = data.data.authors;
                const libraries = data.data.libraries;

                $.each(authors, function(key, value) {
                    $('#author-id').append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });

                $.each(libraries, function(key, value) {
                    $('#library-id').append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.library_name));
                });
            }
        }

        function initialDataError(data) {

        }

        function saveBookSuccess(data) {
            alert(data.message);
            window.location.href = window.location.origin;
        }

        function saveBookError(data) {

        }

        function setRequired(id) {
            $("#" + id).prop('required', true);
        }

        function removeRequired(id) {
            $('#' + id).removeAttr('required');
        }

        function addRow()
        {
            var total_rows = $('.multirows').length;
            if($("#libraryname-"+total_rows).val() != "" && $("#libraryaddress-"+total_rows).val() != ""){
                var $ed = $('#row-1').clone();
                var ind = $('.multirows').length + 1;
                $ed.prop("id","row-"+ind);
                $ed.find('input,button').each(function (key, value) {
                    var id = this.id.split("-");
                    this.id = id[0] + '-' + ind;
                    this.value = "";
                });

                $('.multi-rows').append($ed);

            } else {
                alert("please fillup previous fields first!");
            }
        }

        function removeRow(obj)
        {
            var id = obj.id.split("-");
            id = id[1];
            var total_rows = $('.multirows').length;
            if(total_rows > 1){
                $("#row-"+id).remove();
                var ind = 1;
                $('.multirows').each(function (key, value) {

                    var id = this.id.split("-");
                    this.id = id[0] + '-' + ind;

                    $("#row-"+ind+" .name").prop("id","libraryname-"+ind);
                    $("#row-"+ind+" .address").prop("id","libraryaddress-"+ind);
                    $("#row-"+ind+" .deletebtn").prop("id","delete-"+ind);
                    ind = ind + 1;
                });
            } else {
                alert('You cannot remove first row!');
            }
        }
    </script>
@endpush
