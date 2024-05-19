<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
.wp-core-ui select 
{
    padding: 0 24px 0 8px!important;
}
#wpfooter
{
    display:none;
}
</style>
</head>
<body style="background-color:#f0f0f1"> 

    <!--  echo json_encode($products);?> -->
    <div>
        <h1>Products</h1>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 10px; margin-top: -40px;">
           <img class="right" width=150 src="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png" alt="">
        </div>    
</div>   
    <div class="Background-section m-2">
        <table id="DashboardTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Quanity</th>
                    <th>Price</th>
                    <th>Barcode</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($products as $item)
                {
                    echo '<tr>';
                    echo '<td><img onerror="this.src=`https://www.viewstorm.com/wp-content/uploads/2014/10/default-img.gif`" src="' . $item->Pic .'" alt="" width="50" height="60"></td>';
                    echo '<td>'.$item->ProductName.'</td>';
                    $flag="";
                    if($item->FocusProduct->Quantity < 10 && !empty($item->FocusProduct->Id))
                        $flag="text-danger";
                    echo '<td class="'.$flag.'">'.$item->FocusProduct->Quantity.'</td>';
                    echo '<td>'.$item->FocusProduct->SalePrice.'</td>';
                    echo '<td>'.$item->FocusProduct->Barcode.'</td>';
                    if(empty($item->FocusProduct->Barcode))
                    echo '<td class="t-content"><a onclick="AddToInventory('.$item->Id.')" class="btn btn-main-outline"><i class="fa-sharp fa-solid fa-plus mx-2"></i>Add To Inventory</a></td>';
                    else
                        echo '<td><button class="btn btn-edit-outline" onclick="openpopup('.$item->Id.',`'.$item->ProductName.'`,'.$item->FocusProduct->SalePrice.',`'.$item->FocusProduct->Barcode.'`)"><i class="fa-sharp fa-solid fa-pen-to-square mx-2"></i>Edit</button>'.
                        '<a class="btn btn-edit-outline " href="./admin.php?page=Product-Details&id='.$item->FocusProduct->Id.'"><i class="fa-sharp fa-solid fa-info mx-2"></i> Details</a></td>';
                    echo '</tr>';
                }
                ?>
                
                
            </tbody>
        </table>
    </div>
            
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

</body>
</html>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            <input type="hidden" name="Id" id="Id">
             <div class="col-md-3 mb-3">
                <label>Barcode</label>
             </div>
            <div class="col-md-9 mb-3">
                <input type="text" name="Barcode" id="Barcode">
            </div>
            <div class="col-md-3 mb-3">
                <label>Sale Price</label>
             </div>
            <div class="col-md-9 mb-3">
                <input type="number" name="SalePrice" id="SalePrice">
            </div>

        </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <button type="button" onclick="Sumbitpopup()">Save</button>
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>

      </div>

    </div>
  </div>
</div>

<script>
     $('#DashboardTable').DataTable();

    var ajaxurl=ajaxurl;
    
function AddToInventory(Id)
{
    var postdata="action=admin_ajax_request&param=AddToInventory&Id="+Id;
    $.post(ajaxurl,postdata,
          function (data) 
          {
            var Result=JSON.parse(data);
            console.log(data);
            if(Result.Success)
            {
                console.log(Result.Id);
            }
            
          }
        );
}
function openpopup(id,name,price,barcode)
{
    $('#Id').val(id);
    $('#SalePrice').val(price);
    $('#Barcode').val(barcode);
    $('#modal-title').text(name);

    $('#myModal').modal('show');
}
function closepopup()
{
    
    $('#myModal').modal('hide');


}

function Sumbitpopup()
{
     var id=$('#Id').val();
     var saleprice =$('#SalePrice').val();
     var barcode=$('#Barcode').val();

     var postdata="action=admin_ajax_request&param=EditProduct";
        postdata += `&Id=${id}&SalePrice=${saleprice}&Barcode=${barcode}`;

    $.post(ajaxurl,postdata,
          function (data) 
          {
            var Result=JSON.parse(data);
            if(Result.Success)
            {
                console.log(Result.Id);
            }
          }
        );

        
    $('#myModal').modal('hide');
}


</script>