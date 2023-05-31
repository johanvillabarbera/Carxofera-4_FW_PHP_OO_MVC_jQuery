function ajaxForSearch(url, filter, total_prod = 0, items_page) {
    ajaxPromise(friendlyURL(url), 'POST', 'JSON', { 'filter': filter , 'total_prod': total_prod, 'items_page': items_page})
        .then(function (data) {
            console.log(data);
            $('#content_shop_cars').empty();
            $('.container_details').css({ 'display' : 'none'});
            $('.related_cars_title').css({ 'display' : 'none'});

            //Mejora para que cuando no hayan resultados en los filtros aplicados
            if (data == "error" || data.length == 0) {
                $('<div></div>').appendTo('#content_shop_cars')
                    .html(
                        '<h3>¡No se encuentran resultados con los filtros aplicados!</h3>'
                    )
            } else {
                for (row in data) {
                    $('<div></div>').attr({ 'id': data[row].id_car, 'class': 'col-lg-4 col-md-6 mb-2' }).appendTo('#content_shop_cars')
                        .html(
                            "<div class='rent-item mb-4'>" +
                            "<img class='img-fluid mb-4' src= '" + data[row].name_img + "' alt=''>" +
                            "<h4 class='text-uppercase mb-4'>" + data[row].name_brand + " " + data[row].name_model + "</h4>" +
                            "<div class='d-flex justify-content-center mb-4'>" +
                            "<div class='px-2'>" +
                            "<i class='fa fa-eur text-primary mr-1'></i>" +
                            "<span>" + data[row].price + "</span>" +
                            "</div>" +
                            "<div class='px-2 border-left border-right'>" +
                            "<i class='fa fa-cogs text-primary mr-1'></i>" +
                            "<span>" + data[row].name_tmotor + "</span>" +
                            "</div>" +
                            "<div class='px-2'>" +
                            "<i class='fa fa-road text-primary mr-1'></i>" +
                            "<span>" + data[row].km + "</span>" +
                            "</div>" +
                            "</div>" +
                            "<div class='d-flex justify-content-center mb-4'>" +
                            "<div class='px-2'>" +
                            "<a class='btn btn-primary px-3 more_info_list button add' id='" + data[row].id_car + "'>Más info</a>" +
                            "</div>" +
                            "<div class='px-2'>" +
                            "<h2><b><a class='list__heart' id='" + data[row].id_car + "'><i id= " + data[row].id_car + " class='fa-regular fa-heart fa-lg'></i></a>" + "</b></h2>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        )
                }
                load_likes_user();
            }
        mapBox_all(data);
        }).catch(function (e) {
            console.log('Fail ajaxForSearch');
            $("#containerShop").empty();
            $('<div></div>').appendTo('#containerShop').html('<h1>No hay coches con estos filtros</h1>');
        });
}//end_ajaxForSearch

function shopAll(total_prod = 0, items_page = 3) {
    var filter_home_brand = JSON.parse(localStorage.getItem('filter_home_brand'));
    var filter_home_cat = JSON.parse(localStorage.getItem('filter_home_cat'));
    var filter_home_tmotor = JSON.parse(localStorage.getItem('filter_home_tmotor'));
    var filter_search = JSON.parse(localStorage.getItem('filter_search'));
    var previous_filter_line = JSON.parse(localStorage.getItem('previous_filter_line'));
    var filter = JSON.parse(localStorage.getItem('filter'));
    var details_visits = localStorage.getItem('details_visits');
    var redirect_like = localStorage.getItem('redirect_like');

    if (filter_home_brand) {
        ajaxForSearch("?module=shop&op=filters", filter_home_brand, total_prod, items_page);
    }else if (filter_home_cat) {
        ajaxForSearch("?module=shop&op=filters", filter_home_cat, total_prod, items_page);
    }else if (filter_home_tmotor) {
        ajaxForSearch("?module=shop&op=filters", filter_home_tmotor, total_prod, items_page);
    }else if (filter_search) {
        ajaxForSearch("?module=shop&op=filters_search", filter_search, total_prod, items_page);
    }else if (previous_filter_line) {
        ajaxForSearch("?module=shop&op=filters", previous_filter_line, total_prod, items_page);
    }else if (filter) {
        ajaxForSearch("?module=shop&op=filters", filter, total_prod, items_page);
    }else if (redirect_like) {
        var redirect = localStorage.getItem('redirect_like').split(",");
        localStorage.removeItem('redirect_like');
        details(redirect[0]);
        setTimeout(click_like(redirect[0], redirect[1]), 1000);
        // location.reload();
    }else if (details_visits) {
        localStorage.removeItem('details_visits');
        // location.reload();
        details(details_visits);
    } else {
        ajaxForSearch("?module=shop&op=list", undefined, total_prod, items_page);
    }
}//end_shopAll

function clicks_shop() {
    $(document).on("click", ".list__heart", function() {
        var id_car = this.getAttribute('id');
        click_like(id_car, "all_cars");
    });

    $(document).on("click", ".details__heart", function() {
        var id_car = this.getAttribute('id');
        click_like(id_car, "all_cars");
    });
}

function load_details() {
    $(document).on("click", ".more_info_list", function() {
        var id_car = this.getAttribute('id');
        details(id_car);
    });
}//end_load_details

function details(id_car) {
    ajaxPromise(friendlyURL("?module=shop&op=details"), 'GET', 'JSON', {id: id_car})
    .then(function(data) {
        $('.highlight').empty();
        $('.filters').empty();
        $('.previous_filter').empty();
        $('#listado_coches').empty();
        $('.container_sort_by').empty();
        $('#pagination').empty();
        $('.container_details').css({ 'display' : 'flex'});
        $('.related_cars_title').css({ 'display' : 'block'});

        for (row in data[1][0]) {
            $('<div></div>').attr({ 'id': data[1][0].id_img, 'class': 'date_img_dentro' }).appendTo('.carousel_imgs')
                .html(
                    "<img src='" + data[1][0][row].name_img + "'>"
                )
        }
        
        new Glider(document.querySelector('.carousel_imgs'), {
            slidesToShow: 1,
            dots: '.dots',
            draggable: true,
            arrows: {
              prev: '.glider-prev',
              next: '.glider-next'
            }
        });

        $('<div></div>').attr({ 'id': data[0][0].id_car, 'class': 'date_car_dentro' }).appendTo('.details')
            .html(
                "<h2>" + data[0][0].name_brand + " " + data[0][0].name_model + " <b><a class='details__heart' id='" + data[0][0].id_car + "'><i id= " + data[0][0].id_car + " class='fa-regular fa-heart fa-lg'></i></a>" + "</b><br>" +
                "</h2>" +
                "<p>" + data[0][0].km + "</p>" +
                "<p>" + data[0][0].name_tshift + "</p>" +
                "<p>" + data[0][0].name_cat + "</p>" +
                "<p>" + data[0][0].number_door + "</p>" +
                "<p>" + data[0][0].name_tmotor + "</p>" +
                "<p>" + data[0][0].discharge_date + "</p>" +
                "<p>" + data[0][0].name_color + "</p>" +
                "<p>" + data[0][0].name_city + "</p>" +
                "<div class='button-container'>" + 
                "<button id='"+ data[0][0].id_car +"' class='details-qty-minus' type='button' value='-'>-</button>" + 
                "<input type='number' name='qty' min='1' id='"+ data[0][0].id_car +"' class='quantity-field-details form-control' disabled value='0'/>" + 
                "<button id='"+ data[0][0].id_car +"' class='details-qty-plus' type='button' value='+'>+</button>" + 
                "<button id='"+ data[0][0].id_car +"' class='button' onclick='add_cart()'>Add To Cart</button>" + 
                "</div>"
            )
        mapBox(data[0][0]);
        more_cars_related(data[0][0].name_brand, data[0][0].id_car);
        load_likes_user();
    }).catch(function() {
        console.log('Fail details');
    });
}//end_details

function previous_filter_modal(){
    var previous_filter = JSON.parse(localStorage.getItem('previous_filter'));
    if (previous_filter) {
        $('.previous_filter').empty();
        $('.previous_filter_modal').empty();
        $('.details_previous_filter').empty();
        $('.previous_filter').css({ 'display' : 'block'});
        $('<div style="text-align: center"; align-items: center; justify-content: center;></div>').appendTo('.previous_filter')
            .html('<div class="previous_filter_modal_button" style="display: inline; margin:10px;">Filtros previos</div>');

        $('.previous_filter_modal_button').click(function () {
            $('.previous_filter_modal').empty();
            $('.details_previous_filter').empty();
            $('<div class="details_previous_filter" style="display: inline; float: center;"></div>').appendTo('.previous_filter_modal');
            for (row in previous_filter) {
                $('<div class="row'+ row +'" style="display: inline; float: center;"></div><br><br>').appendTo('.details_previous_filter');
                for(row2 in previous_filter[row][0]){
                    $('<p class="previous_filter_line" id="'+ [row] +'" style="display: inline; margin:3px;">' + previous_filter[row][0][row2][1] + '</p>').appendTo('.row'+ row +'');
                }
            }
            $(".details_previous_filter").show();
            $(".previous_filter_modal").dialog({
                title: "Filtros previos",
                width : 850,
                height: 500,
                resizable: "false",
                modal: "true",
                hide: "explode",
                show: "slide"
            });
            $(document).on('click', '.previous_filter_line', function() {
                localStorage.removeItem('filter_motor_type');
                localStorage.removeItem('filter_category');
                localStorage.removeItem('filter_brand');
                localStorage.removeItem('filter_color');
                localStorage.removeItem('filter');
                localStorage.removeItem('filter_home_brand');
                localStorage.removeItem('filter_home_cat');
                localStorage.removeItem('filter_home_tmotor');
                localStorage.removeItem('filter_search');
                localStorage.removeItem('details_visits');
                var previous_filter_line = previous_filter[this.getAttribute('id')][0];
                localStorage.setItem('previous_filter_line', JSON.stringify(previous_filter_line)); 
                window.location.href = '?module=shop';
            });
        });
    }
    else {
        $('.previous_filter').empty();
        //location.reload();
    }
}//end_previous_filter_modal

function highlight() {
    var filter = JSON.parse(localStorage.getItem('filter'));
    var filter_home_brand = JSON.parse(localStorage.getItem('filter_home_brand'));
    var filter_home_cat = JSON.parse(localStorage.getItem('filter_home_cat'));
    var filter_home_tmotor = JSON.parse(localStorage.getItem('filter_home_tmotor'));
    var filter_search = JSON.parse(localStorage.getItem('filter_search'));
    var previous_filter_line = JSON.parse(localStorage.getItem('previous_filter_line'));
    if (filter) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter) {
            $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter[row][1] + '</p>');
        }
    }else if (filter_home_brand) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter_home_brand) {
            $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter_home_brand[row][1] + '</p>');
        }
    }else if (filter_home_cat) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter_home_cat) {
            $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter_home_cat[row][1] + '</p>');
        }
    }else if (filter_home_tmotor) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter_home_tmotor) {
            $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter_home_tmotor[row][1] + '</p>');
        }
    }else if (filter_search) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter_search) {
            if(filter_search[row][1] != "0"){
                $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter_search[row][1] + '</p>');
            }//end_if
        }
    }else if (previous_filter_line) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in previous_filter_line) {
            if(previous_filter_line[row][1] != "0"){
                $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + previous_filter_line[row][1] + '</p>');
            }//end_if
        }
    }else {
        $('.highlight').empty();
        //location.reload();
    }
}//end_highlight

function print_filters() {
    ajaxPromise(friendlyURL("?module=shop&op=load_filters"), 'GET', 'JSON')
    .then(function(data) {
        for (row in data[0]) {
            $('<option></option>').attr({'value': data[0][row].name_brand}).appendTo('.filter_brand')
                .html(
                    "" + data[0][row].name_brand + ""
                )
        }
        for (row in data[1]) {
            $('<option></option>').attr({'value': data[1][row].name_tmotor }).appendTo('.filter_motor_type')
                .html(
                    "" + data[1][row].name_tmotor + ""
                )
        }
        for (row in data[2]) {
            $('<option></option>').attr({'value': data[2][row].name_cat }).appendTo('.filter_category')
                .html(
                    "" + data[2][row].name_cat + ""
                )
        }
        for (row in data[3]) {
            $('<option></option>').attr({'value': data[3][row].name_color }).appendTo('.filter_color')
                .html(
                    "" + data[3][row].name_color + ""
                )
        }
    }).catch(function() {
        console.log('Fail print filters');
    });
}//end_print_filters

function filter_button() {
    //Filtro type
        $('.filter_motor_type').change(function () {
            localStorage.setItem('filter_motor_type', this.value);
        });
        if (localStorage.getItem('filter_motor_type')) {
            $('.filter_motor_type').val(localStorage.getItem('filter_motor_type'));
        }

    //Filtro category
        $('.filter_category').change(function () {
            localStorage.setItem('filter_category', this.value);
        });
        if (localStorage.getItem('filter_category')) {
            $('.filter_category').val(localStorage.getItem('filter_category'));
        }

    //Filtro type
        $('.filter_brand').change(function () {
            localStorage.setItem('filter_brand', this.value);
        });
        if (localStorage.getItem('filter_brand')) {
            $('.filter_brand').val(localStorage.getItem('filter_brand'));
        }

    //Filtro de color
        $('.filter_color').change(function () {
            localStorage.setItem('filter_color', this.value);
        });
        if (localStorage.getItem('filter_color')) {
            $('.filter_color').val(localStorage.getItem('filter_color'));
        }

    $(document).on('click', '.filter_button', function () {
        var filter = [];
        var previous_filter = [];

        if (localStorage.getItem('filter_motor_type')) {
            filter.push(['name_tmotor', localStorage.getItem('filter_motor_type')])
        }
        if (localStorage.getItem('filter_category')) {
            filter.push(['name_cat', localStorage.getItem('filter_category')])
        }
        if (localStorage.getItem('filter_brand')) {
            filter.push(['name_brand', localStorage.getItem('filter_brand')])
        }
        if (localStorage.getItem('filter_color')) {
            filter.push(['name_color', localStorage.getItem('filter_color')])
        }

        if(filter.length != 0){//Comprueba si has aplicado algún filtro para que no de problemas al recargar la página
            localStorage.setItem('filter', JSON.stringify(filter));

            if(!localStorage.getItem('previous_filter')){
                previous_filter.push([filter]);
                localStorage.setItem('previous_filter', JSON.stringify(previous_filter));
            }else{
                previous_filter = JSON.parse(localStorage.getItem('previous_filter'));
                previous_filter.push([filter]);
    
                localStorage.setItem('previous_filter', JSON.stringify(previous_filter));
            }//end_else
            load_pagination();
            shopAll();
        }else{
            load_pagination();
            shopAll();
        }
        highlight();
        previous_filter_modal();
    });

    $(document).on('click', '.filter_remove', function () {
        localStorage.removeItem('filter_motor_type');
        localStorage.removeItem('filter_category');
        localStorage.removeItem('filter_brand');
        localStorage.removeItem('filter_color');
        localStorage.removeItem('filter');
        localStorage.removeItem('filter_home_brand');
        localStorage.removeItem('filter_home_cat');
        localStorage.removeItem('filter_home_tmotor');
        localStorage.removeItem('filter_search');
        localStorage.removeItem('previous_filter_line');
        localStorage.removeItem('details_visits');
        localStorage.removeItem('filter_sort_by');
        location.reload();
    });
}//end_filter_button

function mapBox_all(shop) {
    mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-0.6066548371843127, 38.822043781115774], // starting position [lng, lat]
        zoom: 10 // starting zoom
    });

    for (row in shop) {
        const marker = new mapboxgl.Marker()
        const minPopup = new mapboxgl.Popup()
        minPopup.setHTML('<h3 style="text-align:center;">' + shop[row].name_brand + '</h3><p style="text-align:center;">Modelo: <b>' + shop[row].name_model + '</b></p>' +
            '<p style="text-align:center;">Precio: <b>' + shop[row].price + '€</b></p>' +
            '<img src=" ' + shop[row].name_img + '" style="width: 150px; height: 150px;"/>' +
            '<a class="more_info_list button add" data-wow-delay=".4s" id="' + shop[row].id_car + '">Read More</a>')
        marker.setPopup(minPopup)
            .setLngLat([shop[row].lng, shop[row].lat])
            .addTo(map);
    }
}//end_mapBox_all

function mapBox(id) {
    mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [id.lng, id.lat], // starting position [lng, lat]
        zoom: 10 // starting zoom
    });
    const markerOntinyent = new mapboxgl.Marker()
    const minPopup = new mapboxgl.Popup()
    minPopup.setHTML('<h4>' + id.name_brand + '</h4><p>Modelo: ' + id.name_model + '</p>' +
        '<p>Precio: ' + id.price + '€</p>')
    markerOntinyent.setPopup(minPopup)
        .setLngLat([id.lng, id.lat])
        .addTo(map);
}

function filter_sort_by(){
    $('#select_sort_by').change(function () {
        var sort_by = (this.value).split(".");
        localStorage.setItem('filter_sort_by', JSON.stringify(sort_by)); 
        ajaxForSearch("?module=shop&op=filters_sort_by", sort_by, 0, 3);
    });
}//end_mapBox

function cars_related(loadeds = 0, name_brand, total_items, id_car) {
    let items = 3;
    let loaded = loadeds;
    let brand = name_brand;
    let total_item = total_items;

    ajaxPromise(friendlyURL("?module=shop&op=cars_related"), 'POST', 'JSON', { 'brand': brand, 'id_car': id_car,'loaded': loaded, 'items': items })
        .then(function(data) {
            if(data != "error"){
                for (row in data) {
                    $('<div></div>').attr({ 'id': data[row].id_car, 'class': 'col-lg-4 col-md-6 mb-2' }).appendTo('#related_cars')
                        .html(
                            "<div class='rent-item mb-4'>" +
                            "<img class='img-fluid mb-4' src= '" + data[row].name_img + "' alt=''>" +
                            "<h4 class='text-uppercase mb-4'>" + data[row].name_brand + " " + data[row].name_model + "</h4>" +
                            "<div class='d-flex justify-content-center mb-4'>" +
                            "<div class='px-2'>" +
                            "<i class='fa fa-eur text-primary mr-1'></i>" +
                            "<span>" + data[row].price + "</span>" +
                            "</div>" +
                            "<div class='px-2 border-left border-right'>" +
                            "<i class='fa fa-cogs text-primary mr-1'></i>" +
                            "<span>" + data[row].name_tmotor + "</span>" +
                            "</div>" +
                            "<div class='px-2'>" +
                            "<i class='fa fa-road text-primary mr-1'></i>" +
                            "<span>" + data[row].km + "</span>" +
                            "</div>" +
                            "</div>" +
                            "<a class='btn btn-primary px-3 more_info_list button add' id='" + data[row].id_car + "'>Más info</a>" +
                            "</div>" +
                            "</div>"
                        )
                }
                $('<div></div>').attr({ 'id': 'more_car__button', 'class': 'more_car__button' }).appendTo('#related_cars')
                    .html(
                        "<a class='btn btn-primary px-3 load_more_button button add'>Ver más</a>"
                    );

                if (loaded === 10) {
                    $("#related_cars").append(
                        '<div id="loadsugest"><a>NO HAY MAS COCHES</a></div>'
                    );
                }
            }else{
                $("#related_cars").append(
                    '<div id="loadsugest"><a>NO HAY MAS COCHES</a></div>'
                );
            }//end_else

            $(document).on("click", ".more_info_list", function() {
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
                window.location.href = '?module=shop';
            });
        }).catch(function() {
            console.log("error cars_related");
        });
}//end_cars_related

function more_cars_related(name_brand, id_car) {
    var items = 0;
    ajaxPromise(friendlyURL("?module=shop&op=count_cars_related"), 'POST', 'JSON', { 'name_brand': name_brand, 'id_car': id_car })
    .then(function(data) {
            var total_items = data[0].n_cars;
            cars_related(0, name_brand, total_items, id_car);
            $(document).on("click", '.load_more_button', function() {
                items = items + 3;
                $('.more_car__button').empty();
                $('.cat').empty();
                cars_related(items, name_brand, total_items, id_car);
            });
        }).catch(function() {
            console.log('error total_items');
        });
}//end_more_cars_related

function load_pagination() {
    var sdata;
    var filter = JSON.parse(localStorage.getItem('filter'));
    var previous_filter_line = JSON.parse(localStorage.getItem('previous_filter_line'));
    var filter_home_brand = JSON.parse(localStorage.getItem('filter_home_brand'));
    var filter_home_cat = JSON.parse(localStorage.getItem('filter_home_cat'));
    var filter_home_tmotor = JSON.parse(localStorage.getItem('filter_home_tmotor'));
    var filter_search = JSON.parse(localStorage.getItem('filter_search'));

    if(filter){
        var url = "?module=shop&op=count_cars_filter";
        sdata = filter;
    }else if(previous_filter_line){
        var url = "?module=shop&op=count_cars_filter";
        sdata = previous_filter_line;
    }else if(filter_home_brand){
        var url = "?module=shop&op=count_cars_filter";
        sdata = filter_home_brand;
    }else if(filter_home_cat){
        var url = "?module=shop&op=count_cars_filter";
        sdata = filter_home_cat;
    }else if(filter_home_tmotor){
        var url = "?module=shop&op=count_cars_filter";
        sdata = filter_home_tmotor;
    }else if(filter_search){
        var url = "?module=shop&op=count_cars_filter_search";
        sdata = filter_search;
    }else{
        var url = "?module=shop&op=count_cars_all";
    }
    
    ajaxPromise(friendlyURL(url), 'POST', 'JSON', {'filter': sdata})
        .then(function(data) {
            var total_prod = data[0].n_cars;
            if (total_prod >= 3) {
                total_pages = Math.ceil(total_prod / 3);
            } else {
                total_pages = 1;
            }

            $('#pagination').bootpag({
                total: total_pages,
                page: localStorage.getItem('page') ? localStorage.getItem('page') : 1,
                maxVisible: total_pages
            }).on('page', function(event, num) {
                localStorage.setItem('page', num);
                localStorage.removeItem('id_car');
                total_prod = 3 * (num - 1);
                if (total_prod == 0) {
                    localStorage.setItem('total_prod', 0)
                }
                shopAll(total_prod, 3);
                $('html, body').animate({ scrollTop: $("#listado_coches") });
            });
        }).catch(function() {
            console.log('Fail pagination');
        });
}//end_load_pagination

function click_like(id_car, lugar) {
    var token = localStorage.getItem('token');
    if (token) {
        ajaxPromise(friendlyURL("?module=shop&op=control_likes"), 'POST', 'JSON', {'id_car': id_car, 'token': token})
        .then(function(data) {
                $("#" + id_car + ".fa-heart").toggleClass('fa-solid');
            }).catch(function() {
                console.log('Fail likes');
            });
    } else {
        const redirect = [];
        redirect.push(id_car, lugar);

        localStorage.setItem('redirect_like', redirect);
        localStorage.setItem('id_car', id_car);

        toastr.warning("Debes de iniciar sesion");
        setTimeout(' window.location.href = "?module=login"; ', 1000);
    }
}//end_click_like

function load_likes_user() {
    var token = localStorage.getItem('token');
    if (token) {
        ajaxPromise(friendlyURL("?module=shop&op=load_likes"), 'POST', 'JSON', {'token': token})
            .then(function(data) {
                for (row in data) {
                    $("#" + data[row].id_car + ".fa-heart").toggleClass('fa-solid');
                }
            }).catch(function() {
                console.log('Fail load likes');
            });
    }
}//end_load_likes_user

function redirect_login_like() {
    var redirect = localStorage.getItem('redirect_like').split(",");
    if (redirect[1] == "details_car") {
        localStorage.removeItem('redirect_like');
        details(redirect[0]);
    } else if (redirect[1] == "all_cars") {
        localStorage.removeItem('redirect_like');
        click_like(redirect[0], redirect[1]);
        shopAll();
    }
}//end_redirect_login_like

$(document).ready(function() {
    load_pagination();
    shopAll();
    load_details();
    print_filters();
    filter_button();
    highlight();
    previous_filter_modal();
    clicks_shop();
    filter_sort_by();
});