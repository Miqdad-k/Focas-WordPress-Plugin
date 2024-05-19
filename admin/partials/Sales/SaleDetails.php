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
        .wp-core-ui select {
            padding: 0 24px 0 8px !important;
        }

        #wpfooter {
            display: none;
        }
    </style>
</head>
<body style="background-color:#f0f0f1">
    <div>
        <h1>OutBound Details</h1>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 10px; margin-top: -40px;">
            <img class="right" width=150 src="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png" alt="">
        </div>
    </div>
    <div class="Background-section m-2">
        <div >
            <div class="row">
                <div class="col-md-3">
                    <label>Invoice No :<label>
                </div>
                <div class="col-md-9">
                    <label><?php echo $Sale->InvoiceNo ?><label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>Status :<label>
                </div>
                <div class="col-md-9">
                    <label><?php echo $Sale->SaleStatus ?><label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>Payment mode :<label>
                </div>
                <div class="col-md-9">
                    <label><?php echo $Sale->PaymentMode ?><label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>Sub total amount :<label>
                </div>
                <div class="col-md-9">
                    <label><?php echo $Sale->SubTotal ?><label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>Discount :<label>
                </div>
                <div class="col-md-9">
                    <label><?php echo $Sale->PkrOrDiscount ?><label>
                </div>
            </div>
            <?php
            if(Count($warehouse) > 0)
            {
            ?>
                <div class="row">
                    <div class="col-md-3">
                        <label>Warehouse :<label>
                    </div>
                    <div class="col-md-9">
                        <label><?php echo $warehouse[0]->Name ?><label>
                    </div>
               </div>
        <?php
        }
        ?>
            
        </div>
    </div>

    <div class="Background-section m-2">
        <h3>Purchase order </h3>
        <div class="row">
            <div class="col-md-3">
                <label>Total amount :<label>
            </div>
            <div class="col-md-9">
                <label id="GrandTotal"><?php echo $Sale->GrandTotal ?><label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Total Paid :<label>
            </div>
            <div class="col-md-9">
                <label id="TotalPaid"><label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Remaining amount :<label>
            </div>
            <div class="col-md-9">
                <label id="RemainingAmount"><label>
            </div>
        </div>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 50px;">
            <a onclick="openpopup()" class="btn btn-main-outline"><i
                    class="fa-sharp fa-solid fa-plus mx-2"></i> Add</a>
        </div>
        <table id="PurchaseOrderTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>PoDate</th>
                    <th>Price</th>
                    <th>Approve</th>
                    <th>CreatedOn</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</body>
</html>

<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                 <button onclick="closepopup()" type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Bills</h4>
                </div>
                <div class="modal-body">
                <input type="hidden" id="Id" name="Id" value="0">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>Price</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="Price" name="Price">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>Approve</label>
                    </div>
                    <div class="col-md-6">
                        <input type="checkbox" id="Approve" name="Approve" >
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>PoDate</label>
                    </div>
                    <div class="col-md-6">
                        <input type="datetime-local" id="PoDate" name="PoDate">
                    </div>
                </div>
                
                </div>
            
                <div class="modal-footer">
                    <button onclick="closepopup()" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="Submit()" class="btn btn-main"><i class="fa-sharp fa-solid fa-check mx-2"></i> Submit</button>
                </div>
            </div>
        
        </div>
    </div>
</div>

<script>
     var postdata="action=admin_ajax_request&param=PurchaseOrderTotal&Id=<?php echo $Sale->Id?>";
    $.post(ajaxurl,postdata,
          function (data) 
          {
            var Result=JSON.parse(data);
            if(Result.Success)
            {  
                $('#TotalPaid').text(Result.Total);
                var total=$('#GrandTotal').text();
                $('#RemainingAmount').text(parseInt(total)-parseInt(Result.Total));
            }
            
          }
        );
    
    $.fn.dataTable.ext.errMode = 'none';
    var ajaxurl = ajaxurl;
    setTimeout(() => {
        var table = $('#PurchaseOrderTable').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxurl + '?action=admin_ajax_request&param=PurchaseOrderDatatable&Id=<?php echo $Sale->Id?>',
                type: "GET",
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    defaultContent: `<button id="editPurchaseOrder" class="btn btn-main-outline">Edit</button>`,
                    render: function ( data, type, full, meta ) {
                     if(full[3]==1)
                     {
                        return "";
                     }
                     else
                     {
                        return '<button onclick="openpopup(`'+full[0]+'`,`'+full[2]+'`,`'+full[1]+'`)" id="editPurchaseOrder" class="btn btn-main-outline">Edit</button>';
                     }
                    }
                },
                {
                    target: 0,
                    visible: false,
                }
            ],
        });

    }, 500)

function openpopup(id,price,poDate)
{
    $('#Id').val(id);
    $('#Price').val(price);
    $('#PoDate').val(poDate);
    $('#myModal').modal('show');
}
function closepopup()
{
    $('#myModal').modal('hide');
}
var SaleId=<?php echo $Sale->Id ?>;
var CustomerId =<?php echo $Sale->CustomerId ?>;
function Submit()
{
    var Obj = {
     Id:$('#Id').val(),
     Price:$('#Price').val(),
     PoDate:$('#PoDate').val(),
     Approve:$('#Approve').is(":checked"),
     SaleId: SaleId,
     CustomerId: CustomerId

               }
    

    $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'AddUpdatePurchaseOrder': JSON.stringify(Obj),
            'action': 'admin_ajax_request' //this is the name of the AJAX method called in WordPress
        }, success: function (result) {
            window.location.href = "./admin.php?page=OutBound-List"
        },
        error: function () {
            console.log("error");
        }
    });


}
</script>