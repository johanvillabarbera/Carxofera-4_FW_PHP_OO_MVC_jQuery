function add_cart(){
    var id_car = $('.button').attr("id");
    var qty = $("#" + id_car + ".quantity-field-details").val();
    if(!localStorage.getItem('token')){
        toastr.warning("Debes de iniciar sesion");
        setTimeout(' window.location.href = "?module=login"; ', 1000);
    }else{
        if(qty == 0){
            toastr.warning("Inténtelo de nuevo");
        }else{
            ajaxPromise(friendlyURL("?module=cart&op=insert_cart"), 'POST', 'JSON', { 'token': localStorage.getItem('token'), 'id': id_car, 'qty': qty })
            .then(function(data) { 
                load_cart();
                toastr.success("Se ha añadido al carrito");
            }).catch(function() {
                console.log('Fail add cart');
            });   
        }
    }
}

function clicks_cart(){
    $(document).on('click','.img-details-cart',function () {
        localStorage.removeItem('filter_motor_type');
        localStorage.removeItem('filter_category');
        localStorage.removeItem('filter_brand');
        localStorage.removeItem('filter_color');
        localStorage.removeItem('filter_search');
        localStorage.removeItem('previous_filter_line');
        localStorage.removeItem('filter_home_brand');
        localStorage.removeItem('filter_home_cat');
        localStorage.removeItem('filter_home_tmotor');
        localStorage.removeItem('filter');
        var id_car = this.getAttribute('id');
        localStorage.setItem('details_visits', id_car); 
        window.location.href = 'index.php?page=controller_shop&op=list';  
    });

    $(document).on('click','.button_remove_cart',function () {
        var id_car = this.getAttribute('id');
        ajaxPromise(friendlyURL("?module=cart&op=delete_cart"), 'POST', 'JSON', { 'token': localStorage.getItem('token'), 'id': id_car })
        .then(function(data) { 
            load_cart();
        }).catch(function() {
            console.log('Fail remove cart');
        });   
    });

    $(document).on('click','.cart-qty-plus',function () {
        var id_car =  this.getAttribute('id');
        
        ajaxPromise(friendlyURL("?module=cart&op=check_stock"), 'POST', 'JSON', { 'id': id_car })
        .then(function(data) { 
            if(parseInt($("#" + id_car + ".quantity-field").val()) == data[0].stock){
                toastr.warning("No hay más stock para este producto");
            }else{
                $("#" + id_car + ".quantity-field").val(parseInt($("#" + id_car + ".quantity-field").val()) + 1);
                var qty = $("#" + id_car + ".quantity-field").val();
                update_qty(id_car, qty);
            }
        }).catch(function() {
            console.log('Fail check stock');
        });  
    });

    $(document).on('click','.cart-qty-minus',function () {
        var id_car =  this.getAttribute('id');
        
        if($("#" + id_car + ".quantity-field").val() != 1){
            $("#" + id_car + ".quantity-field").val(parseInt($("#" + id_car + ".quantity-field").val()) - 1);
            var qty = $("#" + id_car + ".quantity-field").val();
            update_qty(id_car, qty);
        }
    });

    $(document).on('click','.details-qty-plus',function () {
        var id_car =  this.getAttribute('id');
        
        if(!localStorage.getItem('token')){
            toastr.warning("Debes de iniciar sesion");
            setTimeout(' window.location.href = "?module=login"; ', 1000);
        }else{
            ajaxPromise(friendlyURL("?module=cart&op=check_stock_details"), 'POST', 'JSON', { 'token': localStorage.getItem('token'), 'id': id_car })
            .then(function(data) { 
                if(parseInt($("#" + id_car + ".quantity-field-details").val()) == data[0].stock){
                    toastr.warning("No hay más stock para este producto");
                }else{
                    $("#" + id_car + ".quantity-field-details").val(parseInt($("#" + id_car + ".quantity-field-details").val()) + 1);
                    var qty = $("#" + id_car + ".quantity-field-details").val();
                }
            }).catch(function() {
                console.log('Fail check stock details');
            });  
        }
    });

    $(document).on('click','.details-qty-minus',function () {
        var id_car =  this.getAttribute('id');

        if(!localStorage.getItem('token')){
            toastr.warning("Debes de iniciar sesion");
            setTimeout(' window.location.href = "?module=login"; ', 1000);
        }else{
            if($("#" + id_car + ".quantity-field-details").val() != 0){
                $("#" + id_car + ".quantity-field-details").val(parseInt($("#" + id_car + ".quantity-field-details").val()) - 1);
                var qty = $("#" + id_car + ".quantity-field-details").val();
            }
        }
    });

    $(document).on('click','.checkout-cta',function () {
        ajaxPromise(friendlyURL("?module=cart&op=checkout"), 'POST', 'JSON', { 'token': localStorage.getItem('token') })
        .then(function(data) { 
            if(data != "error"){
                toastr.success("Pedido realizado correctamente");
                setTimeout(' window.location.href = "?module=home"; ', 1000);
            }else{
                toastr.warning("No se ha podido realizar el pedido");
            }
            
        }).catch(function() {
            console.log('Fail checkout');
        });   
    });
}

function load_cart(){
    $('#cart-body').empty();
    $('#cart-foot').empty();
    $('.cart-count').empty();

    ajaxPromise(friendlyURL("?module=cart&op=load_cart"), 'POST', 'JSON', { 'token': localStorage.getItem('token') })
    .then(function(data) { 
        if(data != "error"){
            var total_price = 0;
            for (row in data) {
                $('<tr></tr>').appendTo('#cart-body')
                    .html(
                        "<td>" + 
                        "<div class='product-img'>" + 
                        "<div class='img-prdct'><img style='cursor:pointer;' class='img-details-cart' id='" + data[row].id_car + "' src='" + data[row].name_img + "'></div>" + 
                        "</div>" + 
                        "</td>" + 
                        "<td>" + 
                        "<p>" + data[row].name_brand + " " + data[row].name_model + "</p>" +
                        "</td>" + 
                        "<td>" + 
                        "<div class='button-container'>" + 
                        "<button id='"+ data[row].id_car +"' class='cart-qty-minus' type='button' value='-'>-</button>" + 
                        "<input type='number' name='qty' min='1' id='"+ data[row].id_car +"' class='quantity-field form-control' disabled value='" + data[row].cantidad + "'/>" + 
                        "<button id='"+ data[row].id_car +"' class='cart-qty-plus' type='button' value='+'>+</button>" + 
                        "</div>" + 
                        "</td>" + 
                        "<td>" + 
                        "<input type='text' value='" + data[row].price + "' class='price form-control' disabled>" +
                        "</td>" + 
                        "<td>" + 
                        "<button class='button_remove_cart' id='"+ data[row].id_car +"' type='button' value='Eliminar'>Eliminar</button>" + 
                        "</td>" + 
                        "<td align='right'><span id='amount' class='amount'>" + data[row].price*data[row].cantidad + " €</span></td>"
                    );
                total_price = total_price + (data[row].price*data[row].cantidad);
            }
            $('<tr></tr>').appendTo('#cart-foot')
                .html(
                    "<td colspan='4'></td><td align='right'><strong>TOTAL = " + total_price + " €  <span id='total' class='total'></span></strong></td>"
                );
            $('<span class="cart-count"></span>').appendTo('.cart').html(data.length);
        }
    }).catch(function() {
        console.log('Fail load cart');
    });   
}

function update_qty(id_car, qty){
    ajaxPromise(friendlyURL("?module=cart&op=update_qty"), 'POST', 'JSON', { 'token': localStorage.getItem('token'), 'id': id_car, 'qty': qty })
    .then(function() { 
        load_cart();
    }).catch(function() {
        console.log('Fail change qty');
    });   
}

$(document).ready(function(){
    clicks_cart();
    load_cart();
});