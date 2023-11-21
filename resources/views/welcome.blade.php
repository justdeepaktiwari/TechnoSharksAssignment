<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body class="bg-light">
    <div class="container">
        <div style="height: 50px;"></div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                   <thead>
                    <tr>
                        <td>S.No.</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Address</td>
                        <td>Action</td>
                    </tr>
                   </thead>
                   <tbody id="userDataBody">
                    @forelse ($user as $sno =>  $item)
                        <tr>
                           <td>{{($sno+1)}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->address}}</td>
                            <td>
                                <span onclick="editUser(this)" class="text-warning" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </span>
                                <span onclick="deleteUser('{{$item->email}}')" class="text-danger" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                    </svg>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                   </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <form id="userInfoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputAdress" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="exampleInputAdress" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $("#userInfoForm").on("submit", function (event) {
                event.preventDefault();
                let form = $(this);
                let submitBtn = form.find('[type="submit"]');

                form = form[0];
                let formData = new FormData(form);

                submitBtn.text("Processing").attr("disabled","disabled");
                $.ajax({
                    type: "POST",
                    url: "{{ route('save.user') }}",
                    data: formData,
                    dataType: "HTML",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        submitBtn.text("Submit").removeAttr("disabled");
                        $("#userDataBody").html(response);
                        $("#userInfoForm").find('input[type="text"], input[type="email"]').val('').removeAttr("readonly");
                    }
                });
            });
        });

        function deleteUser(email){
            console.log(deleteUser);
            $.ajax({
                type: "GET",
                url: "/user-delete/"+email,
                dataType: "HTML",
                success: function (response) {
                    $("#userDataBody").html(response);
                }
            });
        }

        function editUser(param){
            let tr = $(param).parent().parent();
            console.log(tr);
            let user = {
                "name": tr.find("td:nth-child(2)").text(),
                "email": tr.find("td:nth-child(3)").text(),
                "address": tr.find("td:nth-child(4)").text()
            };

            $.each($("#userInfoForm").find('input[type="text"], input[type="email"]'), function (indexInArray, valueOfElement) {
                valueOfElement.value = user[valueOfElement.getAttribute("name")];
                if(valueOfElement.getAttribute("name") == "email"){
                    valueOfElement.readOnly = true;
                }
            });
        }
    </script>
  </body>
</html>