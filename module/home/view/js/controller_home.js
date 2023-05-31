function carousel_Brands() {
    ajaxPromise(friendlyURL("?module=home&op=carouselBrands"), 'POST', 'JSON')
    .then(function(data) {
            for (row in data) {
                $('<div></div>').attr('class', "carousel__elements").attr('id', data[row].name_brand).appendTo(".carousel_brands").html(
                    "<img class='carousel_img' id='' src='" + data[row].img_brand + "' alt='' >"
                )
            }//end_for

            new Glider(document.querySelector('.carousel_brands'), {
                slidesToShow: 5,
                slidesToScroll: 1,
                draggable: true,
                dots: '.dots',
                arrows: {
                  prev: '.glider-prev',
                  next: '.glider-next'
                }
              });
        })
        .catch(function() {
            console.log('Fail Carousel Brands');
        });
}//end_carousel_Brands

function loadCategories() {
    ajaxPromise(friendlyURL("?module=home&op=category"), 'POST', 'JSON')
    .then(function(data) {
        for (row in data) {
            $('<div></div>').attr('class', "cat__elements").attr('id', data[row].name_cat).appendTo('#containerCategories')
                .html(
                    "<div class='face face1' style='background-image: url(" + data[row].img_cat + ")'>" +
                        "<div class='content'>" +
                            "<h3>" + data[row].name_cat + "</h3>"+
                        "</div>" +
                    "</div>"
                )
        }
    }).catch(function() {
        console.log('Fail Categories');
    });
}//end_loadCategories

function loadCatTypes() {
    ajaxPromise(friendlyURL("?module=home&op=type"), 'POST', 'JSON')
    .then(function(data) {
        for (row in data) {
            $('<div></div>').attr('class', "tmotor__elements").attr('id', data[row].name_tmotor).appendTo('#containerTypecar')
                .html(
                    "<div class='face face1' style='background-image: url(" + data[row].img_tmotor + ")'>" +
                        "<div class='content'>" +
                            "<h3>" + data[row].name_tmotor + "</h3>"+
                        "</div>" +
                    "</div>"
                )
        }
    }).catch(function() {
        console.log('Fail CatTypes');
    });
}//end_loadCatTypes

function loadCarouselVisits(){
    ajaxPromise(friendlyURL("?module=home&op=carouselVisits"), 'POST', 'JSON')
    .then(function(data) {
            for (row in data) {
                $('<div></div>').attr('class', "rent-item").appendTo(".carousel-visits").html(
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
                    "</div>"
                )
            }

            $(".carousel-visits").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                center: true,
                margin: 30,
                dots: false,
                loop: true,
                nav : true,
                navText : [
                    '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                    '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                ],
                responsive: {
                    0:{
                        items:1
                    },
                    576:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    992:{
                        items:3
                    }
                }
            });

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
        })
        .catch(function() {
            console.log('Fail Carousel Visits');
        });
}//end_loadCarouselVisits

function clicks(){
    localStorage.removeItem('filter_motor_type');
    localStorage.removeItem('filter_category');
    localStorage.removeItem('filter_brand');
    localStorage.removeItem('filter_color');
    localStorage.removeItem('filter_search');
    localStorage.removeItem('previous_filter_line');
    localStorage.removeItem('details_visits');
    $(document).on("click",'div.carousel__elements', function (){
      var filter_home_brand = [];
      filter_home_brand.push(['name_brand',this.getAttribute('id')]);
      localStorage.removeItem('filter_home_brand');
      localStorage.removeItem('filter_home_cat');
      localStorage.removeItem('filter_home_tmotor');
      localStorage.removeItem('filter');
      localStorage.setItem('filter_home_brand', JSON.stringify(filter_home_brand)); 
        setTimeout(function(){ 
          window.location.href = '?module=shop';
        }, 1000);  
    }); 

    $(document).on("click",'div.cat__elements', function (){
      var filter_home_cat = [];
      filter_home_cat.push(['name_cat',this.getAttribute('id')]);
      localStorage.removeItem('filter_home_brand');
      localStorage.removeItem('filter_home_cat');
      localStorage.removeItem('filter_home_tmotor');
      localStorage.removeItem('filter');
      localStorage.setItem('filter_home_cat', JSON.stringify(filter_home_cat)); 
        setTimeout(function(){ 
          window.location.href = '?module=shop';
        }, 1000);  
    });

    $(document).on("click",'div.tmotor__elements', function (){
      var filter_home_tmotor = [];
      filter_home_tmotor.push(['name_tmotor',this.getAttribute('id')]);
      localStorage.removeItem('filter_home_brand');
      localStorage.removeItem('filter_home_tmotor');
      localStorage.removeItem('filter_home_cat');
      localStorage.removeItem('filter');
      localStorage.setItem('filter_home_tmotor', JSON.stringify(filter_home_tmotor)); 
        setTimeout(function(){ 
          window.location.href = '?module=shop';
        }, 1000);  
    });
}//end_clicks

function loadsuggestions() {
    var limit = 2;
    
    $(document).on("click", '.cta', function() {
        $('#revistas_cars').empty();
        limit = limit + 2;

        ajaxPromise('https://www.googleapis.com/books/v1/volumes?q=car', 'GET', 'JSON')
        .then(function(data) {
            var DatosJson = JSON.parse(JSON.stringify(data));
            DatosJson.items.length = limit;

            for (i = 0; i < DatosJson.items.length; i++) {
                $('<div></div>').attr({ 'id': 'prueba', 'class': 'col-lg-4 col-md-6 mb-2' }).appendTo('#revistas_cars')
                    .html(
                        "<div class='rent-item mb-4'>" +
                        "<img class='img-fluid mb-4' src='" + data['items'][i]['volumeInfo']['imageLinks']['thumbnail'] + "' alt=''>" +
                        "<h4 class='text-uppercase mb-4'>" + DatosJson.items[i].volumeInfo.title + "</h4>" +
                        "<a class='btn btn-primary px-3 cta_search button add' href='" + data['items'][i]['accessInfo']['webReaderLink'] + "'>Más info</a>" +
                        "</div>"
                    )
            }
            
            if (limit === 10) {
                $("#revistas_cars").append(
                    '<div id="loadsugest"><a>NO HAY MAS REVISTAS</a></div>'
                );
            }else{
                $('<div></div>').appendTo('#revistas_cars')
                .html(
                    "<a class='btn btn-primary px-3 cta button add'>Ver más</a>"
                );
            }
        });
    })
}//end_loadSuggestions

function getSuggestions() {
    limit = 2;
    ajaxPromise('https://www.googleapis.com/books/v1/volumes?q=car', 'GET', 'JSON')
    .then(function(data) {
        var DatosJson = JSON.parse(JSON.stringify(data));
        DatosJson.items.length = limit;

        for (i = 0; i < DatosJson.items.length; i++) {
            $('<div></div>').attr({'class': 'col-lg-4 col-md-6 mb-2' }).appendTo('#revistas_cars')
                .html(
                    "<div class='rent-item mb-4'>" +
                    "<img class='img-fluid mb-4' src='" + data['items'][i]['volumeInfo']['imageLinks']['thumbnail'] + "' alt=''>" +
                    "<h4 class='text-uppercase mb-4'>" + DatosJson.items[i].volumeInfo.title + "</h4>" +
                    "<a class='btn btn-primary px-3 cta_search button add' href='" + data['items'][i]['accessInfo']['webReaderLink'] + "'>Más info</a>" +
                    "</div>"
                )
        }
        $('<div></div>').appendTo('#revistas_cars')
            .html(
                "<a class='btn btn-primary px-3 cta button add'>Ver más</a>"
            );
    });
    loadsuggestions();
}//end_getSuggestions

$(document).ready(function() {
    carousel_Brands();
    loadCategories();
    loadCatTypes();
    loadCarouselVisits();
    clicks();
    getSuggestions();
});