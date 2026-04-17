<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ATHAR_BRN Shop</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
:root{
  --main:#111;
  --bg:#f4f4f4;
  --card:#fff;
  --text:#111;
  --radius:18px;
}

body.dark{
  --main:#fff;
  --bg:#111;
  --card:#1e1e1e;
  --text:#fff;
}

*{
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

body{
  margin:0;
  background:var(--bg);
  color:var(--text);
  transition:.3s;
}

/* HEADER */
header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:20px 30px;
}

.logo{
  display:flex;
  align-items:center;
  gap:10px;
}

.logo img{
  width:45px;
  border-radius:50%;
}

.controls{
  display:flex;
  gap:10px;
}

select,button{
  padding:8px 12px;
  border-radius:20px;
  border:1px solid #ccc;
  cursor:pointer;
}

/* LAYOUT */
.container{
  max-width:1200px;
  margin:auto;
  padding:20px;
}

h1,h2{
  text-align:center;
}

/* PRODUCTS */
.products{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:25px;
}

.product{
  background:var(--card);
  padding:20px;
  border-radius:var(--radius);
  text-align:center;
  box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.product img{
  width:70%;
  border-radius:14px;
}

.product button{
  margin-top:10px;
  padding:12px 20px;
  border:none;
  border-radius:30px;
  background:var(--main);
  color:var(--bg);
}

/* CART */
.cart{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:25px;
  margin-top:40px;
}

@media(max-width:900px){
  .cart{grid-template-columns:1fr;}
}

.cart-item{
  background:var(--card);
  padding:15px;
  border-radius:var(--radius);
  display:flex;
  gap:15px;
  align-items:center;
  margin-bottom:15px;
}

.cart-item img{
  width:70px;
  border-radius:12px;
}

.cart-item input{
  width:55px;
  padding:6px;
  border-radius:10px;
}

.remove{
  background:none;
  border:none;
  font-size:18px;
  cursor:pointer;
}

/* SUMMARY */
.summary{
  background:var(--card);
  padding:25px;
  border-radius:var(--radius);
}

.summary input, .summary button{
  width:100%;
  padding:12px;
  margin-bottom:10px;
  border-radius:14px;
}
</style>
</head>

<body>

<header>
  <div class="logo">
    <img src="image.jpg" alt="logo">
    <h1 id="logo-text">ATHAR_BRN</h1>
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
</header>

<div class="container">

<h2 id="collection-title">Nos produits</h2>

<div class="products">
  <div class="product">
    <img src="sweatshirt.jpg">
    <h4 id="item1">Camiseta ITR Classic</h4>
    <p>250 MAD</p>
    <button onclick="addToCart(1)" id="btn1">Ajouter au panier</button>
  </div>

  <div class="product">
    <img src="hoodie.jpg">
    <h4 id="item2">Sudadera Urban</h4>
    <p>350 MAD</p>
    <button onclick="addToCart(2)" id="btn2">Ajouter au panier</button>
  </div>
</div>

<h2 id="checkout-title">إتمام الطلب</h2>

<div class="cart">
  <div id="cartItems"></div>

  <div class="summary">
    <p><strong id="total-text">Total</strong> <span id="total">0 MAD</span></p>
    <input type="text" placeholder="Nom complet">
    <input type="tel" placeholder="Téléphone">
    <input type="text" placeholder="Ville">
    <input type="text" placeholder="Adresse">
    <button onclick="confirmOrder()" id="confirm-btn">Confirmer</button>
  </div>
</div>

</div>

<script>
// PRODUCTS
const products=[
  {id:1,name:"ITR Classic",price:250,img:"https://via.placeholder.com/150"},
  {id:2,name:"Urban Hoodie",price:350,img:"https://via.placeholder.com/150"}
];

let cart=JSON.parse(localStorage.getItem("cart"))||[];

// CART FUNCTIONS
function addToCart(id){
  const p=products.find(x=>x.id===id);
  const i=cart.find(x=>x.id===id);
  i?i.qty++:cart.push({...p,qty:1});
  save();
}

function save(){
  localStorage.setItem("cart",JSON.stringify(cart));
  render();
}

function render(){
  const box=document.getElementById("cartItems");
  const totalEl=document.getElementById("total");
  box.innerHTML="";
  let total=0;

  cart.forEach((item,i)=>{
    total+=item.price*item.qty;
    box.innerHTML+=`
      <div class="cart-item">
        <img src="${item.img}">
        <div style="flex:1">${item.name}<br>${item.price} MAD</div>
        <input type="number" min="1" value="${item.qty}"
          onchange="cart[${i}].qty=this.value;save()">
        <button class="remove" onclick="cart.splice(${i},1);save()">✕</button>
      </div>`;
  });
  totalEl.textContent=total+" MAD";
}

function confirmOrder(){
  alert("✅ Commande confirmée !");
  cart=[];
  save();
}

// DARK MODE
const toggle=document.getElementById("dark-toggle");
toggle.onclick=()=>{
  document.body.classList.toggle("dark");
  localStorage.setItem("theme",document.body.classList.contains("dark")?"dark":"light");
  toggle.textContent=document.body.classList.contains("dark")?"☀️":"🌙";
};
if(localStorage.getItem("theme")==="dark"){
  document.body.classList.add("dark");
  toggle.textContent="☀️";
}

// LANGUAGES
const texts={
fr:{collection:"Nos produits",checkout:"Finaliser la commande",btn:"Ajouter au panier",confirm:"Confirmer"},
es:{collection:"Productos",checkout:"Finalizar pedido",btn:"Añadir al carrito",confirm:"Confirmar"},
ar:{collection:"منتجاتنا",checkout:"إتمام الطلب",btn:"أضف إلى السلة",confirm:"تأكيد"},
de:{collection:"Produkte",checkout:"Bestellung abschließen",btn:"In den Warenkorb",confirm:"Bestätigen"},
en:{collection:"Products",checkout:"Checkout",btn:"Add to cart",confirm:"Confirm"}
};

function setLang(l){
  document.getElementById("collection-title").textContent=texts[l].collection;
  document.getElementById("checkout-title").textContent=texts[l].checkout;
  document.getElementById("btn1").textContent=texts[l].btn;
  document.getElementById("btn2").textContent=texts[l].btn;
  document.getElementById("confirm-btn").textContent=texts[l].confirm;
  localStorage.setItem("lang",l);
}

const lang=document.getElementById("lang");
setLang(localStorage.getItem("lang")||"fr");
lang.value=localStorage.getItem("lang")||"fr";
lang.onchange=e=>setLang(e.target.value);

render();
</script>

</body>
</html>
