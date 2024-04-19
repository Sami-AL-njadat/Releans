<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .button {
            display: inline-block;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 25%;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>


    <div class="container">


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        User List
                        <div>
                            <a class="button" href="{{ route('ss') }}">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>
<script>
    // Fetch user data from API endpoint
    fetch('http://127.0.0.1:8000/api/apiShow')
        .then(response => response.json())
        .then(data => {
            data.user.forEach(user => {
                const userId = user.id; // Get the user ID from the data
                document.getElementById('userTable').innerHTML += `
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>
                        <a href="{{ route('edit.pageOpen', ['id' => '']) }}/${userId}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="deleteUser(${userId})">Delete</button>
                    </td>
                </tr>
            `;
                console.log(`${userId}`);
            });
        })
        .catch(error => console.error('Error fetching user data:', error));

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`http://127.0.0.1:8000/api/delete/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete user');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('User deleted successfully');
                    window.location.href = 'http://127.0.0.1:8000/show';

                })
                .catch(error => {
                    console.error('Error:', error.message);
                });
        }
    }
</script>




</html>
