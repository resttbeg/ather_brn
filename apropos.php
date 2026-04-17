<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="image.jpg">
<title>À propos - ITR_Brn</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ===== ROOT ===== */

:root{
--main:#1abc9c;
--bg:#f8fafc;
--card:#ffffff;
--text:#111;
--shadow:rgba(0,0,0,0.1);
}

.dark{
--bg:#0f172a;
--card:#1e293b;
--text:#f1f5f9;
--shadow:rgba(0,0,0,0.4);
}

/* ===== GLOBAL ===== */

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{
background:var(--bg);
color:var(--text);
transition:0.4s;
}

/* ===== HEADER ===== */

header{
background:black;
padding:15px 50px;
display:flex;
justify-content:space-between;
align-items:center;
position:sticky;
top:0;
z-index:999;
flex-wrap:wrap;
}

.logo{
display:flex;
align-items:center;
gap:10px;
color:white;
}

.logo img{
width:45px;
border-radius:10px;
}

nav a{
color:white;
text-decoration:none;
margin:0 12px;
font-weight:500;
}

nav a:hover,
nav a.active{
color:var(--main);
}

/* ===== CONTROLS ===== */

.controls{
display:flex;
gap:12px;
align-items:center;
}

.controls select,
.controls button{
padding:7px 14px;
border:none;
border-radius:20px;
cursor:pointer;
font-weight:500;
}

/* ===== HERO ===== */

.hero{
height:60vh;
background:url("images/about-banner.jpg") center/cover no-repeat;
display:flex;
align-items:center;
justify-content:center;
position:relative;
}

.hero::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.6);
}

.hero-content{
position:relative;
color:white;
text-align:center;
z-index:2;
}

.hero-content h2{
font-size:3rem;
}

.hero-content span{
color:var(--main);
}

/* ===== SECTIONS ===== */

.section{
padding:80px 10%;
}

.about-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:40px;
align-items:center;
}

.about-img img{
width:100%;
border-radius:20px;
box-shadow:0 10px 20px var(--shadow);
}

/* ===== VALUES ===== */

.values-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

.value-box{
background:var(--card);
padding:25px;
border-radius:20px;
text-align:center;
box-shadow:0 10px 20px var(--shadow);
transition:0.3s;
}

.value-box:hover{
transform:translateY(-10px);
}

/* ===== TEAM ===== */

.team-grid{
display:flex;
justify-content:center;
gap:30px;
flex-wrap:wrap;
}

.team-card{
background:var(--card);
padding:20px;
width:260px;
border-radius:20px;
box-shadow:0 10px 20px var(--shadow);
text-align:center;
}

.team-card img{
width:100%;
height:250px;
object-fit:cover;
border-radius:15px;
}

/* ===== BACK TOP ===== */

#topBtn{
position:fixed;
bottom:20px;
right:20px;
padding:12px 15px;
border-radius:50%;
border:none;
background:var(--main);
color:white;
font-size:18px;
cursor:pointer;
display:none;
}

/* ===== FOOTER ===== */

footer{
background:black;
color:white;
text-align:center;
padding:20px;
}

/* ===== RESPONSIVE ===== */

@media(max-width:768px){

header{
flex-direction:column;
gap:10px;
}

.hero-content h2{
font-size:2rem;
}

}

</style>
</head>

<body>

<!-- ===== HEADER ===== -->

<header>

<div class="logo">
<img src="image.jpg">
<h2>Athar_brn</h2>
</div>

<nav>
 <a href="index.php">Accueil</a>
<a href="#" class="active">À propos</a>
<a href="produits.php">Produits</a>
<a href="contact.php">Contact</a>
</nav>

<div class="controls">

<select id="lang">
<option value="fr">🇫🇷 FR</option>
<option value="es">🇪🇸 ES</option>
<option value="ar">🇸🇦 AR</option>
<option value="de">🇩🇪 DE</option>
<option value="en">🇬🇧 EN</option>
</select>

<button onclick="toggleDark()">🌙</button>

</div>

</header>

<!-- ===== HERO ===== -->

<section class="hero">
<div class="hero-content">
<h2 id="title">À propos de <span>ITR_Brn</span></h2>
<p id="subtitle">Marque marocaine moderne</p>
</div>
</section>

<!-- ===== ABOUT ===== -->

<section class="section">

<div class="about-grid">

<div>
<h2 id="aboutTitle">Notre Histoire</h2>
<p id="aboutText">
ITR_Brn est née au Maroc pour représenter la jeunesse moderne,
le style urbain et l'authenticité.
</p>
</div>

<div class="about-img">
<img src="image.jpg">
</div>

</div>

</section>

<!-- ===== VALUES ===== -->

<section class="section">

<h2 id="valuesTitle" style="text-align:center">Nos Valeurs</h2><br>

<div class="values-grid">

<div class="value-box" id="v1">Qualité</div>
<div class="value-box" id="v2">Style</div>
<div class="value-box" id="v3">Innovation</div>
<div class="value-box" id="v4">Authenticité</div>

</div>

</section>

<!-- ===== TEAM ===== -->

<section class="section">

<h2 id="teamTitle" style="text-align:center">Notre Équipe</h2><br>

<div class="team-grid">

<div class="team-card">
<img src="image-fondatur.jpeg">
<h3>Abdo Alouani</h3>
<p id="role1">Fondateur</p>
</div>

<div class="team-card">
<img src="image-manger.jpeg">
<h3>Alaa Alouani</h3>
<p id="role2">Marketing</p>
</div>

</div>

</section>

<!-- ===== FOOTER ===== -->

<footer>
<p>© 2026 ITR_Brn — Tous droits réservés</p>
</footer>

<button id="topBtn" onclick="scrollTopBtn()">↑</button>

<!-- ===== SCRIPT ===== -->

<script>

// ===== LOAD SETTINGS =====

if(localStorage.getItem("dark")=="on"){
document.body.classList.add("dark");
}

if(localStorage.getItem("lang")){
lang.value = localStorage.getItem("lang");
changeLang();
}

// ===== DARK MODE =====

function toggleDark(){
document.body.classList.toggle("dark");
localStorage.setItem("dark",
document.body.classList.contains("dark") ? "on":"off");
}

// ===== BACK TOP =====

window.onscroll = () =>{
topBtn.style.display = window.scrollY > 300 ? "block":"none";
}

function scrollTopBtn(){
window.scrollTo({top:0,behavior:"smooth"});
}

// ===== LANG SYSTEM =====

lang.addEventListener("change",changeLang);

function changeLang(){

let l = lang.value;
localStorage.setItem("lang",l);

document.documentElement.dir = (l=="ar") ? "rtl":"ltr";

const data = {

fr:{
title:"À propos de <span>ITR_Brn</span>",
sub:"Marque marocaine moderne",
aboutT:"Notre Histoire",
about:"ITR_Brn est née au Maroc pour représenter la jeunesse moderne, le style urbain et l'authenticité.",
values:"Nos Valeurs",
team:"Notre Équipe",
r1:"Fondateur",
r2:"Marketing"
},

en:{
title:"About <span>ITR_Brn</span>",
sub:"Modern Moroccan Brand",
aboutT:"Our Story",
about:"ITR_Brn was founded in Morocco to represent youth, freedom and modern streetwear.",
values:"Our Values",
team:"Our Team",
r1:"Founder",
r2:"Marketing"
},

es:{
title:"Sobre <span>ITR_Brn</span>",
sub:"Marca marroquí moderna",
aboutT:"Nuestra Historia",
about:"ITR_Brn nació en Marruecos para representar juventud y estilo urbano.",
values:"Nuestros Valores",
team:"Nuestro Equipo",
r1:"Fundador",
r2:"Marketing"
},

de:{
title:"Über <span>ITR_Brn</span>",
sub:"Moderne marokkanische Marke",
aboutT:"Unsere Geschichte",
about:"ITR_Brn wurde in Marokko gegründet, um Jugend und Streetwear zu repräsentieren.",
values:"Unsere Werte",
team:"Unser Team",
r1:"Gründer",
r2:"Marketing"
},

ar:{
title:"حول <span>ITR_Brn</span>",
sub:"علامة مغربية عصرية تجمع بين الأناقة والتميز",
aboutT:"قصتنا",
about:"ITR_Brn هي علامة أزياء مغربية حديثة تأسست بهدف تمثيل روح الشباب، الحرية، والستايل العصري. نحن نصمم منتجات تجمع بين الجودة العالية والتصميم الجذاب لتقديم تجربة فريدة لعملائنا.",
values:"قيمنا",
team:"فريقنا",
r1:"المؤسس والمدير الإبداعي",
r2:"مسؤول التسويق والعلامة التجارية"
}

}

title.innerHTML = data[l].title;
subtitle.innerText = data[l].sub;
aboutTitle.innerText = data[l].aboutT;
aboutText.innerText = data[l].about;
valuesTitle.innerText = data[l].values;
teamTitle.innerText = data[l].team;
role1.innerText = data[l].r1;
role2.innerText = data[l].r2;

}

</script>

</body>
</html>
