<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="image.jpg" type="image/png">
<title>Athar_brn</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

:root {
  --bg: #f8fafc;
  --text: #222;
  --header-bg: #fff; /* bande blanche par défaut */
  --primary: #1abc9c;
  --secondary: #16a085;
  --card-bg: #fff;
  --shadow: rgba(0,0,0,0.1);
  --toggle-bg: #fff;
}

/* DARK MODE */
body.dark {
  --bg: #0d0d0d;
  --text: #f2f2f2;
  --header-bg: #0000; /* devient noir en sombre */
  --card-bg: #1a1a1a;
  --shadow: rgba(255,255,255,0.08);
  --toggle-bg: #222;
}

body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: var(--bg);
  color: var(--text);
  transition: all 0.4s ease;
}

/* HEADER */
header {
  background: var(--header-bg);
  color: var(--text);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  flex-wrap: wrap;
  position: sticky;
  top: 0;
  z-index: 999;
  box-shadow: 0 3px 10px var(--shadow);
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}
.logo img {
  width: 50px;
  border-radius: 8px;
  transition: transform 0.3s;
}
.logo:hover img {
  transform: scale(1.1);
}

/* NAV */
nav a {
  color: var(--text);
  margin: 0 15px;
  text-decoration: none;
  font-weight: 500;
  position: relative;
  transition: color 0.3s;
}
nav a::after {
  content: '';
  display: block;
  height: 2px;
  background: var(--primary);
  width: 0;
  transition: 0.3s;
  position: absolute;
  bottom: -5px;
  left: 0;
}
nav a:hover::after, nav a.active::after {
  width: 100%;
}
nav a:hover, nav a.active {
  color: var(--primary);
}

/* TOGGLES */
.controls {
  display: flex;
  align-items: center;
  gap: 10px;
}
select, button {
  border: none;
  border-radius: 25px;
  padding: 8px 15px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}
select {
  background: var(--toggle-bg);
  color: var(--text);
  box-shadow: 0 2px 6px var(--shadow);
}
select:hover {
  transform: scale(1.05);
}
#dark-toggle {
  background: var(--primary);
  color: #fff;
  box-shadow: 0 3px 8px var(--shadow);
}
#dark-toggle:hover {
  background: var(--secondary);
  transform: rotate(10deg) scale(1.1);
}

/* HERO */
.hero {
  position: relative;
  height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  text-align: center;
  overflow: hidden;
}
#video-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
  filter: brightness(55%);
  transition: transform 0.3s, filter 0.3s;
}
.hero-text {
  position: relative;
  z-index: 2;
  max-width: 800px;
  animation: fadeUp 1s ease forwards;
  opacity: 0;
}
.hero-text h2 {
  font-size: 3em;
  margin-bottom: 15px;
  line-height: 1.2;
}
.hero-text span {
  color: var(--primary);
}
.hero-text p {
  font-size: 1.2em;
  margin-bottom: 25px;
}
.btn {
  display: inline-block;
  background: var(--primary);
  color: #fff;
  padding: 14px 30px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s;
}
.btn:hover {
  background: var(--secondary);
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 5px 20px var(--shadow);
}

/* COLLECTION */
.collection {
  text-align: center;
  padding: 70px 20px;
}
.collection h2 {
  font-size: 2.2em;
  margin-bottom: 40px;
  animation: fadeUp 1s ease forwards;
  opacity: 0;
}
.grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
}
.card {
  background: var(--card-bg);
  border-radius: 15px;
  width: 260px;
  padding: 15px;
  box-shadow: 0 5px 15px var(--shadow);
  transition: all 0.3s;
  cursor: pointer;
  transform: translateY(20px);
  opacity: 0;
  animation: fadeUp 0.5s ease forwards;
}
.card:nth-child(1){animation-delay: 0.2s;}
.card:nth-child(2){animation-delay: 0.4s;}
.card:nth-child(3){animation-delay: 0.6s;}
.card:hover {
  transform: translateY(-8px) scale(1.05);
  box-shadow: 0 10px 25px var(--shadow);
}
.card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 12px;
  transition: transform 0.5s;
}
.card:hover img {
  transform: scale(1.1);
}
.card p {
  margin-top: 12px;
  font-weight: 500;
  font-size: 1em;
}

/* FOOTER */
footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background: var(--header-bg); /* utilise la même variable que header */
  color: var(--text);
  text-align: center;
  font-size: 0.85em;
  padding: 10px 15px;
  box-shadow: 0 -2px 8px var(--shadow);
  z-index: 999;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

/* ANIMATIONS */
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(20px);}
  100% { opacity: 1; transform: translateY(0);}
}

/* RESPONSIVE */
@media (max-width: 768px) {
  header {
    flex-direction: column;
    padding: 20px;
    text-align: center;
  }
  nav {
    margin-top: 10px;
  }
  .hero-text h2 { font-size: 2em; }
  .grid { flex-direction: column; align-items: center; }
  .card { width: 90%; }
}
@media (max-width: 480px){
  .hero-text h2 { font-size: 1.5em; }
  .hero-text p { font-size: 1em; }
  .btn { padding: 12px 25px; font-size: 0.9em; }
}
</style>
</head>
<body>

<header>
  <div class="logo">
      <img src="image.jpg" alt="Athar_brn Logo">
      <h1 id="logo-text">Athar_brn</h1>
  </div>
  <div class="controls">
      <select id="lang">
          <option value="fr">🇫🇷 FR</option>
          <option value="es">🇪🇸 ES</option>
          <option value="ar">🇸🇦 AR</option>
          <option value="de">🇩🇪 DE</option>
          <option value="en">🇬🇧 EN</option>
      </select>
      <button id="dark-toggle">🌙</button>
  </div>
  <nav>
      <a href="#" class="active" id="nav-home">Accueil</a>
      <a href="produits.php" id="nav-products">Produits</a>
      <a href="apropos.php" id="nav-about">À propos</a>
      <a href="contact.php" id="nav-contact">Contact</a>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
  <video autoplay muted loop playsinline id="video-bg">
      <source src="pub.mp4.mp4" type="video/mp4">
  </video>
  <div class="hero-text">
      <h2 id="hero-title"></h2>
      <p id="hero-desc"></p>
      <a href="produits.php" class="btn" id="hero-btn"></a>
  </div>
</section>

<!-- COLLECTION -->
<section class="collection">
  <h2 id="collection-title">Nos dernières créations</h2>
  <div class="grid">
      <div class="card">
          <img src="images/tshirt1.jpg" alt="T-shirt ITR">
          <p id="item1">T-shirt ITR Classic</p>
      </div>
      <div class="card">
          <img src="images/hoodie1.jpg" alt="Hoodie ITR">
          <p id="item2">Hoodie Urban</p>
      </div>
      <div class="card">
          <img src="images/cap1.jpg" alt="Casquette ITR">
          <p id="item3">Casquette Original</p>
      </div>
  </div>
</section>

<footer>
  <p>&copy; <span id="year"></span> Athar_brn — <span id="footer-text">Tous droits réservés</span></p>
</footer>

<script>
document.getElementById("year").textContent = new Date().getFullYear();

// DARK MODE toggle
const toggle = document.getElementById('dark-toggle');
toggle.addEventListener('click', ()=>{
  document.body.classList.toggle('dark');
  toggle.textContent = document.body.classList.contains('dark') ? '☀️' : '🌙';
  localStorage.setItem("theme", document.body.classList.contains('dark') ? "dark" : "light");
});
if(localStorage.getItem("theme") === "dark"){
  document.body.classList.add("dark");
  toggle.textContent = '☀️';
}

// MULTILINGUAL TEXTS
const texts = {
  fr: { nav_home:"Accueil", nav_products:"Produits", nav_about:"À propos", nav_contact:"Contact",
        hero_title:"️ L'homme laisse toujours une trace, laisse-en une belle ☘️",
        hero_desc:"Une marque marocaine alliant élégance, qualité et originalité.",
        hero_btn:"Découvrir la collection", collection_title:"Nos dernières créations",
        item1:"T-shirt ITR Classic", item2:"Hoodie Urban", item3:"Casquette Originale",
        footer:"Tous droits réservés"},
  es: { nav_home:"Inicio", nav_products:"Productos", nav_about:"Sobre nosotros", nav_contact:"Contacto",
        hero_title:" El hombre siempre deja una huella, deja una hermosa ☘️",
        hero_desc:"Una marca marroquí que combina elegancia, calidad y originalidad.",
        hero_btn:"Descubre la colección", collection_title:"Nuestras últimas creaciones",
        item1:"Camiseta ITR Classic", item2:"Sudadera Urban", item3:"Gorra Original",
        footer:"Todos los derechos reservados"},
  ar: { nav_home:"الرئيسية", nav_products:"المنتجات", nav_about:"حولنا", nav_contact:"اتصل بنا",
        hero_title:"☘️ إنما الإنسان أثر، فإترك أثراً جميلا ",
        hero_desc:"علامة مغربية تجمع بين الأناقة والجودة والأصالة.",
        hero_btn:"اكتشف المجموعة", collection_title:"أحدث تصاميمنا",
        item1:"تيشيرت ITR كلاسيكي", item2:"هودي أوربان", item3:"قبعة أصلية",
        footer:"جميع الحقوق محفوظة"},
  de: { nav_home:"Startseite", nav_products:"Produkte", nav_about:"Über uns", nav_contact:"Kontakt",
        hero_title:" Der Mensch hinterlässt immer Spuren, hinterlasse eine schöne ☘️",
        hero_desc:"Eine marokkanische Marke, die Eleganz, Qualität und Originalität vereint.",
        hero_btn:"Kollektion entdecken", collection_title:"Unsere neuesten Kreationen",
        item1:"ITR Classic T-Shirt", item2:"Urban Hoodie", item3:"Original Cap",
        footer:"Alle Rechte vorbehalten"},
  en: { nav_home:"Home", nav_products:"Products", nav_about:"About", nav_contact:"Contact",
        hero_title:" Man always leaves a mark, leave a beautiful one ☘️",
        hero_desc:"A Moroccan brand combining elegance, quality, and originality.",
        hero_btn:"Discover the collection", collection_title:"Our latest creations",
        item1:"ITR Classic T-shirt", item2:"Urban Hoodie", item3:"Original Cap",
        footer:"All rights reserved"}
};

function updateLanguage(lang){
  const t = texts[lang];
  document.getElementById("nav-home").textContent = t.nav_home;
  document.getElementById("nav-products").textContent = t.nav_products;
  document.getElementById("nav-about").textContent = t.nav_about;
  document.getElementById("nav-contact").textContent = t.nav_contact;
  document.getElementById("hero-title").innerHTML = t.hero_title;
  document.getElementById("hero-desc").textContent = t.hero_desc;
  document.getElementById("hero-btn").textContent = t.hero_btn;
  document.getElementById("collection-title").textContent = t.collection_title;
  document.getElementById("item1").textContent = t.item1;
  document.getElementById("item2").textContent = t.item2;
  document.getElementById("item3").textContent = t.item3;
  document.getElementById("footer-text").textContent = t.footer;
  localStorage.setItem("lang", lang);
}

// LANG default
updateLanguage(localStorage.getItem("lang") || 'fr');
document.getElementById("lang").value = localStorage.getItem("lang") || 'fr';
document.getElementById("lang").addEventListener("change", (e)=>{
  updateLanguage(e.target.value);
});

// Parallax
const video = document.getElementById('video-bg');
window.addEventListener('scroll', ()=>{
  const offset = window.pageYOffset;
  video.style.transform = `translateY(${offset * 0.2}px)`;
});
</script>
</body>
</html>
