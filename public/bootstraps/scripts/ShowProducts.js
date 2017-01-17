
$('#search').click(function () {
    $productName = $(this).parent().parent().children('#searchContent');

    $.ajax({
        method: 'post',
        url: searchForProduct,
        data: {body: '' + $productName.val(), postId: '', _token: token}

    }).done(function (msg) {
        console.log(msg['message']);
        if (msg['status'] == '200') {
            $('tbody tr').hide();
            $('tbody').append(
                $('<tr>').append(
                    $('<td>').attr({}).html(0),
                    $('<td>').attr({}).html(msg['message'][0]['Name']),
                    $('<td>').attr({}).html(msg['message'][0]['WholeQuantity']),
                    $('<td>').attr({}).html(msg['message'][0]['WholePrice']),
                    $('<td>').attr({}).html(msg['message'][0]['SingleUnitAmount']),
                    $('<td>').attr({}).html(msg['message'][0]['SingleUnitPrice'])
                )
            );
        }else if((msg['status'] == '402'))
        {
            $('tbody tr').show(true);
        }

    });
});

$('input[id="searchContent"]').keyup(function()
{

    $.ajax({
        method: 'get',
        url: allProductName,
        data: {body: '', postId: '', _token: token}

    }).done(function (msg) {
        $allProducts = msg['message'];
        console.log($allProducts);

    });


    var normalize = function (term) {
        var ret = "";
        for (var i = 0; i < term.length; i++) {
            ret += term.charAt(i);
        }
        return ret;
    };

    $(this).autocomplete({
        source: function (request, response) {
            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep($allProducts, function (value) {
                value = value.label || value.value || value;
                return matcher.test(value) || matcher.test(normalize(value));
            }));


        },

        change: function (event, ui) {

            if (ui.item === null) {

            }
        }

    });
});

$(document).ready(function(){

    $(this).dataTableInitialization();
    $(this).dataTablePreparations();
});


(function($){
    $.fn.dataTablePreparations = function(){

        //Search customization
        // $(".dataTables_paginate").addClass('col-sm-12');
        // $(".dataTables_paginate").parent('div').removeClass('col-sm-6').addClass('col-sm-12 ');
        // $(".dataTables_info").parent().remove();
        // $(".dataTables_filter").children('label').contents().first().replaceWith('بحث');
        // $(".dataTables_filter").children('label').css('font-size','20px');
        // $(".dataTables_filter").children('label')
        //     .children('input')
        //     .css('margin-right','10px')
        //     .addClass('input-group date')
        //     .attr('data-date-format','yyyy-mm-dd').attr('placeholder','اسم المنتج');
        //
        //
        //
        // //customizing the number of rows
        // $('.dataTables_length').children('label').contents().first().replaceWith('عرض');
        // $('.dataTables_length').children('label').contents().last().remove();
        // $(".dataTables_length").children('label').css('font-size','20px');
        // $(".dataTables_length").children('label').children('select').css('margin-right','10px');
    }
})(jQuery);

(function($){
    $.fn.dataTableInitialization = function(){
        $('#example2').dataTable();
    }
})(jQuery);