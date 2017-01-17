/**
 * Created by Khalid on 7/20/2016.
 */

var traders = [];
var rowIndex;
var trader;
var traderID;
$(document).ready(function () {
$.ajax({
   method: 'GET',
    url: getAllTraders
}).done(function (msg) {
    for(var i=0; i<msg.traders.length; i++){
        var singleTrader = [];
        singleTrader.push(msg.traders[i].TID);
        singleTrader.push(msg.traders[i].name);
        singleTrader.push(msg.traders[i].Email);
        singleTrader.push(msg.traders[i].Mobile);
        singleTrader.push(msg.traders[i].Address);
        var date = (msg.traders[i].created_at).split(" ");
        singleTrader.push(date[0]);
        traders.push(singleTrader);

      var rowIndex = $('#traders').dataTable().fnAddData([
          [singleTrader[1],singleTrader[2],singleTrader[3],singleTrader[4],singleTrader[5]]
      ]);
        var row = $('#traders').dataTable().fnGetNodes(rowIndex);
        $(row).attr('class', 'fadeandscale_open');
        $(row).attr('id',singleTrader[0]);
    }
});
    $('#traders tbody').on('click', 'tr', function () {
        trader = $('#traders').DataTable().row(this).data();
        // trader = $(this).children('td').map(function () {
        //     return $(this).text();
        // }).get();
        rowIndex = $('#traders').DataTable().row(this).index();
        traderID = $(this).attr('id');
        // var tr = $(this).closest("tr");
        // rowIndex = tr.index();
        $('#name').prop('disabled', true);
        $('#name').val(trader[0]);
        $('#traderMail').val(trader[1]);
        $('#mobileNumber').val(trader[2]);
        $('#address').val(trader[3]);
    });

    $('#traderForm').validate({
        rules:{
            name: "required",
            traderMail: "email",
            mobileNumber: {
                required: true,
                digits: true,
                minlength:7
            },
            address: "required"
        },
        errorPlacement: function (element) {
            return false;
        },
        submitHandler: function (event) {
            var bool = false;
           $('#traders').DataTable().row(rowIndex).data([
                $('#name').val(), $('#traderMail').val(), $('#mobileNumber').val(), $('#address').val(),trader[4]
            ]);
            $( "#closePopup" ).trigger( "click" );
            var currentTrader = $('#traders').DataTable().row(rowIndex).data();
            for(var i=0;i<currentTrader.length;i++){
                if(currentTrader[i] != trader[i])
                    bool = true;
            }
            if(bool){
                $('#traders').DataTable().row(rowIndex).nodes().to$().addClass('highlight');
                $.ajax({
                    method: 'POST',
                    url: editTrader,
                    data: {_token: token, traderInfo: currentTrader, tid: traderID}
                });
                window.setTimeout(function () {
                    $('#traders').DataTable().row(rowIndex).nodes().to$().removeClass('highlight');
                }, 2000);
            }
            // $('#traders').DataTable().row(rowIndex).addClass('highlight');
            // if($($('#traders').DataTable().row(rowIndex).data()).not(trader) === 0 && $(trader).not($('#traders').DataTable().row(rowIndex).data()) === 0){
            //     alert('yes')
            // }
            // else {
            //     alert('no');
            // }
            // alert(""+$('#traders').DataTable().row(rowIndex).data()+"    "+trader);
            // alert(""+$('#traders').DataTable().row(rowIndex).data().length+"  "+trader.length);
            //$('#traderForm').find('input[type=text]').val("");
        }
    });
    });