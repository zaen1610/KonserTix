<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{

height:100vh;

display:flex;
justify-content:center;
align-items:center;

background:
linear-gradient(
135deg,
#07070a,
#3f0071,
#0066ff
);

overflow:hidden;

}

body::before{

content:"";

position:absolute;

width:400px;
height:400px;

background:#7b2cff;

border-radius:50%;

filter:blur(180px);

top:-100px;
left:-100px;

opacity:.5;

}

body::after{

content:"";

position:absolute;

width:400px;
height:400px;

background:#00aaff;

border-radius:50%;

filter:blur(180px);

bottom:-100px;
right:-100px;

opacity:.5;

}

.login-box{

width:450px;

padding:40px;

background:
rgba(255,255,255,.05);

backdrop-filter:
blur(20px);

border-radius:35px;

border:1px solid
rgba(255,255,255,.1);

box-shadow:
0 0 40px
rgba(123,44,255,.8);

color:white;

z-index:999;

animation:masuk 1s;

}

@keyframes masuk{

from{

transform:
translateY(50px);

opacity:0;

}

to{

transform:
translateY(0);

opacity:1;

}

}

.logo{

font-size:70px;

text-align:center;

margin-bottom:10px;

}

.judul{

font-size:35px;

font-weight:bold;

text-align:center;

margin-bottom:10px;

}

.sub{

text-align:center;

color:#bbb;

margin-bottom:30px;

}

.input-group{

margin-bottom:20px;

background:#1c1c1c;

padding:10px;

border-radius:20px;

}

.input-group-text{

background:none;
border:none;
color:#00aaff;

}

.form-control{

background:none;

border:none;

color:white;

}

.form-control:focus{

background:none;

box-shadow:none;

color:white;

}

.btn-login{

width:100%;

padding:15px;

border:none;

border-radius:30px;

font-size:18px;

font-weight:bold;

background:
linear-gradient(
90deg,
#7b2cff,
#0066ff
);

color:white;

transition:.5s;

}

.btn-login:hover{

transform:scale(1.05);

box-shadow:
0 0 30px
#7b2cff;

}

.link{

text-align:center;

margin-top:20px;

}

.link a{

text-decoration:none;

color:#00aaff;

}

</style>

</head>

<body>

<div class="login-box">

<div class="logo">

🎵

</div>

<div class="judul">

KONSER LOGIN

</div>

<div class="sub">

Masuk ke sistem tiket konser

</div>

@if(session('error'))

<div class="alert alert-danger">

{{session('error')}}

</div>

@endif

<form
action="{{url('/login')}}"
method="POST">

@csrf

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-envelope"></i>

</span>

<input
type="email"
name="email"
class="form-control"
placeholder="Email">

</div>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-lock"></i>

</span>

<input
type="password"
name="password"
class="form-control"
placeholder="Password">

</div>

<button
class="btn-login">

LOGIN

</button>

</form>

<div class="link">

Belum punya akun?

<a href="/register">

Register

</a>

</div>

</div>

</body>
</html>