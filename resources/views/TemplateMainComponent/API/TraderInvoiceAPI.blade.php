@if(!\Illuminate\Support\Facades\Auth::check())
    {{redirect()->route('Weblogin')}}
@endif
<script>

    var pusher = new Pusher('50de759f9fcf328ef11b');
    var channel = pusher.subscribe('traderInvoiceAPI');
    channel.bind('trader_Invoice_API', function (data) {
       alert(data);
        console.log(data);
        createNewRow(data['productName'] , data['productNumber']);

    });

    function createNewRow($productName , $productNumber)
    {

        if(checkTableRows($productName , $productNumber))
                return;

        console.log($('#table >tbody >tr').length);
        var currentRow = $('#table >tbody >tr').length+1;
        txt = "<tr class='inputsItem' id='"+currentRow+"'>" +
                "<td style='padding: 3px'>" +
                "<button type='button' class='btn btn-default removeButton'>" +
                "<i class='fa fa-minus'></i>" +
                "</button>" +
                "</td>" +
                " <td><input type='text'" +
                " name='item-"+currentRow+"' class='form-control' id='item' onkeyup='$(this).validateItem();$(this).checkItem();$(this).checkItems()' value='"+$productName+"'/>" +
                "</td> " +
                "<td><input type='text'" +
                " name='amount-"+currentRow+"' class='form-control' id='amount' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"wholePriceFromTrader\")'/>" +
                "</td>" +
                " <td>" +
                "<input type='text'" +
                " name='wholePriceFromTrader-"+currentRow+"' class='form-control' id='wholePriceFromTrader' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"amount\")'/>" +
                "</td>" +
                " <td><input type='text' name='wholePriceForSale-"+currentRow+"' class='form-control' id='wholePriceForSale' onkeyup='$(this).validateItem()'/>" +
                "</td>" +
                " <td>" +
                "<input type='text\' name='singleUnit-"+currentRow+"' class='form-control' id='singleUnit' onkeyup='$(this).validateItem()'/>" +
                "</td>" +
                " <td>" +
                "<input type='text\' name='singlePrice-"+currentRow+"' class='form-control' id='singlePrice' onkeyup='$(this).validateItem()'/>" +
                "</td>" +

                " <td style='text-align: center'><strong name='autoTotal-"+currentRow+"' id='autoTotal'>0</strong>" +
                "</td>" +
                "<input name='barcode-"+currentRow+"' type='hidden' value='"+$productNumber+"' style='display:none; border: 0 !important;'/>"+
                "</tr>";

        $(txt).appendTo('#table tbody');
    }

    function checkTableRows($productName , $productNumber)
    {
        if($('#table >tbody >tr').length == 1 &&  $('#table >tbody >tr').children().children("#item").val() == "")
        {
            $text =  "<input name='barcode-1' type='hidden' value='"+$productNumber+"' style='display:none; border: 0 !important;'/>";
            $('#table >tbody >tr').children().last().after($text);
            $('#table >tbody >tr').children().children("#item").val($productName);
            return true;
        }
        return false;
    }

</script>