
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 9 CRUD Tutorial Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <center>
                <div>
                    <h2>Laravel 9 Ajax CRUD </h2>
                </div>
            </center>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container-fluid" style="border:1px solid #cecece;">
        <form id="form">
            <div class="form-group">
                {{--                <input type="hidden" id="id" />--}}
                <label>Name</label>
                <input type="text" name="name" id="name" placeholder="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Dob</label>
                <input type="date" name="dob" id="dob" placeholder="dob" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Des</label>
                <input type="text" name="des" id="des" placeholder="des" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Qua</label>
                <input type="text" name="qua" id="qua" placeholder="Qua" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input type="text" name="mo" id="mo" placeholder="Mobile" class="form-control" maxlength="10" required>
            </div>
            <div class="form-group">
                <label>Gender&emsp;&emsp;&emsp;</label>
                <input type="radio" name="gender" id="gender" value="male" class="form-check-input">Male&emsp;&emsp;&emsp;
                <input type="radio" name="gender" id="gender" value="female" class="form-check-input">Female&emsp;&emsp;&emsp;
            </div>
            <div class="form-group">
                <label>Is Relocate&emsp;&emsp;&emsp;</label>
                <input type="hidden" name="loc" id="loc" value="no" class="form-check-input">
                <input type="checkbox" name="loc" id="loc" value="yes" class="form-check-input">
            </div>
            <div class="form-group mb-3">
                <label>Country</label>
                <select id="country" name="country" class="form-control country">
                    <option selected disabled>Select Country</option>
                    @foreach($countries as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label>State</label>
                <select id="state" name="state" class="form-control state"></select>
            </div>
            <div class="form-group mb-3">
                <label>City</label>
                <select id="city" name="city" class="form-control city"></select>
            </div>
                <div>
                    <input type="hidden" name="id" id="id" value="0">
                    <button type="button" name="save" id="btnSave" class="btn btn-success btn-sm">Save</button>
                    <button type="button" name="clear" id="clear" class="btn btn-warning btn-sm">Clear</button>
                </div>
        </form>
    </div>
    <br>
    <table id="tab" class="table table-striped" style="width: 100%; border-collapse: collapse;" border='1'>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>

        $(function () {
            let dt = $("#tab").DataTable({
                ajax: {
                    url: "get_data"
                    , dataSrc: ""
                }
                , columns: [
                    {data: "name", title: "Name"}
                    , {data: "dob", title: "Dob"}
                    , {data: "des", title: "Description"}
                    , {data: "qua", title: "Qualification"}
                    , {data: "email", title: "Email"}
                    , {data: "gender", title: "Gender"}
                    , {data: "mo", title: "Mobile"}
                    , {data: "loc", title: "Relocate"}
                    , {data: "country", title: "Country"}
                    , {data: "state", title: "State"}
                    , {data: "city", title: "City"}
                    , {
                        data: "id", title: "Action", render: (d) => `
						<a href='javascript:;' class='lnk-edit' data-id='${d}'><button class="btn btn-info btn-sm">Edit</button></a>
						<a href='javascript:;' class='lnk-del' data-id='${d}'><button class="btn btn-danger btn-sm">Delete</button></a>
					`
                    }
                ]
            });

            $("#tab").on("click", ".lnk-del", function (e) {
                let id = e.currentTarget.dataset.id;
                $.post({
                    url: "del_data"
                    , data: {id: id, "_token": "{{ csrf_token() }}"}
                }).then(function (res) {
                    if (res === true) {
                        alert("Deleted");
                        dt.ajax.reload();
                    } else {
                        alert(res);
                    }
                })
            })

            $("#tab").on("click", ".lnk-edit", function (e) {
                let id = e.currentTarget.dataset.id;
                $.post({
                    url: "edit_data"
                    , data: {id: id, "_token": "{{ csrf_token() }}"}
                }).then(function (res) {
                    if (res && res.name != undefined) {
                        $("#name").val(res.name);
                        $("#dob").val(res.dob);
                        $("#des").val(res.des);
                        $("#qua").val(res.qua);
                        $("input[name=gender][value='" + res.gender + "']").prop("checked", true);
                        $("#email").val(res.email);
                        $("input[name=loc][value='" + res.loc + "']").prop("checked", true);
                        // $("input[name=loc]").prop('checked', false);
                        $("#mo").val(res.mo);
                        $("#id").val(res.id);
                        $("#country").val(res.country).trigger("change");
                        setTimeout(function () {
                            $("#state").val(res.state).trigger("change");
                        }, 1000);
                        setTimeout(function () {
                        $("#city").val(res.city).trigger("change");
                        },2000);
                    } else {
                        alert(res);
                    }
                });
            });

            $("#btnSave").on("click", function (e) {

                $.post({
                    url: "save_data"
                    , data: {
                        "_token": "{{ csrf_token() }}"
                        , name: $("#name").val()
                        , dob: $("#dob").val()
                        , des: $("#des").val()
                        , qua: $("#qua").val()
                        , gender: $("input[name=gender]:checked").val()
                        , email: $("#email").val()
                        , loc: $("#loc").prop("checked") ? "yes" : "no"
                        , mo: $("#mo").val()
                        , country: $(".country").val()
                        , state: $(".state").val()
                        , city: $(".city").val()
                        , id: $("#id").val()
                    }
                }).then(function (res) {
                    if (res === true) {
                        alert("Saved");
                        dt.ajax.reload();
                    } else {
                        alert(res);
                    }
                });
            });

            $("#clear").click(function () {
                $("#name").val("");
                $("#dob").val("");
                $("#des").val("");
                $("#qua").val("");
                $("input[name=gender]").prop('checked', false);
                $("#email").val("");
                $("input[name=loc]").prop('checked', false);
                $("#mo").val("");
                $(".country").val("");
                $(".state").val("");
                $(".city").val("");
            });

            $('#country').change(function(event) {
                var idCountry = this.value;
                $('#state').html('');

                $.ajax({

                    url: "api/fetch-state",
                    type: 'POST',
                    dataType: 'json',
                    data: {country_id: idCountry,_token:"{{ csrf_token() }}"},
                    success:function(response){
                        $('#state').html('<option selected disabled>Select State</option>');
                        $.each(response.states,function(index, val){
                            $('#state').append('<option value="'+val.id+'"> '+val.name+' </option>')
                        });
                        $('#city').html('<option selected disabled>Select City</option>');
                    }
                })
            });
            $('#state').change(function(event) {
                var idState = this.value;
                $('#city').html('');
                $.ajax({
                    url: "api/fetch-cities",
                    type: 'POST',
                    dataType: 'json',
                    data: {state_id: idState,_token:"{{ csrf_token() }}"},
                    success:function(response){
                        $('#city').html('<option selected disabled>Select State</option>');
                        $.each(response.cities,function(index, val){
                            $('#city').append('<option value="'+val.id+'"> '+val.name+' </option>')
                        });
                    }
                })
            });
        });

</script>

</body>
</html>
