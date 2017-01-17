/**
 * Created by Amr Saidam on 7/1/2016.
 */
var dataRow = null;
var invoiceNum = [];
var allItems = [];
var invID ;
$(document).ready(function()
{
    // $(this).dataTableInitialization();
    // $(this).dataTablePreparations();
    var table = $('#example2').DataTable();

    $( "body" ).on('click', ".showInvoice", function(e) {
        invID = $(this).attr('id');
        $('#table >tbody >tr').remove();
        allItems = [];
        $('.fade').modal('show');
        dataRow = table.row($(this).closest('tr')).data();
        $('#invoiceNum').html(dataRow[0]);
        $('#generalTotal2').html(dataRow[1]);
        var id = $(this).attr('id');
        $.ajax({
            method: 'GET',
            url: getInvoices,
            data: {_token: token, invoiceID: id}
        }).done(function (msg) {
            for(var count=0;count<msg.invoice.length;count++){
                var txt = "<tr id='"+msg.invoice[count].Sale_ID+"'>" +
                    "<td><button type='button' id='del-item' class='btn btn-xs btn-danger' title='حذف الصنف' style='margin-top: 7px'><i class='fa fa-times'></i></button></td>" +
                    "<td style='text-align: center'><strong id='item'>"+msg.invoice[count].Name+"</strong></td>" +
                    "<td style='text-align: center'><input id='spinner' class='form-control' style='width: 60%;' disabled></td>" +
                    "<td style='text-align: center'><strong id='price'>"+msg.invoice[count].singleUnitPrice+"</strong></td>" +
                    "<td style='text-align: center'><strong id='autoTotal'>"+msg.invoice[count].productTotal+"</strong></td>" +
                    "</tr>";
                //$(txt).appendTo('#table tbody');
                $('#table tbody').after().append(txt);
                //$( "input#spinner" ).spinner( "option", "incremental", false );
                $('#table tr').eq(count+1).find( "#spinner" ).spinner({
                    max: msg.invoice[count].NumberOfSingleUnitBought,
                    min: 1,
                    classes: {
                        "ui-spinner": "ui-corner-all"
                        // "ui-spinner-down": "ui-corner-br",
                        // "ui-spinner-up": "ui-corner-tr"
                    }
                }).val(msg.invoice[count].NumberOfSingleUnitBought);
                //$('#table tbody').append(txt);
            }
        });
    });

    $( "body" ).on('click', ".ui-corner-all", function() {
        $('#generalTotal2').html($('#generalTotal2').text().trim() - $(this).closest('tr').find('#autoTotal').text().trim());
        $(this).closest('tr').find('#autoTotal').html($(this).closest('tr').find('#spinner').val() * $(this).closest('tr').find('#price').text().trim());
        $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim()));
    });

    // $( "body" ).on('click', ".ui-corner-br", function() {
    //     $('#generalTotal2').html($('#generalTotal2').text().trim() - $(this).closest('tr').find('#autoTotal').text().trim());
    //     $(this).closest('tr').find('#autoTotal').html($(this).closest('tr').find('#spinner').val() * $(this).closest('tr').find('#price').text().trim());
    //     $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim()));
    // });

    $( "body" ).on('click', ".deleteItem", function() {
        $(this).confirmation('show');
    });

    $( "#invoiceForm" ).on('click', "#del-item", function() {
        $(this).closest('tr').find('#spinner').spinner("option", { disabled: true });
        $(this).closest('tr').css("background-color", "gray");
        $(this).removeClass('btn-danger').addClass('btn-success');
        $(this).attr('id','ret-item');
        $(this).closest('tr').find('.fa-times').removeClass('fa fa-times').addClass('fa fa-check');
        $(this).attr('title','تراجع');

        $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) - parseInt($(this).closest('tr').find('#autoTotal').text().trim()));

        invoiceNum.push($(this).closest('tr').attr('id'));
    });

    $( "#invoiceForm" ).on('click', "#ret-item", function() {
        $(this).closest('tr').find('#spinner').spinner("option", { disabled: false });
        $(this).closest('tr').find('input').attr('disabled',true);
        $(this).closest('tr').css("background-color", "");
        $(this).removeClass('btn-success').addClass('btn-danger');
        $(this).attr('id','del-item');
        $(this).closest('tr').find('.fa-check').removeClass('fa fa-check').addClass('fa fa-times');
        $(this).attr('title','حذف الصنف');

        $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim()));

        var removeItem = $(this).closest('tr').attr('id');
        invoiceNum = jQuery.grep(invoiceNum, function(value) {
            return value != removeItem;
        });
    });

    $('#invoiceForm').submit(function (event) {
        if($('#table >tbody >tr').length != invoiceNum.length) {
            $('#table >tbody >tr').each(function () {
                var rowData = [];
                var status = 0;
                for (var count = 0; count < invoiceNum.length; count++) {
                    if (invoiceNum[count] == $(this).attr('id'))
                        status = 1;
                }
                if (status == 0) {
                    rowData = $(this).children('td').find('strong').map(function () {
                        return $(this).text().trim();
                    }).get();
                    rowData.push($(this).children('td').find('#spinner').val());
                    rowData.push($(this).attr('id'));
                    allItems.push(rowData);
                    // console.log(rowData);
                    // console.log(allItems[$(this).index()]);
                }

            });
            var total = $('#generalTotal2').text().trim();
            $.ajax({
                method: 'POST',
                url: editInvoice,
                data: {items: allItems, delItem: invoiceNum, invoiceID: invID, total: total, _token: token}
            }).done(function (msg) {
                var id = $('strong#invoiceNum').text().trim();
                table.cell({row: id - 1, column: 1}).data(total).draw();
                $('#closePopup').trigger('click');
                table.row(id - 1).nodes().to$().addClass('highlight');
                window.setTimeout(function () {
                    table.row(id - 1).nodes().to$().removeClass('highlight');
                }, 2000);
                Lobibox.notify('success', {
                    size: 'mini',
                    rounded: true,
                    delayIndicator: false,
                    sound: false,
                    msg: 'تمت عملية اضافة التعديلات بنجاح'
                });
            });
        }
        else{
            alert('لا يمكنك حذف جميع المبيعات من هنا .. فقط للتعديل او حذف عنصر معين')
        }
       event.preventDefault();
    });

    $( "body" ).on('click', ".deleteItem", function() {
        $(this).confirmation('show');
    });

    $('body').on('click','.rmRow',function () {
        rowID = $(this).parents('tr').attr('id');
        table.row($(this).parents('tr')).remove().draw();
        var id = 1;
        if($('#example2').dataTable().fnGetData().length != 0) {
            $('#invoices > tbody > tr').each(function () {
                table.cell({row: id - 1, column: 0}).data(id).draw();
                id++;
            })
        }
        $.ajax({
            method: 'GET',
            url: deleteInvoice,
            data:{_token: token, invoiceID: rowID}
        })
    });
        //$("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');


   // $('#myid').contents().last().replaceWith('my new text');
    //
    //$paginateId = parseInt($('.active').children('span').html());
    //$('.pagination').children().each(function(index , value){
    //
    //    if(index == 10  )
    //    {
    //
    //        $(this).children('li').removeClass('disabled');
    //    }
    //});
    //console.log();
    //if($paginateId <= 5)
    //{
    //
    //}


    //$('#pagination').ready(function(){
    //
    //});
});

//$('input[id="fullDate"]').click(function(){
//    $('input[id="firstDate"]').val('');
//    $('input[id="lastDate"]').val('');
//});
//
//$('input[id="firstDate"]').click(function(){
//    $('input[id="fullDate"]').val('');
//});

//
//$('#search').click(function()
//{
//    //if($('input[id="fullDate"]').length > 0 )
//   // {
//       $contentForSearch = $('input[id="fullDate"]').val();
//   // }
//
//    console.log('Hi');
//    $.ajax({
//        method: 'get',
//        url: getResult,
//        data: {body: $contentForSearch, postId: '', _token: token}
//
//    }).done(function (msg) {
//
//        if(msg['status'] == '200')
//        {
//
//           // $('').ready(function(){auto_re});
//           // saleInvoices = msg.saleInvoices;
//           // $("tbody").fadeIn();
//           // console.log( msg['saleInvoices']);
//            //
//            //$.each(msg['message'] , function(index , value){
//            //
//            //
//            //
//            //    console.log('the value is '+value['SInvID']);
//            //    $('tbody ').append(
//            //        $('<tr>').attr({}).append(
//            //            $('<td>').attr({}).html(index+1),
//            //            $('<td>').attr({}).html(value['SInvID']),
//            //            $('<td>').attr({}).html(value['InvoiceTotal']),
//            //            $('<td>').attr({}).html(value['created_at'])
//            //
//            //        )
//            //
//            //    );
//            //
//            //});
//            //
//            //
//            //$("tbody tr").quickPagination({pagerLocation:"both",pageSize:"10"});
//
//        }
//        //$allProducts = msg['message'];
//        //console.log($allProducts);
//
//    });
//});
// (function($){
//     $.fn.dataTablePreparations = function(){
//
//         //Search customization
//         // $(".dataTables_paginate").addClass('col-sm-12');
//         // $(".dataTables_paginate").parent('div').removeClass('col-sm-6').addClass('col-sm-12 ');
//         // $(".dataTables_info").parent().remove();
//         // $(".dataTables_filter").children('label').contents().first().replaceWith('بحث');
//         // $(".dataTables_filter").children('label').css('font-size','20px');
//         // $(".dataTables_filter").children('label')
//         //                         .children('input')
//         //                         .css('margin-right','10px')
//         //                         .addClass('input-group date')
//         //                         .attr('data-date-format','yyyy-mm-dd').attr('placeholder','البحث عن طريق التاريخ ');
//         //
//         //
//         //
//         // //customizing the number of rows
//         // $('.dataTables_length').children('label').contents().first().replaceWith('عرض');
//         // $('.dataTables_length').children('label').contents().last().remove();
//         // $(".dataTables_length").children('label').css('font-size','20px');
//         // $(".dataTables_length").children('label').children('select').css('margin-right','10px');
//     }
// })(jQuery);
//
// (function($){
//     $.fn.dataTableInitialization = function(){
//         $('#example2').dataTable();
//     }
// })(jQuery);