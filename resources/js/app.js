var modal = document.querySelector('.modal');
var params = window.location.search;
var sIdCookie = getCookie('sid');
var sIdCookieDate = parseInt(getCookie('sDate'));

if(sIdCookie && sIdCookieDate){
	var currentDate = new Date().getTime();
	var difference = ((currentDate - sIdCookieDate) / 1000) / 60;
	var minutes = Math.abs(Math.round(difference));;
	
	if(minutes >= 20){
		document.cookie = "sid=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	    document.cookie = "sDate=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	}
}

if(params){
	var urlParams = params.substring(1);
	var paramSplit = urlParams.split('&');
	var totalParams = paramSplit.length;

	if(totalParams){
		for(var x=0;x<totalParams;x++){
			var singleParam = paramSplit[x].split('=');

			if(singleParam[0] === 'sid' || singleParam[0] === 'sourceId'){
				setCookie('sDate',new Date().getTime(),365);
				setCookie('sid',singleParam[1],365);
			}

			if(singleParam[0] === 'promoCode'){
				setCookie('promoCode',singleParam[1],365);
			}
		}
	}
}

var categories = document.querySelectorAll('.custom-filter ul li button');
var totalCategories = categories.length;

if(totalCategories){
	for(var x=0;x<totalCategories;x++){
		categories[x].addEventListener('click',function(e){
			e.preventDefault();

			var id = this.parentNode.getAttribute('data-category');

			if(id){
				var categoryFilter = this.parentNode.parentNode.parentNode;

				categoryFilter.setAttribute('data-category',categoryFilter.getAttribute('data-category') !== id ? id : 0);
			}
		})
	}
}

var qtyBtns = document.querySelectorAll('.quantity-arrow-minus, .quantity-arrow-plus');
var totalQtyBtns = qtyBtns.length;

if(totalQtyBtns){
	for(var x=0;x<totalQtyBtns;x++){
		qtyBtns[x].addEventListener('click',function(){
			var input = this.parentNode.children[1];
			var value = parseInt(input.value);

			if(this.className === 'quantity-arrow-minus'){
				value = value - 1 > 0 ? value - 1 : value;
			}else{
				value++;
			}

			input.value = value;
		});
	}
}

var productSelect = document.querySelector('.custom-select select[name="product-selection"]');

if(productSelect){ 
	productSelect.addEventListener('change',function(){
		var selectedIndex = this.selectedIndex;
		var totalProductEquivalents = productEquivalents.length;

		selectedIndex = selectedIndex - 1;

		if(totalProductEquivalents){
			var selectedProductId = parseInt(this.children[selectedIndex + 1].value);

			for(var x=0;x<totalProductEquivalents;x++){
				if(productEquivalents[x].product_id === selectedProductId){
					var selectedProduct = productEquivalents[x];
				}
			}
		}
		
		if(selectedProduct){
			var productImg = document.querySelector('.product-actions .image-container img');
			var titleBlock = document.querySelector('.title-block');
			var qtyBlock = document.querySelector('.quantity-block');
			var selectBtn = document.querySelector('.product-actions button');
			
			productImg.setAttribute('src','https://cdn.trivita.com/US/EN/images/products/' + selectedProduct['product_id'] + '-lrg.png');
			titleBlock.children[0].innerText = selectedProduct['name'];
			titleBlock.children[1].innerText = selectedProduct.net_price ? '$' + selectedProduct.net_price : '$' + selectedProduct.retail_price;
			qtyBlock.firstElementChild.children[0].innerText = selectedProduct.package;
			qtyBlock.firstElementChild.children[1].innerText = selectedProduct.serving;
			
			if(selectedProduct.stock){
				selectBtn.removeAttribute('disabled');
				selectBtn.removeAttribute('onclick');
			}else{
				selectBtn.setAttribute('disabled',true);
				selectBtn.setAttribute('onclick','addToCart(this,true,true)');
			}

			selectBtn.setAttribute('data-id',selectedProduct.product_id);
			selectBtn.setAttribute('data-product',selectedProduct.name);
			selectBtn.setAttribute('data-price',selectedProduct.net_price ? selectedProduct.net_price : selectedProduct.retail_price);
			selectBtn.innerText = !selectedProduct.stock ? 'Out Of Stock' : 'Add To Cart';
		}
	});
}

var contactBtn = document.querySelector('.contact-btn');

if(contactBtn){
	contactBtn.addEventListener('click',function(e){
		e.preventDefault();

		if(modal){
			modal.style.display = 'table';
			modal.style.opacity = 1;
			modal.style.visibility = 'visible';

			var fields = [{name:'name',type:'input',placeholder:'Name'},{name:'email',type:'input',placeholder:'Email'},{name:'subject',type:'input',placeholder:'Subject'},{name:'message',type:'textarea',placeholder:'Message'}];
			var totalFields = fields.length;
			var title = document.createElement('strong');
			var form = document.createElement('form');
			var close = document.createElement('i');

			for(var x=0;x<totalFields;x++){
				var fieldset = document.createElement('fieldset');
				var input = document.createElement(fields[x].type);
				
				if(fields[x].type === 'input'){
					input.setAttribute('type',fields[x].name === 'email' ? 'email' : 'text');
				}

				input.setAttribute('name',fields[x].name);
				input.setAttribute('placeholder',fields[x].placeholder);
				input.setAttribute('required','true');
				fieldset.appendChild(input);
				form.appendChild(fieldset);
			}

			var fieldset = document.createElement('fieldset');
			var cancel = document.createElement('input');
			var token = document.createElement('input');
			var submit = document.createElement('button');

			close.addEventListener('click',function(){
				var modalNode = this.parentNode.parentNode.parentNode;
				
				modalNode.removeAttribute('style');
				modalNode.firstElementChild.className = 'row';

				if(modalNode.firstElementChild.firstElementChild.lastElementChild){
				    while(modalNode.firstElementChild.firstElementChild.lastElementChild){
				       	modalNode.firstElementChild.firstElementChild.removeChild(modalNode.firstElementChild.firstElementChild.lastElementChild);
				       }
				}
			});
			cancel.addEventListener('click',function(){
				this.parentNode.parentNode.parentNode.firstElementChild.click();
			});
			
			token.setAttribute('name','_token');
			token.setAttribute('type','hidden');
			token.setAttribute('value',document.querySelector('meta[name="csrf-token"]').content);
			form.setAttribute('method','POST');
			form.setAttribute('action',document.location.href);
			form.setAttribute('onsubmit','return validateForm(this)');
			form.setAttribute('novalidate','true');
			cancel.setAttribute('type','button');
			cancel.setAttribute('value','Cancel');
			submit.innerText = 'Submit';
			title.innerText = 'Send a Message';
			close.className = 'fa fa-times';
			fieldset.appendChild(cancel);
			fieldset.appendChild(submit);
			fieldset.appendChild(token);
			form.appendChild(fieldset);
			modal.lastElementChild.lastElementChild.appendChild(close);
			modal.lastElementChild.lastElementChild.appendChild(title);
			modal.lastElementChild.lastElementChild.appendChild(form);
			modal.lastElementChild.className += ' modal-contact';
		}
	});
}

var accordion = document.querySelectorAll('.acc .acc-title');
var totalAccordions = accordion.length;

if(totalAccordions){
	for(var x=0;x<totalAccordions;x++){
		accordion[x].addEventListener('click',function(e){
			e.preventDefault();

			this.className = this.className.indexOf('active') === -1 ? this.className + ' active' : this.className.replace(' active','');
		});
	};
}

var feedItems = document.querySelectorAll('.widget .feed-container article');
var totalFeedItems = feedItems.length;

if(totalFeedItems){
	for(var x=0;x<totalFeedItems;x++){
		var sideContent = feedItems[x].querySelector('.widget p.content');
		
		if(sideContent){
			var contentParse = JSON.parse(sideContent.innerText);
			var totalContentParse = contentParse.length;

			sideContent.innerText = '';
			
			for(var y=0;y<totalContentParse;y++){
				sideContent.innerText += String.fromCodePoint(contentParse[y]);
			}
		}	
	}

	setTimeout(function(){
		var maxHeight = feedItems[0].parentNode.offsetHeight;
		
		feedItems[0].parentNode.style.maxHeight = maxHeight + 'px';
		feedItems[0].parentNode.className += ' scroll';
	},500);
}

var sideContent = document.querySelectorAll('.widget p.content');
var totalSideContent = sideContent.length;

if(totalSideContent){
	for(var x=0;x<totalSideContent;x++){
		try{
			var contentParse = JSON.parse(sideContent[x].innerText);
			var totalContentParse = contentParse.length;

			sideContent[x].innerText = '';
			
			for(var y=0;y<totalContentParse;y++){
				sideContent[x].innerText += String.fromCodePoint(contentParse[y]);
			}

		}catch(e){
			
		}

		sideContent[x].style.display = 'block';
	};
}

function validateForm(_form){
	var fields = _form.querySelectorAll('input,textarea');
	var totalFields = fields.length;
	var validFields = true;

	if(totalFields){
		for(var x=0;x<totalFields;x++){
			var valid = fields[x].validity.valid;
			
			fields[x].className = valid ? '' : 'invalid';

			if(!valid && validFields){
				validFields = false;
			}
		}
	}

	if(validFields){
		var btn = _form.querySelector('button');
		var btnText = btn.innerText;
		var formData = new FormData(_form);
        var xhttp = new XMLHttpRequest();

        btn.disabled = true;
        btn.innerText = 'Please wait...';

        xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4){
                if(xhttp.status === 200){
                    try{
                        var response = JSON.parse(xhttp.response)
                    }catch(e){
                        var response = xhttp.response; 
                    }
                    
                    if(response.success){
                    	btn.innerText = 'Thank you!';
                    }else{
                    	alert(response.error ? response.error : 'There was an error, please contact us!');

                    	btn.removeAttribute('disabled');
        				btn.innerText = btnText;
                    }
                }else{
                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                }
            }
        };
                                          
        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
        xhttp.send(formData);
	}

	return false;
}

function addToCart(_element){
	var qtyInput = _element.parentNode.parentNode.querySelector('input[name="quantity"]');
	var qty = qtyInput && qtyInput.value ? parseInt(qtyInput.value) : 1;
	var price = _element.getAttribute('data-price') ? parseFloat(_element.getAttribute('data-price').replace('$','')) : parseFloat(_element.getAttribute('data-price').replace('$',''));
	
	if(qty > 0){
		var cartItems = getCookie('cartItems');
		var cartTotals = getCookie('cartTotals');
		var priceTotals = parseFloat(getCookie('priceTotals'));
		var id = parseInt(_element.getAttribute('data-id'));

		if(cartItems){
			var updatedCartItems = '';
			var cartItemsSplit = cartItems.split(',');
			var totalCartItems = cartItemsSplit.length;
			var inCart = false;
			
			if(totalCartItems){
				for(var x=0;x<totalCartItems;x++){
					var cartItemData = cartItemsSplit[x].split('|');
					
					if(cartItemData.length === 2){
						
						if(parseInt(cartItemData[0]) === id){
							updatedCartItems += cartItemData[0] + '|' + (parseInt(cartItemData[1]) + qty) + ',';
							inCart = true;
						}else{
							updatedCartItems += cartItemsSplit[x] + ',';
						}
					}
				}
			}
		}

		if(!cartItems){
			cartItems = id + '|' + qty + ',';
		}else if(cartItems && !inCart){
			updatedCartItems += id + '|' + qty + ',';
		}

		priceTotals = priceTotals ? priceTotals + (price * qty) : (price * qty); 
		
		setCookie('cartItems',updatedCartItems ? updatedCartItems : cartItems,30);
		setCookie('priceTotals',priceTotals,30);

		if(modal){
			var modalHeader = document.createElement('div');
			var modalHeaderTitle = document.createElement('strong');
			var modalHeaderIcon = document.createElement('i');
			var modalDetails = document.createElement('div');
			var modalDetailsTitle = document.createElement('p');
			var modalDetailsQty = document.createElement('span');
			var modalDetailsPrice = document.createElement('span');
			var modalLinks = document.createElement('div');
			var modalLinkContinue = document.createElement('button');
			var modalLinkText = document.createElement('p');
			var modalLinkCart = document.createElement('a');

			modalDetails.className = 'cart-details';
			modalDetailsTitle.innerHTML = _element.getAttribute('data-product') + ' to your shopping cart!';
			modalDetailsQty.innerText = 'Qty: ' + qty;
			modalDetailsPrice.innerText = '$' + (price * qty);
			modalDetails.appendChild(modalDetailsTitle);
			modalDetails.appendChild(modalDetailsQty);
			modalDetails.appendChild(modalDetailsPrice);
			modalHeader.className = 'cart-header';
			modalHeaderTitle.innerText = 'You\'ve Added';
			modalHeaderIcon.className = 'fa fa-times';
			modalHeader.appendChild(modalHeaderTitle);
			modalHeader.appendChild(modalHeaderIcon);
			modalLinks.className = 'cart-links';
			modalLinkContinue.innerText = 'Continue Shopping';
			modalHeaderIcon.addEventListener('click',function(e){
				e.preventDefault();

				var modalNode = this.parentNode.parentNode.parentNode.parentNode;

				modalNode.removeAttribute('style');

		        modalNode.firstElementChild.className = 'row';

		        if(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       		while(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       			modalNode.firstElementChild.firstElementChild.removeChild(modalNode.firstElementChild.firstElementChild.lastElementChild);
		       		}
		       	}
			});
			modalLinkContinue.addEventListener('click',function(e){
				e.preventDefault();

				var modalNode = this.parentNode.parentNode.parentNode.parentNode;

				modalNode.removeAttribute('style');

		        modalNode.firstElementChild.className = 'row';

		        if(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       		while(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       			modalNode.firstElementChild.firstElementChild.removeChild(modalNode.firstElementChild.firstElementChild.lastElementChild);
		       		}
		       	}
			});
			modalLinkText.innerText = '‐ or ‐';
			modalLinkCart.innerText = 'View Cart';
			modalLinkCart.addEventListener('click',function(e){
				e.preventDefault();

				redirectToCart();
			});
			modalLinks.appendChild(modalLinkContinue);
			modalLinks.appendChild(modalLinkText);
			modalLinks.appendChild(modalLinkCart);
			modal.firstElementChild.firstElementChild.appendChild(modalHeader);
			modal.firstElementChild.firstElementChild.appendChild(modalDetails);
			modal.firstElementChild.firstElementChild.appendChild(modalLinks);
			modal.firstElementChild.className += ' modal-cart';
			modal.style.display = 'table';
			modal.style.opacity = 1;
			modal.style.visibility = 'visible';
		}
	}else if(qty <= 0 ){
		alert('Please select a quantity greater than or equal to 1.');
	}

	return false;
}


function redirectToCart(_params = null){
	var cartPrefix = 'https://cart.trivita.com';
	var cartItems = getCookie('cartItems');
	var sId = getCookie('sid');
	var itbdoId = getCookie('itbdo');
	var promoCode = getCookie('promoCode');
	
	//expire/delete cookie
	var date = new Date();
    date.setTime(date.getTime() - (1000*60*60*24));
    var expires = " expires=" + date.toGMTString() + ';';

    //redirect url
    var url = sId ? cartPrefix + '/?dsCart=false&prodList='+cartItems+'&siteId=4&countryId='+countryId+'&sourceId='+sId : cartPrefix + '/?dsCart=false&prodList='+cartItems+'&siteId=4&countryId=1&sourceId=0';

    if(itbdoId){
    	url += '&tref=' + itbdoId;
    }

    if(promoCode){
    	url += '&promoCode=' + promoCode;
    }

    if(_params){
    	url += _params;
    }
    
    document.cookie = 'cartItems=;'+expires+';path=/';
    document.cookie = 'priceTotals=;'+expires+';path=/';
    document.cookie = 'promoCode=;'+expires+';path=/';
    document.location.href = url;
}

function viewInfo(_element){
	var imageUrl = _element.getAttribute('data-url');

	if(imageUrl){
		var imageNode = document.createElement('img');
		var icon = document.createElement('i');

		imageNode.setAttribute('src',imageUrl);
		icon.className = 'fa fa-times';
		icon.addEventListener('click',function(e){
			e.preventDefault();

			var modalNode = this.parentNode.parentNode.parentNode;

			modalNode.removeAttribute('style');
		   	modalNode.firstElementChild.className = 'modal-row';

		    if(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       	while(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       		modalNode.firstElementChild.firstElementChild.removeChild(modalNode.firstElementChild.firstElementChild.lastElementChild);
		       	}
		    }
		});
		modal.firstElementChild.firstElementChild.appendChild(imageNode);
		modal.firstElementChild.firstElementChild.appendChild(icon);
		modal.firstElementChild.className += ' product-info';
		modal.style.display = 'table';
		modal.style.opacity = 1;
		modal.style.visibility = 'visible';
	}

	return false;
}

function displaySealInfo(_element){
	var imagenode = _element.cloneNode();
	var title = _element.previousElementSibling.getAttribute('alt');
	var definition = _element.nextElementSibling.innerHTML;
	var closeIcon = document.createElement('i');

	closeIcon.className = 'fa fa-times';
	modal.firstElementChild.firstElementChild.appendChild(closeIcon);

	closeIcon.addEventListener('click',function(){
		var modalNode = this.parentNode.parentNode.parentNode;

		modalNode.removeAttribute('style');
		modalNode.firstElementChild.className = 'modal-row';

		if(modalNode.firstElementChild.firstElementChild.lastElementChild){
		    while(modalNode.firstElementChild.firstElementChild.lastElementChild){
		       	modalNode.firstElementChild.firstElementChild.removeChild(modalNode.firstElementChild.firstElementChild.lastElementChild);
		       }
		}
	});

	if(title){
		var paragraphNode = document.createElement('p');
		
		paragraphNode.innerHTML = '<strong>'+title+'</strong>';
		modal.firstElementChild.firstElementChild.appendChild(paragraphNode);
	}

	if(definition){
		var definitionNode = document.createElement('p');

		definitionNode.innerHTML = definition;
		modal.firstElementChild.firstElementChild.appendChild(definitionNode);
	}

	modal.firstElementChild.className += ' body-system';
	modal.style.display = 'table';
	modal.style.opacity = 1;
	modal.style.visibility = 'visible';

	return false
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$('.testimonial-slider').slick({
	autoplay: false,
	dots: false,
	infinite: true,
	speed: 300,
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: true,
});