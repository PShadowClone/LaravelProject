@if(!\Illuminate\Support\Facades\Auth::check())
    {{redirect()->route('Weblogin')}}
@endif
<script>

    var pusher = new Pusher('50de759f9fcf328ef11b');
    var channel = pusher.subscribe('salePointAPI');
    channel.bind('trader_Invoice_API', function (data) {
        alert(data);
        console.log(data['']);
        createNewRow(data['productName']);
       // createNewRow(data['productName'] , data['productNumber']);

    });


    function createNewRow($productName)
    {

        if(checkTableRows($productName))
            return;
        $('table #body').append(
                $('<tr>').attr({}).append($('<td>').attr({}).append(
                        $('<div>').attr({
                            id: 'delete',
                            class: 'btn btn-danger delete-row',
                            onclick: "$(this).myfunction()"
                        }).append(
                                $('<i>').attr({
                                    class: "glyphicon glyphicon-minus"

                                })
                        )
                        ),
                        $('<td>').attr({}).append($('<input>').attr({
                            id: "productName",
                            name: "productName[]",
                            type: "text",
                            placeholder: "  اسم المنتج ",
                            onfocusout: "$(this).productNameValidationAndAutoComplete()",
                            class: "form-control",
                            onkeypress: "$(this).AutoComplete()",
                            value:$productName,
                            onfocusin:"",
                            onfocusin: "$(this).productNameFocusIn()"

                        })),

                        $('<td>').attr({}).append($('<input>').attr({

                            id: "productAmount",
                            name: "productAmount[]",
                            type: "text",
                            placeholder: " الكمية  ",
                            onfocusout: "$(this).AmountValidation()",
                            class: "form-control",
                            onfocusin: "$(this).productAmountFocusIn()",
                            pattern:"\d+",
                            required:"required"


                        })),
                        $('<td>').attr({
                            id: "productSum",
                            name: "productSum[]",
                            class: "productSumStyle"
                        })
                )
        );
    }

    function checkTableRows($productName)
    {
        if($('#table >tbody >tr').length == 1 &&  $('#table >tbody >tr').children().children("#productName").val() == "")
        {
            $('#table >tbody >tr').children().children("#productName").val($productName);
            return true;
        }
        return false;
    }

</script>