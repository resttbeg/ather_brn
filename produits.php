<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="image.jpg" type="image/png">
<title>Produits - Athar_brn</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

:root {
  --bg:#f8fafc;
  --text:#222;
  --header-footer:#fff;
  --primary:#1abc9c;
  --secondary:#16a085;
  --card-bg:#fff;
  --shadow:rgba(0,0,0,0.1);
}

body.dark {
  --bg:#0d0d0d;
  --text:#f2f2f2;
  --header-footer:#111;
  --card-bg:#1a1a1a;
  --shadow:rgba(255,255,255,0.08);
}

body{margin:0;font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);transition:all 0.4s ease;}

header{background:var(--header-footer);color:var(--text);display:flex;justify-content:space-between;align-items:center;padding:15px 40px;flex-wrap:wrap;position:sticky;top:0;z-index:999;box-shadow:0 3px 10px var(--shadow);}
.logo{display:flex;align-items:center;gap:10px;cursor:pointer;}
.logo img{width:50px;border-radius:8px;transition:transform 0.3s;}
.logo:hover img{transform:scale(1.1);}
nav a{color:var(--text);margin:0 15px;text-decoration:none;font-weight:500;position:relative;}
nav a::after{content:'';display:block;height:2px;background:var(--primary);width:0;transition:0.3s;position:absolute;bottom:-5px;left:0;}
nav a:hover::after, nav a.active::after{width:100%;}
nav a:hover, nav a.active{color:var(--primary);}
.controls{display:flex;align-items:center;gap:10px;}
select,button{border:none;border-radius:25px;padding:8px 15px;font-weight:500;cursor:pointer;transition:all 0.3s ease;}
select{background:var(--header-footer);color:var(--text);box-shadow:0 2px 6px var(--shadow);}
#dark-toggle{background:var(--primary);color:#fff;box-shadow:0 3px 8px var(--shadow);}
#dark-toggle:hover{background:var(--secondary);transform:rotate(10deg) scale(1.1);}

.collection{padding:70px 20px;text-align:center;}
.collection h2{font-size:2.2em;margin-bottom:40px;animation:fadeUp 1s ease forwards;opacity:0;}
.grid{display:flex;flex-wrap:wrap;justify-content:center;gap:30px;}
.card{background:var(--card-bg);border-radius:15px;width:260px;padding:15px;box-shadow:0 5px 15px var(--shadow);transition:all 0.3s;cursor:pointer;transform:translateY(20px);opacity:0;animation:fadeUp 0.5s ease forwards;}
.card:hover{transform:translateY(-8px) scale(1.05);box-shadow:0 10px 25px var(--shadow);}
.card img{width:100%;height:220px;object-fit:cover;border-radius:12px;transition:transform 0.5s;}
.card:hover img{transform:scale(1.1);}
.card p{margin-top:12px;font-weight:500;font-size:1em;}
.card .price{margin-top:5px;font-weight:600;color:var(--primary);font-size:1em;}

footer{background:var(--header-footer);color:var(--text);text-align:center;padding:12px 20px;font-size:0.85em;margin-top:40px;border-top-left-radius:15px;border-top-right-radius:15px;box-shadow:0 -2px 8px var(--shadow);}

@keyframes fadeUp{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:translateY(0);}}


@media(max-width:768px){header{flex-direction:column;padding:20px;}nav{margin-top:10px;}.grid{flex-direction:column;align-items:center;}.card{width:90%;}}
@media(max-width:480px){.collection h2{font-size:1.5em;}}
</style>
</head>
<body>

<header>
<div class="logo"><img src="image.jpg" alt="Athar_brn Logo"><h1>Athar_brn</h1></div>
<div class="controls">
<select id="lang">
<option value="fr">🇫🇷 FR</option>
<option value="es">🇪🇸 ES</option>
<option value="ar">🇸🇦 AR</option>
<option value="de">🇩🇪 DE</option>
<option value="en">🇬🇧 EN</option>
</select>
<select id="currency">
<option value="MAD">MAD 🇲🇦</option>
<option value="EUR">EUR 🇪🇺</option>
<option value="USD">USD 💵</option>
</select>
<button id="dark-toggle">🌙</button>
</div>
<nav>
<a href="index.php" id="nav-home">Accueil</a>
<a href="#" class="active" id="nav-products">Produits</a>
<a href="apropos.php" id="nav-about">À propos</a>
<a href="contact.php" id="nav-contact">Contact</a>
<a href="panier.php" id="nav-panier">Panier</a>
</nav>
</header>

<section class="collection fade-in">
<h2 id="collection-title">Nos dernières créations</h2>
<div class="grid">
<div class="card">
<img src="sweatshirt.jpg" alt="T-shirt ITR">
<p id="item1">S-weatshirt</p>
<p class="price" data-mad="250">Prix : <span class="price-value">250 MAD</span></p>
</div>
<div class="card">
<img src="hoodie.jpg" alt="Hoodie ITR">
<p id="item2">Hoodie</p>
<p class="price" data-mad="350">Prix : <span class="price-value">350 MAD</span></p>
</div>
</div>
</section>

<footer>
<p>&copy; <span id="year"></span> Athar_brn — <span id="footer-text">Tous droits réservés</span></p>
</footer>

<script>
document.getElementById("year").textContent=new Date().getFullYear();

// Dark mode
const toggle=document.getElementById('dark-toggle');
toggle.addEventListener('click',()=>{
  document.body.classList.toggle('dark');
  toggle.textContent=document.body.classList.contains('dark')?'☀️':'🌙';
  localStorage.setItem("theme",document.body.classList.contains('dark')?"dark":"light");
});
if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark");toggle.textContent='☀️';}

// Multilingual
const texts={
fr:{nav_home:"Accueil",nav_products:"Produits",nav_about:"À propos",nav_contact:"Contact",collection_title:"Nos dernières créations",item1:"T-shirt ITR Classic",item2:"Hoodie Urban",footer:"Tous droits réservés"},
es:{nav_home:"Inicio",nav_products:"Productos",nav_about:"Sobre nosotros",nav_contact:"Contacto",collection_title:"Nuestras últimas creaciones",item1:"Camiseta ITR Classic",item2:"Sudadera Urban",footer:"Todos los derechos reservados"},
ar:{nav_home:"الرئيسية",nav_products:"المنتجات",nav_about:"حولنا",nav_contact:"اتصل بنا",collection_title:"أحدث تصاميمنا",item1:"تيشيرت ITR كلاسيكي",item2:"هودي أوربان",footer:"جميع الحقوق محفوظة"},
de:{nav_home:"Startseite",nav_products:"Produkte",nav_about:"Über uns",nav_contact:"Kontakt",collection_title:"Unsere neuesten Kreationen",item1:"ITR Classic T-Shirt",item2:"Urban Hoodie",footer:"Alle Rechte vorbehalten"},
en:{nav_home:"Home",nav_products:"Products",nav_about:"About",nav_contact:"Contact",collection_title:"Our latest creations",item1:"ITR Classic T-shirt",item2:"Urban Hoodie",footer:"All rights reserved"}
};

function updateLanguage(lang){
  const t=texts[lang];
  document.getElementById("nav-home").textContent=t.nav_home;
  document.getElementById("nav-products").textContent=t.nav_products;
  document.getElementById("nav-about").textContent=t.nav_about;
  document.getElementById("nav-contact").textContent=t.nav_contact;
  document.getElementById("collection-title").textContent=t.collection_title;
  document.getElementById("item1").textContent=t.item1;
  document.getElementById("item2").textContent=t.item2;
  document.getElementById("footer-text").textContent=t.footer;
  localStorage.setItem("lang",lang);
}

updateLanguage(localStorage.getItem("lang")||'fr');
document.getElementById("lang").value=localStorage.getItem("lang")||'fr';
document.getElementById("lang").addEventListener("change",(e)=>updateLanguage(e.target.value));

// Devise
const rates = {MAD:1, EUR:0.092, USD:0.10};
const currencySelect = document.getElementById('currency');

function updatePrices(currency){
    document.querySelectorAll('.price').forEach(p=>{
        const mad = parseFloat(p.dataset.mad);
        const converted = (mad * rates[currency]).toFixed(2);
        let symbol = currency;
        if(currency==='EUR') symbol='€';
        if(currency==='USD') symbol='$';
        if(currency==='MAD') symbol='MAD';
        p.querySelector('.price-value').textContent = converted + ' ' + symbol;
    });
    localStorage.setItem('currency', currency);
}

// Charger devise depuis localStorage
let savedCurrency = localStorage.getItem('currency') || 'MAD';
currencySelect.value = savedCurrency;
updatePrices(savedCurrency);

currencySelect.addEventListener('change',(e)=>{
    updatePrices(e.target.value);
});

// Scroll animations
document.addEventListener('DOMContentLoaded', function(){
  const faders=document.querySelectorAll('.fade-in');
  const appearOnScroll=new IntersectionObserver((entries,observer)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){entry.target.classList.add('visible');observer.unobserve(entry.target);}
    });
  },{threshold:0.1,rootMargin:"0px 0px -50px 0px"});
  faders.forEach(fader=>appearOnScroll.observe(fader));
});
</script>

</body>
</html>