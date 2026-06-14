<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card">

<div class="card-header">

<h3>Login</h3>

</div>

<div class="card-body">

<form method="POST" action="/login">

@csrf

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email">

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password">

<button class="btn btn-primary">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>