
let cart ={};
jQuery(document).on("click", "a.add-to-cart", function() {
 
  console.log("process shopping cart");
  
  let product = jQuery(this).closest(".product");
  let name = product.data("name");
  let price = product.data("price");
  
  //Add or updata item
  if(!cart[name]){
	  cart[name] = {price: price, qty:1}
  } else{
	  cart[name].qty++; 
  }
  
  renderCart();
});

function renderCart(){
	let total = 0;
	let html ="";
	jQuery.each(cart, function(name,item){
		let itemTotal = item.price * item.qty;
		total += itemTotal;
		
	html += `<li>
        ${name} x ${item.qty} = £${itemTotal.toFixed(2)}
      </li>`;
    });
	jQuery('#cart-items').html(html);
	jQuery('#cart-total').text(total.toFixed(2));
}