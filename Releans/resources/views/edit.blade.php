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
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit User</div>
                    <div class="card-body">

                        <form id="editForm">
                            <input type="hidden" id="userId" name="id" value="">
                            <div class="form-group">
                                <label for="editName">Name</label>
                                <input id="editName" type="text" class="form-control" name="name" required>
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input id="editEmail" type="email" class="form-control" name="email" required>
                                <span></span>

                            </div>
                            <div class="form-group">
                                <label for="editPhone">Phone</label>
                                <input id="editPhone" type="text" class="form-control" name="phone" required>
                                <span></span>

                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

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





    <script>
        var currentURL = window.location.href;
        var idUSer = currentURL.substr(currentURL.lastIndexOf('/') + 1);

        const url = `http://127.0.0.1:8000/api/editpage/${idUSer}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const user = data.user;
                console.log(data.user, 'sssssssssss');
                document.getElementById('userId').value = user.id;
                document.getElementById('editName').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editPhone').value = user.phone;
            })
            .catch(error => console.error('Error fetching user data:', error));
    </script>




















    <script>
        const editForm = document.getElementById('editForm');
        const spanContainer = document.querySelectorAll('.form-group span');

        editForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const userId = document.getElementById('userId').value;
            const name = document.getElementById('editName').value;
            const email = document.getElementById('editEmail').value;
            const phone = document.getElementById('editPhone').value;

            // Validation for name
            // Validation for name
            if (name.length > 25) {
                spanContainer[0].innerHTML = "Name must be 25 characters or less";
                spanContainer[0].style.color = "red";
                spanContainer[0].style.display = "block"; // Show the error message
                return; // Stop form submission
            } else {
                spanContainer[0].innerHTML = ""; // Clear error message
                spanContainer[0].style.display = "none"; // Hide the error message
            }


            // Validation for email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                spanContainer[1].innerHTML = "Invalid email format";
                spanContainer[1].style.color = "red";
                return; // Stop form submission
            } else {
                spanContainer[1].innerHTML = ""; // Clear error message
            }

            const phoneRegex = /^(00|\+)?\d{9,10}$/;
            if (!phoneRegex.test(phone)) {
                spanContainer[2].innerHTML =
                    "Invalid phone number format must be 10 Number or can use country key 00962 or +962";
                spanContainer[2].style.color = "red";
                return;
            } else {
                spanContainer[2].innerHTML = "";
            }

            const userData = {
                id: userId,
                name: name,
                email: email,
                phone: phone
            };

            fetch(`http://127.0.0.1:8000/api/edit/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    window.location.href = 'http://127.0.0.1:8000/show';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>




</body>

</html>
