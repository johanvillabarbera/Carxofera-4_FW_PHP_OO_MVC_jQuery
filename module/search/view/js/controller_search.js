function load_model(data) {
    if (data == undefined || data == 0) {
        ajaxPromise(friendlyURL("?module=search&op=select_model"), 'POST', 'JSON')
        .then(function(data) {
            $('#select_model').empty();
            $('#select_model').append('<option value = "0">Modelos</option>');
            for (row in data) {
                $('#select_model').append('<option value = "' + data[row].name_model + '">' + data[row].name_model + '</option>');
            }
        }).catch(function() {
            console.log("Fail load select_model");
        });
    } else {
        ajaxPromise(friendlyURL("?module=search&op=select_model_brand"), 'POST', 'JSON', { 'brand': data })
            .then(function(data) {
                $('#select_model').empty();
                $('#select_model').append('<option value = "0">Modelos</option>');
                for (row in data) {
                    $('#select_model').append('<option value = "' + data[row].name_model + '">' + data[row].name_model + '</option>');
                }
            }).catch(function(data) {
                console.log('Fail load select_model');
            });
    }
}

function load_brand() {
    ajaxPromise(friendlyURL("?module=search&op=select_brand"), 'POST', 'JSON')
        .then(function(data) {
            $('#select_brand').empty();
            $('#select_brand').append('<option value = "0">Marcas</option>');
            for (row in data) {
                $('#select_brand').append('<option value = "' + data[row].name_brand + '">' + data[row].name_brand + '</option>');
            }
        }).catch(function(data) {
            console.log('Fail load brand');
        });
}

function launch_search() {
    load_brand();
    load_model();
    $('#select_brand').on('change', function() {
        let select_brand = $(this).val();
        if (select_brand === 0) {
            load_model();
        } else {
            load_model(select_brand);
        }
    });
}

function autocomplete() {
    $("#autocom").on("keyup", function() {
        autocom($(this).val());
    });

    $("#autocom").on("click", function() {
        autocom($(this).val());
    });

    function autocom(data){
        let sdata = { name_city : data };

        if (($('#select_model').val() != 0)) {
            sdata.name_model = $('#select_model').val();
            if (($('#select_model').val() != 0) && ($('#select_brand').val() != 0)) {
                sdata.name_brand = $('#select_brand').val();
            }
        }
        if (($('#select_model').val() == 0) && ($('#select_brand').val() != 0)) {
            sdata.name_brand = $('#select_brand').val();
        }

        ajaxPromise(friendlyURL("?module=search&op=autocomplete"), 'POST', 'JSON', sdata)
        .then(function(data) {
            console.log(data);
            $('#search_auto').empty();
            $('#search_auto').fadeIn(10000000);
            for (row in data) {
                $('<div></div>').appendTo('#search_auto').html(data[row].name_city).attr({ 'class': 'searchElement', 'id': data[row].name_city });
            }
            $(document).on('click', '.searchElement', function() {
                $('#autocom').val(this.getAttribute('id'));
                $('#search_auto').fadeOut(900);
            });
            $(document).on('click scroll', function(event) {
                if (event.target.id !== 'autocom') {
                    $('#search_auto').empty();
                }
            });
        }).catch(function() {
            $('#search_auto').fadeOut(500);
        });
    }
}

function btn_search() {
    $('#search-btn').on('click', function() {
        var search = [];

        if ($('#autocom').val() == "") {
            search.push([ "name_city", '0' ]);
            search.push([ "name_model", $('#select_model').val() ]);
            search.push([ "name_brand", $('#select_brand').val() ]);
        } else {
            search.push([ "name_city", $('#autocom').val() ]);
            search.push([ "name_model", $('#select_model').val() ]);
            search.push([ "name_brand", $('#select_brand').val() ]);
        }
        localStorage.removeItem('filter_motor_type');
        localStorage.removeItem('filter_category');
        localStorage.removeItem('filter_brand');
        localStorage.removeItem('filter_color');
        localStorage.removeItem('filter');
        localStorage.removeItem('filter_home_brand');
        localStorage.removeItem('filter_home_cat');
        localStorage.removeItem('filter_home_tmotor');
        localStorage.removeItem('previous_filter_line');

        localStorage.setItem('filter_search', JSON.stringify(search));
        window.location.href = '?module=shop';
    });
}

$(document).ready(function() {
    launch_search();
    autocomplete();
    btn_search();
});