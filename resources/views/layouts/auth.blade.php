<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title','Auth')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

<style>

:root{
--primary:#3f50f6;
--gray:#434a54;
--light:#e8eff4;
--cyan:#57c7d4;
}

/* BACKGROUND */

body{
min-height:100vh;
background:linear-gradient(135deg,#f5f7fb,#e8eff4);
display:flex;
align-items:center;
justify-content:center;
font-family:var(--font-family-sans-serif);
}

/* CONTAINER */

.auth-container{
width:1100px;
min-height:520px;
background:white;
border-radius:20px;
padding:60px;
display:flex;
align-items:center;
justify-content:space-between;
box-shadow:0 15px 40px rgba(0,0,0,.08);
}

/* LEFT */

.auth-left{
width:42%;
display:flex;
flex-direction:column;
justify-content:center;
}

.logo{
font-size:20px;
font-weight:600;
color:var(--primary);
margin-bottom:35px;
}

.auth-title{
font-size:34px;
font-weight:600;
color:var(--gray);
margin-bottom:8px;
}

.auth-sub{
color:#7a7a7a;
margin-bottom:35px;
}

.form-group{
margin-bottom:18px;
}

.form-control{
border-radius:6px;
padding:10px 12px;
}

/* BUTTON */

.btn-login{
background:var(--primary);
color:white;
border:none;
padding:12px;
border-radius:6px;
margin-top:10px;
width:100%;
font-weight:500;
transition:.2s;
}

.btn-login:hover{
opacity:.9;
}

/* CTA REGISTER */

.auth-register{
margin-top:18px;
font-size:14px;
color:#6c757d;
}

.auth-register a{
color:var(--primary);
font-weight:600;
margin-left:4px;
text-decoration:none;
}

.auth-register a:hover{
text-decoration:underline;
}

/* RIGHT */

.auth-right{
width:50%;
display:flex;
justify-content:center;
align-items:center;
}

/* WASHING MACHINE */

.machine{
width:280px;
height:340px;
background:#f3f6fb;
border-radius:15px;
border:5px solid #dfe6ef;
position:relative;
box-shadow:0 10px 20px rgba(0,0,0,.05);
}

.machine-panel{
height:60px;
background:#e8eff4;
border-bottom:3px solid #d8e0ea;
border-radius:10px 10px 0 0;
}

/* DRUM */

.drum{
width:170px;
height:170px;
border-radius:50%;
background:#cfe5ff;
border:8px solid #5e7df7;
position:absolute;
top:110px;
left:50%;
transform:translateX(-50%);
display:flex;
align-items:center;
justify-content:center;
overflow:hidden;

animation:spin 6s linear infinite;
}

/* WATER */

.water{
width:100%;
height:60%;
background:linear-gradient(#57c7d4,#3f50f6);
position:absolute;
bottom:0;
border-radius:50%;
}

/* BUBBLES */

.bubble{
position:absolute;
background:white;
border-radius:50%;
opacity:.7;
animation:float 4s infinite;
}

.b1{width:15px;height:15px;top:80px;right:20px;}
.b2{width:10px;height:10px;top:120px;left:20px;}
.b3{width:12px;height:12px;top:150px;right:40px;}
.b4{width:8px;height:8px;top:200px;left:50px;}

/* ANIMATION */

@keyframes spin{
0%{transform:translateX(-50%) rotate(0deg);}
100%{transform:translateX(-50%) rotate(360deg);}
}

@keyframes float{
0%{transform:translateY(0);}
50%{transform:translateY(-10px);}
100%{transform:translateY(0);}
}

/* GRID FORM (UNTUK REGISTER) */

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:14px;
}

.form-group-full{
grid-column:1 / -1;
}

/* RESPONSIVE */

@media (max-width:900px){

.auth-container{
flex-direction:column;
padding:40px;
}

.auth-left{
width:100%;
margin-bottom:40px;
}

.auth-right{
width:100%;
}

}

</style>
</head>

<body>

<div class="auth-container">

@yield('content')

</div>

</body>
</html>