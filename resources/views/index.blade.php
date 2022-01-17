<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Ajax Crud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .container {
            padding: 2rem 0rem;
        }

        h4 {
            margin: 2rem 0rem 1rem;
        }

        .table-image {

            td,
            th {
                vertical-align: middle;
            }
        }
    </style>
</head>

<body>
    <div class="text-center mt-4">
        <h1>AJAX CRUD</h1>
    </div>
    <div class="container">
        <div class="row">

            <!-- <====================Input Form========================= -->

            <div class="col-4">
                <div class="form-group">
                    <label for="fname">Name</label>
                    <input type="text" class="form-control" id="stdName" placeholder="Enter First Name">
                    <span class="text-danger" id="nameError"></span>
                </div>

                <div class="form-group">
                    <label for="lname">Student ID</label>
                    <input type="text" class="form-control" id="stdId" placeholder="Enter Last Name">
                    <span class="text-danger" id="stdIdError"></span>
                </div>

                <div class="form-group">
                    <label for="text">Phone Number</label>
                    <input type="text" class="form-control" id="stdPhone" placeholder="Enter Contact Number">
                    <span class="text-danger" id="phoneError"></span>
                </div>

                <div class="form-group">
                    <label for="contact">Image</label>
                    <input type="text" class="form-control" id="stdImage" placeholder="Enter Contact Number">
                    <span class="text-danger" id="imageError"></span>
                </div>


                <input type="hidden" id="id">

                <button type="submit" onclick="addData()" class="btn btn-sm bg-primary mr-2 d-inline" id="add">
                    Add
                </button>
                <button type="submit" onclick="updateData()" class="btn btn-sm bg-success mr-2 d-inline" id="update">
                    Update
                </button>
                <span class="text-success" id="inserted_msg"></span>
            </div>

            <!-- <============================ Show Data============================> -->

            <div class="col-8">
                <div class="mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Image</th>
                                <th scope="col" style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        // <======================ajax setup=========================>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        //==========================Read Data=============================

        function readData() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{route('readData')}}",
                success: function(data) {
                    let item = "";
                    $.each(data, function(key, value) {
                        item += "<tr>"
                        item += "<td>" + value.id + "</td>"
                        item += "<td>" + value.name + "</td>"
                        item += "<td>" + value.stdId + "</td>"
                        item += "<td>" + value.phone + "</td>"
                        item += "<td>" + value.image + "</td>"
                        item += "<td>"
                        item += '<button type="button" class="btn btn-sm btn-primary mr-2" onclick="editData((' + value.id + '))">Edit</button>'
                        item += '<button type="button" class="btn btn-sm btn-danger mr-2" onclick="deleteData(' + value.id + ')">Delete</button>'
                        item += "</td>"
                        item += "</tr>"

                    })
                    $('tbody').html(item);
                }

            })
        }
        readData();

        //============================ADD DATA=================================

        function clearData() {
            $('#stdName').val('');
            $('#stdId').val('');
            $('#stdPhone').val('');
            $('#stdImage').val('');
            $("#nameError").text('');
            $("#stdIdError").text('');
            $("#phoneError").text('');
            $("#imageError").text('');
        }

        function addData() {

            let name = $('#stdName').val();
            let stdId = $('#stdId').val();
            let stdPhone = $('#stdPhone').val();
            let stdImage = $('#stdImage').val();

            $.ajax({

                type: "POST",
                dataType: 'json',
                data: {
                    name: name,
                    stdId: stdId,
                    phone: stdPhone,
                    image: stdImage
                },
                url: "{{route('ajax.store')}}",

                success: function(response) {

                    clearData();
                    readData();
                    $("#inserted_msg").text('Data successfully inserted');

                },

                error: function(error) {

                    $("#nameError").text(error.responseJSON.errors.name);
                    $("#stdIdError").text(error.responseJSON.errors.stdId);
                    $("#phoneError").text(error.responseJSON.errors.phone);
                    $("#imageError").text(error.responseJSON.errors.image);
                }

            })

        }

        // =================================EDIT DATA=============================
        function editData(id) {

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "ajax/" + id + "/edit",

                success: function(data) {
                    $('#id').val(data.id);
                    $('#stdName').val(data.name);
                    $('#stdId').val(data.stdId);
                    $('#stdPhone').val(data.phone);
                    $('#stdImage').val(data.image);
                }

            })

        }

        //==================================UPDATE DATA============================
        function updateData() {

            let id = $('#id').val();
            let name = $('#stdName').val();
            let stdId = $('#stdId').val();
            let stdPhone = $('#stdPhone').val();
            let stdImage = $('#stdImage').val();

            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: name,
                    stdId: stdId,
                    phone: stdPhone,
                    image: stdImage
                },
                url: "ajax/" + id,
                success: function(response) {

                    clearData();
                    readData();
                    $("#inserted_msg").text('Data successfully updated');
                },
                error: function(error) {

                    $("#nameError").text(error.responseJSON.errors.name);
                    $("#stdIdError").text(error.responseJSON.errors.stdId);
                    $("#phoneError").text(error.responseJSON.errors.phone);
                    $("#imageError").text(error.responseJSON.errors.image);
                }
            })


        }



        //==============================DELETE DATA================================

        function deleteData(id) {

            $.ajax({
                type: "DELETE",
                dataType: "json",
                url: "ajax/" + id,
                success: function(response) {

                    readData();
                    console.log("successfully deleted");

                }
            })
        }
    </script>
</body>

</html>