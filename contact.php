<?php
require 'db.php'; // Connexion PDO

$success = ''; 
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : '';
    $produit = isset($_POST['produit']) ? htmlspecialchars($_POST['produit']) : '';
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    if($nom && $email && $telephone && $produit && $quantite && $message){
        $stmt = $pdo->prepare("INSERT INTO commandes (nom,email,telephone,produit,quantite,message) VALUES (?,?,?,?,?,?)");
        try {
            if($stmt->execute([$nom,$email,$telephone,$produit,$quantite,$message])){
                $success = "Commande envoyée avec succès !";
            } else {
                $error = "Erreur lors de l'envoi de la commande.";
            }
        } catch(PDOException $e){
            $error = "Erreur base de données : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="image.jpg" type="image/png">
<title>Commander - Athar_brn</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

:root{
--bg:#f8fafc;--text:#222;--header:#fff;
--primary:#1abc9c;--secondary:#16a085;
--card:#fff;--shadow:rgba(0,0,0,0.1);--input:#fafafa;
--whatsapp:#25D366;--instagram:#C13584;--facebook:#1877F2;
}
body.dark{
--bg:#0d0d0d;--text:#f2f2f2;--header:#111;--card:#1a1a1a;--shadow:rgba(255,255,255,0.08);--input:#222;
}
body{margin:0;font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);transition:0.4s;}
header{background:var(--header);display:flex;justify-content:space-between;align-items:center;padding:10px 20px;position:sticky;top:0;z-index:999;box-shadow:0 3px 10px var(--shadow);}
.logo{display:flex;align-items:center;gap:8px;}
.logo img{width:40px;border-radius:6px;}
nav a{margin:0 10px;text-decoration:none;color:var(--text);font-weight:500;position:relative;}
nav a.active::after, nav a:hover::after{content:'';position:absolute;bottom:-3px;left:0;width:100%;height:2px;background:var(--primary);}
.controls{display:flex;align-items:center;gap:5px;}
select,button{border:none;border-radius:20px;padding:6px 12px;cursor:pointer;}
select{background:var(--input);color:var(--text);}
#dark-toggle{background:var(--primary);color:#fff;}
.contact{padding:50px 10px;text-align:center;}
form{background:var(--card);padding:20px;border-radius:15px;max-width:400px;margin:0 auto;display:flex;flex-direction:column;gap:10px;box-shadow:0 5px 15px var(--shadow);}
input,select,textarea{padding:10px;border-radius:10px;border:1px solid #ccc;background:var(--input);color:var(--text);}
button{background:var(--primary);color:#fff;padding:10px;border-radius:20px;cursor:pointer;}
button:hover{background:var(--secondary);}
.success{color:green;margin-bottom:5px;}
.error{color:red;margin-bottom:5px;}
footer{background:var(--header);text-align:center;padding:10px;font-size:0.8em;box-shadow:0 -2px 5px var(--shadow);}

/* Social Buttons */
.social-contact{display:flex;justify-content:center;margin:20px 0;flex-wrap:wrap;gap:10px;}
.social{display:flex;align-items:center;gap:8px;padding:10px 15px;border-radius:10px;text-decoration:none;font-size:0.95em;color:#fff;transition:0.3s;display:inline-flex;}
.social svg{width:20px;height:20px;fill:#fff;}
.social.whatsapp{background:var(--whatsapp);}
.social.instagram{background:var(--instagram);}
.social.facebook{background:var(--facebook);}
.social:hover{opacity:0.8;transform:scale(1.05);}

/* RESPONSIVE */
@media (max-width: 1024px) {
  header {flex-direction: column;align-items: flex-start;padding: 15px 20px;}
  nav {margin-top: 10px;flex-wrap: wrap;gap: 10px;}
  .controls {width: 100%;justify-content: space-between;margin-top: 10px;}
  form {max-width: 100%;padding: 15px;}
  .social-contact {flex-wrap: wrap;justify-content: center;gap: 10px;}
}

@media (max-width: 768px) {
  header {text-align: center;}
  nav {margin-top: 15px;}
  form {padding: 12px;}
  input, select, textarea, button {width: 100%;box-sizing: border-box;}
  .social-contact {flex-direction: column;align-items: center;gap: 10px;}
}

@media (max-width: 480px) {
  header h1 {font-size: 1.2em;}
  .logo img {width: 30px;}
  .contact h2 {font-size: 1.5em;}
  form {padding: 10px;}
  button {padding: 10px;font-size: 0.9em;}
  .social {padding: 8px 12px;font-size: 0.85em;}
}
</style>
</head>
<body>

<header>
<div class="logo"><img src="image.jpg" alt="Logo"><h1>Athar_brn</h1></div>
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
<a href="index.php" id="nav-home">Accueil</a>
<a href="produits.php" id="nav-products">Produits</a>
<a href="apropos.php" id="nav-about">À propos</a>
<a href="#" class="active" id="nav-contact">Commander</a>
</nav>
</header>

<section class="contact">
<h2 id="contact-title">Que voulez-vous commander ?</h2>
<?php if($success): ?><p class="success"><?= $success ?></p><?php elseif($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="POST">
<input type="text" name="nom" placeholder="Votre nom" required>
<input type="email" name="email" placeholder="Votre email" required>
<input type="tel" name="telephone" placeholder="Votre numéro de téléphone" required>
<select name="produit" required>
<option value="">-- Choisissez un produit --</option>
<option value="T-shirt">T-shirt</option>
<option value="Hoodie">Hoodie</option>
<option value="Casquette">Casquette</option>
</select>
<input type="number" name="quantite" placeholder="Quantité" min="1" required>
<textarea name="message" placeholder="Votre message..." required></textarea>
<button type="submit">Commander</button>
</form>
</section>

<div class="social-contact">
<a href="https://wa.me/1234567890" target="_blank" class="social whatsapp">
<svg viewBox="0 0 32 32"><path d="M16 0c-8.837 0-16 7.163-16 16 0 2.832.742 5.484 2.03 7.797l-2.152 7.203 7.37-2.001c2.239 1.183 4.801 1.801 7.302 1.801 8.837 0 16-7.163 16-16S24.837 0 16 0zm8.837 23.723c-.219.609-1.272 1.188-1.755 1.271-.47.083-1.041.116-3.057-.666-4.322-1.574-7.124-6.143-7.332-6.426-.209-.283-1.695-2.145-1.695-4.096 0-1.95 1.009-2.895 1.367-3.287.36-.392.785-.478 1.04-.478.27 0 .547.003.787.003.256 0 .595-.097.935.729.329.81 1.105 2.804 1.203 3.004.097.2.158.433.013.695-.145.262-.209.42-.396.654-.187.235-.397.517-.566.695-.187.192-.38.403-.185.789.193.387.855 1.271 1.829 2.055 1.263 1.054 2.315 1.336 2.688 1.488.371.151.588.129.805-.077.218-.205.941-1.091 1.197-1.462.255-.371.511-.31.855-.187.345.123 2.179 1.027 2.557 1.215.379.188.633.282.725.444.092.162.092.934-.127 1.543z"/></svg>
WhatsApp
</a>

<a href="https://instagram.com/votrecompte" target="_blank" class="social instagram">
<svg viewBox="0 0 32 32"><path d="M16 7.5c-4.694 0-8.5 3.806-8.5 8.5s3.806 8.5 8.5 8.5 8.5-3.806 8.5-8.5-3.806-8.5-8.5-8.5zm0 14c-3.037 0-5.5-2.463-5.5-5.5s2.463-5.5 5.5-5.5 5.5 2.463 5.5 5.5-2.463 5.5-5.5 5.5zm6.406-10.844a1.406 1.406 0 1 1 0-2.812 1.406 1.406 0 0 1 0 2.812zM16 0C7.163 0 0 7.163 0 16s7.163 16 16 16 16-7.163 16-16S24.837 0 16 0z"/></svg>
Instagram
</a>

<a href="https://facebook.com/votrepage" target="_blank" class="social facebook">
<svg viewBox="0 0 32 32"><path d="M19 6h5V0h-5c-5.523 0-10 4.477-10 10v4H4v6h5v12h6V20h5l1-6h-6v-4c0-1.103.897-2 2-2z"/></svg>
Facebook
</a>
</div>

<footer>
<p>&copy; <span id="year"></span> Athar_brn — <span id="footer-text">Tous droits réservés</span></p>
</footer>

<script>
document.getElementById("year").textContent = new Date().getFullYear();

// Dark Mode
const toggle = document.getElementById('dark-toggle');
toggle.addEventListener('click', ()=>{ 
    document.body.classList.toggle('dark'); 
    toggle.textContent = document.body.classList.contains('dark') ? '☀️' : '🌙'; 
    localStorage.setItem("theme", document.body.classList.contains('dark')?"dark":"light"); 
});
if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark"); toggle.textContent='☀️';}

// Multilingual
const texts = {
    fr:{nav_home:"Accueil",nav_products:"Produits",nav_about:"À propos",nav_contact:"Commander",contact_title:"Que voulez-vous commander ?",footer:"Tous droits réservés",nom:"Votre nom",email:"Votre email",telephone:"Votre numéro de téléphone",produit:"Choisissez un produit",quantite:"Quantité",message:"Votre message...",btn:"Commander"},
    en:{nav_home:"Home",nav_products:"Products",nav_about:"About",nav_contact:"Order",contact_title:"What do you want to order?",footer:"All rights reserved",nom:"Your name",email:"Your email",telephone:"Your phone number",produit:"Select a product",quantite:"Quantity",message:"Your message...",btn:"Order"},
    es:{nav_home:"Inicio",nav_products:"Productos",nav_about:"Sobre nosotros",nav_contact:"Pedido",contact_title:"¿Qué desea pedir?",footer:"Todos los derechos reservados",nom:"Tu nombre",email:"Tu email",telephone:"Tu número de teléfono",produit:"Seleccione un producto",quantite:"Cantidad",message:"Tu mensaje...",btn:"Pedir"},
    ar:{nav_home:"الرئيسية",nav_products:"المنتجات",nav_about:"حولنا",nav_contact:"طلب",contact_title:"ماذا تريد طلبه؟",footer:"جميع الحقوق محفوظة",nom:"اسمك",email:"بريدك الإلكتروني",telephone:"رقم هاتفك",produit:"اختر المنتج",quantite:"الكمية",message:"رسالتك...",btn:"طلب"},
    de:{nav_home:"Startseite",nav_products:"Produkte",nav_about:"Über uns",nav_contact:"Bestellen",contact_title:"Was möchten Sie bestellen?",footer:"Alle Rechte vorbehalten",nom:"Ihr Name",email:"Ihre E-Mail",telephone:"Ihre Telefonnummer",produit:"Produkt auswählen",quantite:"Menge",message:"Ihre Nachricht...",btn:"Bestellen"}
};

function updateLanguage(lang){
    const t = texts[lang];
    document.getElementById("nav-home").textContent = t.nav_home;
    document.getElementById("nav-products").textContent = t.nav_products;
    document.getElementById("nav-about").textContent = t.nav_about;
    document.getElementById("nav-contact").textContent = t.nav_contact;
    document.getElementById("contact-title").textContent = t.contact_title;
    document.querySelector('input[name="nom"]').placeholder = t.nom;
    document.querySelector('input[name="email"]').placeholder = t.email;
    document.querySelector('input[name="telephone"]').placeholder = t.telephone;
    document.querySelector('select[name="produit"] option:first-child').textContent = t.produit;
    document.querySelector('input[name="quantite"]').placeholder = t.quantite;
    document.querySelector('textarea[name="message"]').placeholder = t.message;
    document.querySelector('button[type="submit"]').textContent = t.btn;
    document.getElementById("footer-text").textContent = t.footer;
    localStorage.setItem("lang", lang);
}

updateLanguage(localStorage.getItem("lang") || 'fr');
document.getElementById("lang").value = localStorage.getItem("lang") || 'fr';
document.getElementById("lang").addEventListener("change",(e)=>updateLanguage(e.target.value));
</script>

</body>
</html>
