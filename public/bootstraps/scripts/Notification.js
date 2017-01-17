/**
 * Created by Amr Saidam on 10/6/2016.
 */
$('#example2 tbody tr').click('tr',function(){

    $table = $('#example2').DataTable();
    $productNameArray = $table.cell($(this).index() , 1).data().split(" ");
    $time = $table.cell($(this).index() , 3).data();
    $date = $table.cell($(this).index() , 4).data();
    $productName = $productNameArray[$productNameArray.length-5];
    $productId  =  $productNameArray[$productNameArray.length-2];
    $content = 'name=' + $productName + '/productId=' + $productId+ '/updated_at=' + $date+' '+$time;
    $id = '' + $productName + '' +$productId;
    ShowNotificationContent($productName,$content ,$id  );
    $table.cell($(this).index() , 2).data('seen');

});
