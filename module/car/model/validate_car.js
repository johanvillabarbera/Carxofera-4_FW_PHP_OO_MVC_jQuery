function validate_license_number(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_brand(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_model(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_car_plate(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_km(texto){
    if (texto.length > 0){
        var reg=/^[0-9]+$/;
        return reg.test(texto);
    }
    return false;
}

function validate_category(texto){
    var i;
    var ok=0;
    for(i=0; i<texto.length;i++){
        if(texto[i].checked){
            ok=1
        }
    }
 
    if(ok==1){
        return true;
    }
    if(ok==0){
        return false;
    }
}

function validate_type(array){
    var i;
    var ok=0;
    for(i=0; i<array.length;i++){
        if(array[i].checked){
            ok=1
        }
    }
 
    if(ok==1){
        return true;
    }
    if(ok==0){
        return false;
    }
}

function validate_comments(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_discharge_date(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_color(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_extras(array){
    var check=false;
    for ( var i = 0, l = array.options.length, o; i < l; i++ ){
        o = array.options[i];
        if ( o.selected ){
            check= true;
        }
    }
    return check;
}

function validate_car_image(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_price(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_doors(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_city(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_lat(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate_lng(texto){
    if (texto.length > 0){
        return true;
    }
    return false;
}

function validate(op){
    // console.log('hola validate js');
    // return true;

    var check=true;
    var v_license_number=document.getElementById('license_number').value;
    var v_brand=document.getElementById('brand').value;
    var v_model=document.getElementById('model').value;
    var v_car_plate=document.getElementById('car_plate').value;
    var v_km=document.getElementById('km').value;
    var v_category=document.getElementsByName('category');
    var v_type=document.getElementsByName('type[]');
    var v_comments=document.getElementById('comments').value;
    var v_discharge_date=document.getElementById('discharge_date').value;
    var v_color=document.getElementById('color').value;
    var v_extras=document.getElementById('extras[]');
    var v_car_image=document.getElementById('car_image').value;
    var v_price=document.getElementById('price').value;
    var v_doors=document.getElementById('doors').value;
    var v_city=document.getElementById('city').value;
    var v_lat=document.getElementById('lat').value;
    var v_lng=document.getElementById('lng').value;

    var r_license_number=validate_license_number(v_license_number);
    var r_brand=validate_brand(v_brand);
    var r_model=validate_model(v_model);
    var r_car_plate=validate_car_plate(v_car_plate);
    var r_km=validate_km(v_km);
    var r_category=validate_category(v_category);
    var r_type=validate_type(v_type);
    var r_comments=validate_comments(v_comments);
    var r_discharge_date=validate_discharge_date(v_discharge_date);
    var r_color=validate_color(v_color);
    var r_extras=validate_extras(v_extras);
    var r_car_image=validate_car_image(v_car_image);
    var r_price=validate_price(v_price);
    var r_doors=validate_doors(v_doors);
    var r_city=validate_city(v_city);
    var r_lat=validate_lat(v_lat);
    var r_lng=validate_lng(v_lng);
    
    if(!r_license_number){
        document.getElementById('error_license_number').innerHTML = " * El número de licencia introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_license_number').innerHTML = "";
    }
    if(!r_brand){
        document.getElementById('error_brand').innerHTML = " * La marca introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_brand').innerHTML = "";
    }
    if(!r_model){
        document.getElementById('error_model').innerHTML = " * El modelo introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_model').innerHTML = "";
    }
    if(!r_car_plate){
        document.getElementById('error_car_plate').innerHTML = " * La placa introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_car_plate').innerHTML = "";
    }
    if(!r_km){
        document.getElementById('error_km').innerHTML = " * Los kilómetros introducidos no son validos. Debe introducir un valor numérico";
        check=false;
    }else{
        document.getElementById('error_km').innerHTML = "";
    }
    if(!r_category){
        document.getElementById('error_category').innerHTML = " * No has seleccionado ninguna categoría";
        check=false;
    }else{
        document.getElementById('error_category').innerHTML = "";
    }
    if(!r_type){
        document.getElementById('error_type').innerHTML = " * No has seleccionado ningun tipo";
        check=false;
    }else{
        document.getElementById('error_type').innerHTML = "";
    }
    if(!r_comments){
        document.getElementById('error_comments').innerHTML = " * El texto introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_comments').innerHTML = "";
    }
    if(!r_discharge_date){
        document.getElementById('error_discharge_date').innerHTML = " * La fecha introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_discharge_date').innerHTML = "";
    }
    if(!r_color){
        document.getElementById('error_color').innerHTML = " * El color introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_color').innerHTML = "";
    }
    if(!r_extras){
        document.getElementById('error_extras').innerHTML = " * No has seleccionado ninguno de los extras";
        check=false;
    }else{
        document.getElementById('error_extras').innerHTML = "";
    }
    if(!r_car_image){
        document.getElementById('error_car_image').innerHTML = " * El formato introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_car_image').innerHTML = "";
    }
    if(!r_price){
        document.getElementById('error_price').innerHTML = " * El precio introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_price').innerHTML = "";
    }
    if(!r_doors){
        document.getElementById('error_doors').innerHTML = " * No has seleccionado ninguna opción";
        check=false;
    }else{
        document.getElementById('error_doors').innerHTML = "";
    }
    if(!r_city){
        document.getElementById('error_city').innerHTML = " * La ciudad introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_city').innerHTML = "";
    }
    if(!r_lat){
        document.getElementById('error_lat').innerHTML = " * El lat introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_lat').innerHTML = "";
    }
    if(!r_lng){
        document.getElementById('error_lng').innerHTML = " * El lng introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_lng').innerHTML = "";
    }
    //return check;

    if (check){
        if (op == 'create'){
            document.getElementById('alta_car').submit();
            document.getElementById('alta_car').action = "index.php?page=controller_car&op=create";
        }
        if (op == 'update'){
            document.getElementById('update_car').submit();
            document.getElementById('update_car').action = "index.php?page=controller_car&op=update";
        }
    }
}

function operations_car(op){
    if (op == 'delete'){
        document.getElementById('delete_car').submit();
        document.getElementById('delete_car').action = "index.php?page=controller_car&op=delete";
    }
    if (op == 'delete_all'){
        document.getElementById('delete_all_car').submit();
        document.getElementById('delete_all_car').action = "index.php?page=controller_car&op=delete_all";
    }
    if (op == 'dummies'){
        document.getElementById('dummies_car').submit();
        document.getElementById('dummies_car').action = "index.php?page=controller_car&op=dummies";
    }
}

function showModal(title_Car, id) {
    $("#details_car").show();
    $("#car_modal").dialog({
        title: title_Car,
        width : 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "explode",
        show: "slide",
        buttons : {
            Update: function() {
                window.location.href = 'index.php?page=controller_car&op=update&id=' + id;
            },
            Delete: function() {
                window.location.href = 'index.php?page=controller_car&op=delete&id=' + id;
            }
        }
    });
}
    
function loadContentModal() {
    $('.read_car').click(function () {
        var id = this.getAttribute('id');
        ajaxPromise('module/car/controller/controller_car.php?op=read_modal&modal=' + id, 'GET', 'JSON')
        .then(function(data) {
            // var data = JSON.parse(data);
            $('<div></div>').attr('id', 'details_car', 'type', 'hidden').appendTo('#car_modal');
            $('<div></div>').attr('id', 'container').appendTo('#details_car');
            $('#container').empty();
            $('<div></div>').attr('id', 'car_content').appendTo('#container');
            $('#car_content').html(function() {
                var content = "";
                for (row in data) {
                    content += '<br><span>' + row + ': <span id =' + row + '>' + data[row] + '</span></span>';
                }
                return content;
            });
                showModal(title_car = data.brand + " " + data.model, data.id);
        })
        .catch(function() {
            window.location.href = 'index.php?page=controller_car&op=503';
        });
    });
}
    
$(document).ready(function() {
    loadContentModal();
});