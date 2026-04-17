<?php
session_start();
require 'db.php';

// Mot de passe admin
$ADMIN_PASSWORD = "1234";

// Connexion admin
if(!isset($_SESSION['admin_logged'])){
    if(isset($_POST['password']) && $_POST['password']===$ADMIN_PASSWORD){
        $_SESSION['admin_logged']=true;
    }else{
        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="image.jpg" type="image/png">
            <title>Connexion Admin</title>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
            <style>
                body{font-family:"Poppins",sans-serif;background:#000;color:#fff;height:100vh;margin:0;display:flex;justify-content:center;align-items:center;}
                .box{background:#111;padding:40px;border-radius:20px;width:350px;text-align:center;box-shadow:0 8px 30px rgba(255,255,255,0.1);}
                input{width:80%;padding:12px;border:none;border-radius:50px;background:#222;color:#fff;text-align:center;margin-bottom:15px;font-size:16px;}
                button{padding:12px 25px;border:none;border-radius:50px;background:#1abc9c;color:#fff;cursor:pointer;font-weight:600;font-size:16px;transition:0.3s;}
                button:hover{opacity:0.85;}
            </style>
        </head>
        <body>
         <div class="box">
    <!-- Logo en haut -->
    <img src="image.jpg" alt="Logo Admin" style="width:80px;height:80px;border-radius:50%;margin-bottom:15px;object-fit:cover;box-shadow:0 4px 12px rgba(0,0,0,0.3);">
                <h2>Connexion Admin</h2>
                <form method="POST">
                    <input type="password" name="password" placeholder="Mot de passe admin" required><br>
                    <button type="submit">Se connecter</button>
                </form>
            </div>
        </body>
        </html>';
        exit;
    }
}

// Déconnexion
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Supprimer commande
if(isset($_GET['delete'])){
    $id=intval($_GET['delete']);
    $stmt=$pdo->prepare("DELETE FROM commandes WHERE id=?");
    $stmt->execute([$id]);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Bascule état traité/non traité
if(isset($_GET['toggle'])){
    $id=intval($_GET['toggle']);
    $stmt=$pdo->prepare("SELECT etat FROM commandes WHERE id=?");
    $stmt->execute([$id]);
    $etat=$stmt->fetchColumn();
    $newEtat=$etat?0:1;
    $stmt=$pdo->prepare("UPDATE commandes SET etat=? WHERE id=?");
    $stmt->execute([$newEtat,$id]);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Récupération commandes
$stmt=$pdo->query("SELECT * FROM commandes ORDER BY date_commande DESC");
$commandes=$stmt->fetchAll(PDO::FETCH_ASSOC);

// Statistiques
$total=count($commandes);
$produits=[];
foreach($commandes as $c){
    $produits[$c['produit']]=($produits[$c['produit']]??0)+$c['quantite'];
}

// Export CSV
if(isset($_GET['export']) && $_GET['export']=='csv'){
    header('Content-Type:text/csv; charset=utf-8');
    header('Content-Disposition:attachment; filename=commandes.csv');
    $out=fopen('php://output','w');
    fputcsv($out,['ID','Nom','Téléphone','Email','Produit','Quantité','État','Date','Message']);
    foreach($commandes as $c){
        fputcsv($out,[$c['id'],$c['nom'],$c['telephone'],$c['email'],$c['produit'],$c['quantite'],$c['etat'],$c['date_commande'],$c['message']]);
    }
    fclose($out);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="image.jpg" type="image/png">
<title>Dashboard Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<!-- Chart.js + jsPDF + autoTable -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<style>
:root{
  --bg-dark:#000;--text-dark:#fff;--header-dark:#111;--card-dark:#111;
  --bg-light:#f8f8f8;--text-light:#000;--header-light:#fff;--card-light:#fff;
  --primary:#1abc9c;
}
*{box-sizing:border-box}
body{margin:0;font-family:'Poppins',sans-serif;background:var(--bg-dark);color:var(--text-dark);transition:0.25s;}
body.light{background:var(--bg-light);color:var(--text-light);}
header{background:var(--header-dark);color:var(--text-dark);display:flex;justify-content:space-between;align-items:center;padding:14px 20px;position:sticky;top:0;z-index:10;box-shadow:0 3px 8px rgba(255,255,255,0.04);}
body.light header{background:var(--header-light);color:var(--text-light);}
header h1{display:flex;align-items:center;gap:12px;font-size:18px;margin:0;}
header h1 img{height:48px;width:48px;border-radius:50%;object-fit:cover;box-shadow:0 6px 18px rgba(0,0,0,0.25);}
.controls{display:flex;gap:10px;align-items:center;}
button,select{border:none;border-radius:10px;padding:8px 12px;cursor:pointer;transition:0.2s;font-weight:600;}
#dark-toggle{background:var(--primary);color:#fff;}
.logout{background:#e74c3c;color:#fff;text-decoration:none;padding:8px 12px;border-radius:10px;}
.logout:hover,button:hover{opacity:0.9;}

.container{display:flex;flex-wrap:wrap;gap:16px;justify-content:center;padding:18px;}
.card{background:var(--card-dark);border-radius:14px;padding:18px;width:260px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,0.25);transition:transform .2s;}
.card h3{color:var(--primary);margin:6px 0 12px 0;font-size:16px;}
.card p{font-size:24px;margin:6px 0 0 0;font-weight:700;}

.card-chart{width:360px;padding:14px;}
.canvas-wrap{height:320px;display:flex;align-items:center;justify-content:center;}

.export-top{display:flex;justify-content:flex-end;gap:10px;padding:6px 18px 0 18px;flex-wrap:wrap;}
.export-top button{background:var(--primary);color:#fff;padding:8px 14px;border-radius:8px;display:inline-flex;gap:8px;align-items:center;}
.export-top .csv{background:transparent;border:2px solid var(--primary);color:var(--primary);}
.export-top .pdf{background:var(--primary);}

.table-wrap{padding:15px;}
table{width:100%;border-collapse:collapse;margin-top:10px;font-size:0.95rem;}
th,td{padding:10px;border-bottom:1px solid rgba(255,255,255,0.06);text-align:left;}
body.light th, body.light td{border-bottom:1px solid rgba(0,0,0,0.06);}
th{background:var(--primary);color:#fff;position:sticky;top:72px;}
tr.traite{background:#1b5e20;color:#fff;}
tr.non-traite{background:#b71c1c;color:#fff;}
.action-btn{background:transparent;border:none;color:inherit;cursor:pointer;padding:6px 8px;border-radius:8px;}

@media(min-width:1100px){
  .container{justify-content:flex-start;padding:20px 40px;}
  .card{width:220px;}
  .card-chart{width:420px;}
}
@media(max-width:1099px){
  .card-chart{width:360px;}
}
@media(max-width:768px){
  header{padding:12px;}
  .container{flex-direction:column;align-items:center;padding:12px;}
  .card-chart{width:95%;}
  table,thead,tbody,th,td,tr{display:block;width:100%;}
  tr{margin-bottom:12px;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:8px;}
  td{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.04);}
  td::before{content:attr(data-label);font-weight:600;width:120px;display:inline-block;}
  th{display:none;}
}
</style>
</head>
<body>

<header>
  <h1><img src="image.jpg" alt="Logo Admin"> Dashboard Admin</h1>
  <div class="controls">
    <button id="dark-toggle" title="Dark / Light">🌙</button>
    <select id="lang" title="Langue">
      <option value="fr">🇫🇷 FR</option>
      <option value="en">🇬🇧 EN</option>
      <option value="es">🇪🇸 ES</option>
      <option value="ar">🇸🇦 AR</option>
      <option value="de">🇩🇪 DE</option>
    </select>
    <a href="?logout=1" class="logout" id="logout-btn">Se déconnecter</a>
  </div>
</header>

<div class="container">
  <div class="card">
    <h3 data-i18n="total">Total Commandes</h3>
    <p id="totalCount"><?= $total ?></p>
  </div>

  <div class="card card-chart">
    <h3 data-i18n="produits">Produits Commandés</h3>
    <div class="canvas-wrap">
      <canvas id="pieChart" aria-label="Produits Chart" role="img"></canvas>
    </div>
  </div>
</div>

<div class="export-top">
  <button class="csv" onclick="exportCSV()">📊 CSV</button>
  <button class="pdf" onclick="exportPDF()">📄 PDF</button>
</div>

<div class="table-wrap">
  <h3 data-i18n="liste">Liste des Commandes</h3>
  <table id="ordersTable">
    <thead>
      <tr>
        <th data-i18n="id">ID</th>
        <th data-i18n="nom">Nom</th>
        <th data-i18n="tel">Téléphone</th>
        <th data-i18n="email">Email</th>
        <th data-i18n="produit">Produit</th>
        <th data-i18n="qte">Qté</th>
        <th data-i18n="etat">État</th>
        <th data-i18n="date">Date</th>
        <th data-i18n="message">Message</th>
        <th data-i18n="action">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($commandes as $c):
      $etat=$c['etat']??0;
      $row=$etat?'traite':'non-traite'; ?>
      <tr class="<?= $row ?>">
        <td data-label="ID"><?= $c['id'] ?></td>
        <td data-label="Nom"><?= htmlspecialchars($c['nom']) ?></td>
        <td data-label="Téléphone"><?= htmlspecialchars($c['telephone']) ?></td>
        <td data-label="Email"><?= htmlspecialchars($c['email']) ?></td>
        <td data-label="Produit"><?= htmlspecialchars($c['produit']) ?></td>
        <td data-label="Qté"><?= $c['quantite'] ?></td>
        <td data-label="État">
          <form method="GET" style="display:inline;">
            <input type="hidden" name="toggle" value="<?= $c['id'] ?>">
            <button class="action-btn" title="Toggle état"><?= $etat?'✅':'❌' ?></button>
          </form>
        </td>
        <td data-label="Date"><?= $c['date_commande'] ?></td>
        <td data-label="Message"><?= htmlspecialchars($c['message'] ?? '-') ?></td>
        <td data-label="Action">
          <form method="GET" onsubmit="return confirm('Supprimer cette commande ?')" style="display:inline;">
            <input type="hidden" name="delete" value="<?= $c['id'] ?>">
            <button class="action-btn" style="background:#e74c3c;color:#fff;border-radius:8px;padding:6px 8px;">✖</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
// ---------- Dark / Light ----------
const toggle = document.getElementById("dark-toggle");
function applyTheme(theme){
  if(theme==="light"){ document.body.classList.add("light"); toggle.textContent="☀"; }
  else { document.body.classList.remove("light"); toggle.textContent="🌙"; }
}
const savedTheme = localStorage.getItem("theme") || "dark";
applyTheme(savedTheme);
toggle.onclick = () => {
  const nowLight = document.body.classList.toggle("light");
  toggle.textContent = nowLight ? "☀" : "🌙";
  localStorage.setItem("theme", nowLight ? "light" : "dark");
};

// ---------- Translations ----------
const translations={
 fr:{total:"Total Commandes",produits:"Produits Commandés",liste:"Liste des Commandes",id:"ID",nom:"Nom",tel:"Téléphone",email:"Email",produit:"Produit",qte:"Qté",etat:"État",date:"Date",message:"Message",action:"Action",logout:"Se déconnecter"},
 en:{total:"Total Orders",produits:"Ordered Products",liste:"Orders List",id:"ID",nom:"Name",tel:"Phone",email:"Email",produit:"Product",qte:"Qty",etat:"Status",date:"Date",message:"Message",action:"Action",logout:"Logout"},
 es:{total:"Pedidos Totales",produits:"Productos Pedidos",liste:"Lista de Pedidos",id:"ID",nom:"Nombre",tel:"Teléfono",email:"Correo",produit:"Producto",qte:"Cant",etat:"Estado",date:"Fecha",message:"Mensaje",action:"Acción",logout:"Cerrar sesión"},
 ar:{total:"إجمالي الطلبات",produits:"المنتجات المطلوبة",liste:"قائمة الطلبات",id:"الرقم",nom:"الاسم",tel:"الهاتف",email:"البريد",produit:"المنتج",qte:"الكمية",etat:"الحالة",date:"التاريخ",message:"الرسالة",action:"الإجراء",logout:"تسجيل الخروج"},
 de:{total:"Gesamtbestellungen",produits:"Bestellte Produkte",liste:"Bestellliste",id:"ID",nom:"Name",tel:"Telefon",email:"E-Mail",produit:"Produkt",qte:"Menge",etat:"Status",date:"Datum",message:"Nachricht",action:"Aktion",logout:"Abmelden"}
};
const langSelect=document.getElementById("lang");
let currentLang=localStorage.getItem("lang")||"fr";
langSelect.value=currentLang;
function applyLang(lang){
 currentLang=lang;
 document.querySelectorAll("[data-i18n]").forEach(el=>{
  const k=el.getAttribute("data-i18n");
  if(translations[lang][k]) el.textContent=translations[lang][k];
 });
 document.getElementById("logout-btn").textContent=translations[lang].logout;
 localStorage.setItem("lang",lang);
}
langSelect.onchange=()=>applyLang(langSelect.value);
applyLang(currentLang);

// ---------- Chart.js pie chart ----------
const pieLabels = <?= json_encode(array_keys($produits)) ?>;
const pieData = <?= json_encode(array_values($produits)) ?>;
const ctx = document.getElementById("pieChart").getContext("2d");

const defaultColors = ['#1abc9c','#3498db','#f39c12','#e74c3c','#9b59b6','#2ecc71','#16a085','#8e44ad','#e67e22','#34495e'];
function getColors(n){
  if(n<=defaultColors.length) return defaultColors.slice(0,n);
  const colors = [];
  for(let i=0;i<n;i++){ colors.push(defaultColors[i%defaultColors.length]); }
  return colors;
}

const pieChart = new Chart(ctx, {
  type: 'pie',
  data: { labels: pieLabels, datasets: [{ data: pieData, backgroundColor: getColors(pieLabels.length), borderColor: document.body.classList.contains('light') ? '#f8f8f8' : '#fff', borderWidth: 2, hoverOffset: 16 }]},
  options: {
    responsive:true,
    maintainAspectRatio:false,
    plugins:{
      legend:{ position:'bottom', labels:{ color: document.body.classList.contains('light') ? '#000' : '#fff', font:{size:13,weight:600} } },
      tooltip:{ callbacks:{ label: function(context){ const value=context.parsed; const total=context.dataset.data.reduce((a,b)=>a+b,0); const pct=total?((value/total)*100).toFixed(1):0; return context.label + ': ' + value + ' ('+pct+'%)'; } } }
    },
    animation:{animateScale:true, animateRotate:true, duration:900, easing:'easeOutCubic'}
  }
});

// Update chart border color on theme change
const obs = new MutationObserver(()=> {
  const border = document.body.classList.contains('light') ? '#f8f8f8' : '#fff';
  pieChart.data.datasets[0].borderColor = border;
  pieChart.options.plugins.legend.labels.color = document.body.classList.contains('light') ? '#000' : '#fff';
  pieChart.update();
});
obs.observe(document.body, {attributes:true,attributeFilter:['class']});

// ---------- Export CSV ----------
function exportCSV(){ window.location.href="?export=csv"; }

// ---------- Export PDF avec logo et nom site ----------
function exportPDF(){
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({orientation:'landscape'});
  const isLight = document.body.classList.contains('light');
  const headColor = isLight ? [26,188,156] : [26,188,156];
  const textColor = isLight ? [0,0,0] : [255,255,255];
  const fillColorRow = isLight ? [245,245,245] : [34,34,34];

  const img = new Image();
  img.src = 'image.jpg';
  img.onload = function(){
    const imgWidth = 30;
    const imgHeight = 30 * (img.height/img.width);
    doc.addImage(img, 'JPEG', 14, 10, imgWidth, imgHeight);

    doc.setFontSize(18);
    doc.setTextColor(...textColor);
    doc.setFont("helvetica","bold");
    doc.text("Athar_brnv", 14 + imgWidth + 8, 28);

    doc.setDrawColor(...headColor);
    doc.setLineWidth(1.2);
    doc.line(14, 45, doc.internal.pageSize.getWidth() - 14, 45);

    doc.autoTable({
      html: '#ordersTable',
      startY: 50,
      headStyles: {fillColor: headColor, textColor: [255,255,255]},
      alternateRowStyles: {fillColor: fillColorRow, textColor: textColor},
      styles: {fontSize:9, cellPadding:3},
      theme: 'striped'
    });

    doc.setFontSize(8);
    const date = new Date().toLocaleString();
    doc.setTextColor(150);
    doc.text("Exporté le: " + date, doc.internal.pageSize.getWidth() - 60, doc.internal.pageSize.getHeight() - 6);

    doc.save("commandes.pdf");
  }
}
</script>

</body>
</html>
