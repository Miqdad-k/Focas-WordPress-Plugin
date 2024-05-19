<?php
global $wpdb;
$Focas_Customer =  $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` WHERE `Type`='Customer'");
function GetQuery($query)
{
  global $wpdb;
  $get = $wpdb->get_results($query);
  return $get;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">
   
   <style>
      
        ::-webkit-scrollbar-track {
        background-color: #F5F5F5;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 5px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #0b4397;
        }
        #wpfooter
      {
        display: none;
      }
      .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slidertoggle {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slidertoggle:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

.toggleswitch:checked + .slidertoggle {
  background-color: var(--btn-color);
}

.toggleswitch:focus + .slidertoggle {
  box-shadow: 0 0 1px #2196F3;
}

.toggleswitch:checked + .slidertoggle:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded slidertoggles */
.slidertoggle.round {
  border-radius: 34px;
}

.slidertoggle.round:before {
  border-radius: 50%;
}

#wpcontent, #wpfooter{
    margin-left: 140px;
}
    </style>
    
</head>

<body class="Focas" style="background-color:#f0f0f1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row g-1">
                    <div id="product-section" style="transition: all 2s ease;"
                        class="col-lg-8 col-md-12 col-sm-12 res-active">
                        <div class="main-card">
                            <div class="searchbar">
                                <h5>Choose Category</h5>
                                <div class="d-flex justify-content-between align-items-center mob-d-none">
                                    <div class="search-box">
                                        <input class="search-input" type="text" placeholder="Search something..">
                                        <button class="search-btn"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="openbell">
                                        <i onclick="billSection()" class="fa-sharp fa-solid fa-truck-arrow-right"></i>
                                    </div>
                                </div>
                                <form class="search-bar-header tab-d-none">
                                    <input type="text" name="search" placeholder="Search..">
                                    <div class="openbell">
                                        <i onclick="billSection()" class="fa-sharp fa-solid fa-truck-arrow-right"></i>
                                    </div>
                                </form>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="food-item slider" id ="food-item">                                        
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="px-4">
                            <div class="menu-heading">
                                <h5>Products</h5>
                                <!-- <p style="color: gray;">12 Coffee Result</p> -->
                            </div>
                        </div>
                        <div class="row g-3 product-show" id="product-show">
        
                        </div>

                    </div>
                    <div id="billing-section" style="transition: all 2s ease;"
                        class="col-lg-4 col-md-12 col-sm-12 res-tablet-phone-active">
                        <div class="item-card-bill" >
                            <div class="side-cart">
                                <div class="notification-list">
                                    <div onclick="closeBill()" class="notify-bell back-icon">
                                        <i class="fa-sharp fa-solid fa-arrow-left"></i>
                                        <small>Back</small>
                                    </div>
                                    <div class="notify-bell">
                                        <span></span>
                                        <i onclick="notification()" class="fa-sharp fa-solid fa-bell"></i>
                                    </div>
                                    <div class="notification-card">
                                        <div id="notify" class="notification">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img class="img-fluid" src="assets/fries.jpeg" alt="">
                                                <div class="notif-content">
                                                    <p>I'm a Cashier <i class="fa-sharp fa-solid fa-sack-dollar"></i>
                                                    </p>
                                                    <h6><?php echo $user->user_nicename ?></h6>
                                                </div>
                                            </div>
                                            <div class="notif-icon">
                                                <i class="fa-sharp fa-solid fa-xmark" onclick="notify()"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-bill-list">
                                    <h5>Bills</h5>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                        <div class="col-md-3">
                                        <label for="inputprice" class="form-label">Warehouse</label>
                                        </div>
                                        <div class="col-md-9">
                                        <select name="SelectWarehouse" id="SelectWarehouse">
                                            <option value="0">select</option>
                                            <option value="1">Saab</option>
                                            <option value="2">Mercedes</option>
                                            <option value="3">Audi</option>
                                        </select>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                        <label for="inputprice" class="form-label">Barcode</label>
                                        </div>
                                        <div class="col-md-9 mt-2">
                                        <input type="tel" class="form-control" name="BarcodeScan"  id="BarcodeScan" placeholder="Scan Barcode" oninput="BarcodeScan()">
                                        </div>
                                        </div>
                                    </div>
                                     <hr>
                                    <div class="bill-item scrollpage" id="bill-item">
                                        <!-- <div class="bill-list">
                                            <div class="d-flex justify-content-center align-items-start">
                                                <img class="img-fluid" src="https://img.freepik.com/free-photo/chicken-wings-barbecue-sweetly-sour-sauce-picnic-summer-menu-tasty-food-top-view-flat-lay_2829-6471.jpg" alt="">
                                                <div class="bill-content">
                                                    <h6>Owais Ali</h6>
                                                    <div class="bill-input">
                                                        <div style="width: 130px;">
                                                            <button class="btn btnqty"><i
                                                                    class="fa-sharp fa-solid fa-minus"></i></button>
                                                            <input type="tel" value="1" class="inputqty" name="itemqty"
                                                                id="itemqty">
                                                            <button class="btn btnqty"><i
                                                                    class="fa-sharp fa-solid fa-plus"></i></button>
                                                        </div>
                                                        <div>
                                                            <label for="rupee">Rs.</label>
                                                            <input type="tel" value="1966" class="inputqty btnprice"
                                                                name="itemqty" id="itemqty">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="notif-icon">
                                                <i class="fa-sharp fa-solid fa-trash "></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="bill-card">
                                    <div class="bill-amount">
                                        <div style="text-align: left;">
                                            <p>Subtotal:</p>
                                            <!-- <p>Tax (%)</p> -->
                                        </div>
                                        <div style="text-align: right;">
                                            <p id="Subtotal">Rs. 0</p>
                                            <!-- <p>7%</p> -->
                                        </div>
                                    </div>
                                    <div class="bill-amount"
                                        style="border-bottom: 1px solid lightgray; margin-bottom: 10px;">
                                        <div style="text-align: left;">
                                            <p>Discount </p>
                                        </div>
                                        <div style="text-align: right;">
                                        
                                            <input type="tel" value="0" class="inputdiscount" name="inputdiscount"
                                                id="inputdiscount" oninput="Updatedata()">
                                                <b>(%)</b>
                                                <label class="switch" onclick="Updatedata()">
                                                    <input id="toggle" class="toggleswitch" type="checkbox">
                                                    <span class="slidertoggle round"></span>
                                                </label>
                                                <b>(PKR)</b>
                                        </div>
                                    </div>
                                    <div class="bill-amount">
                                        <div style="text-align: left;">
                                            <h5>Grand Total:</h5>
                                        </div>
                                        <div style="text-align: right;">
                                            <h5 id="Grandtotal">Rs. 0</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment">
                                    <h5>Payment Method</h5>
                                    <div class="payment-card">
                                        <div class="payment-mode" onclick="openpopup()">
                                            <i class="fa-sharp fa-solid fa-money-bill-1-wave"></i>
                                            <p>Cash</p>
                                        </div>
                                        <div class="payment-mode">
                                            <i class="fa-sharp fa-solid fa-credit-card"></i>
                                            <p>Credit</p>
                                        </div>
                                        <div class="payment-mode">
                                            <i class="fa-sharp fa-solid fa-qrcode"></i>
                                            <p>QR Code</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>
</html>

 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <input type="hidden" id="ProductListJson" name="ProductListJson"/>
            <input type="hidden" id="PkrOrDiscount" name="PkrOrDiscount"/>
            <input type="hidden" id="SubTotalSave" name="SubTotalSave"/>
            <input type="hidden" id="GrandTotalSave" name="GrandTotalSave"/>
            <input type="hidden" id="PkrOrDiscountValue" name="PkrOrDiscountValue"/>
            <input type="hidden" id="Warehouse" name="Warehouse"/>

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                 <button onclick="closepopup()" type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Bills</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="inputdate" class="form-label mb-2">Amount</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <input id="Amount" name="Amount" type="number" value="0" class="form-control mb-2" oninput="Updatedata()">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="inputdate" class="form-label mb-2">Customer</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="mb-2" name="customer" id="customer"  onchange='CustomerOther()'>
                            <option value="0">Walk in Customer</option>
                            <option value="-1">other</option>
                            <?php
                            foreach ($Focas_Customer as $item)   
                            {
                                echo "<option   value='" . $item->Id . "'>" . $item->Name ."(".$item->PhoneNo.")". "</option>";
                            }
                            ?>
                            </select>
                        </div>
                        <div id="CustomerShow" class="row" style="display: none">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <label for="inputdate" class="form-label mb-2">Name</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input  type="text" name="Name" class="form-control mb-2"  placeholder="Name">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <label for="inputdate" class="form-label mb-2">Phone No</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input  type="tel" name="PhoneNo" class="form-control mb-2"  placeholder="Phone Number">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <label for="inputdate" class="form-label mb-2">Note</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea name="Address"  type="text" class="form-control mb-2"  placeholder="Note"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                         <b><label for="inputdate" class="form-label">Change Return</label></b>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 ">
                            <b> <label id="RemaningAmout"></label></b>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button onclick="closepopup()" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="Submit()" class="btn btn-main"><i class="fa-sharp fa-solid fa-check mx-2"></i> Save</button>
                </div>
            </div>
        
        </div>
    </div>
</div>


<script>
localStorage.clear();

var productlist= JSON.parse(`<?php echo json_encode($ProductList); ?>`);
var Categorylist= JSON.parse(`<?php echo json_encode($Focas_Categories); ?>`);
var term_relationships= JSON.parse(`<?php echo json_encode($term_relationships); ?>`);
window.onload = function() {
  var input = document.getElementById("BarcodeScan").focus();

}
Categorylist.forEach(DisplayCategory);
function DisplayCategory(item)
{
   
   var append= '<div class="item-list" onclick="catagoriesProduct('+item.term_taxonomy_id+')" >'+
                    '<img class="img-fluid" onerror="this.src=`https://www.viewstorm.com/wp-content/uploads/2014/10/default-img.gif`" src="'+item.guid+'" alt="">'+
                    '<label for="itemlabel" class="form-label">'+item.Name+'</label>'+
               '</div>';
               $('#food-item').append(append);
}

function catagoriesProduct(id)
{
    $('#product-show').html("");
function checkid(ids) {return ids.term_taxonomy_id == id;}
 var list =term_relationships.filter(checkid);
 list.forEach(filterProduct);
 
}
function filterProduct(item)
{
    
    function productid(ids) {return ids.Id == item.object_id;}
    var productlistfilter=productlist.filter(productid);
    productlistfilter.forEach(DisplayProduct);
}

productlist.forEach(DisplayProduct);
function DisplayProduct(item)
{
   
    
    var append=   '<div class="col-lg-4 col-md-4 col-sm-12">'+
                    '<div class="item-card">'+
                       ' <div class="row">'+
                            '<div class="item-head">'+
                                '<div class="">'+
                                    '<div class="card-img">'+
                                        '<img onerror="this.src=`https://www.viewstorm.com/wp-content/uploads/2014/10/default-img.gif`" class="img-fluid" src="'+item.Pic+'" alt="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="">'+
                                    '<div class="card-text">'+
                                        '<h4>'+item.ProductName+'</h4>'+
                                        // '<p>This is new pizza flavor launch by Pizza</p>'+
                                        '<label for="inputname" class="form-label mt-2">PKR '+item.FocusProduct.SalePrice+'</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<button class="btn btn-product '+item.Id+' " onclick="AddBill(`'+item.FocusProduct.Barcode+'`)">Add To Biiling</button>'+
                        '</div>'+
                    '</div>'+
                '</div>';
               $('#product-show').append(append);
}
function BarcodeFilter(item)
{
   return item.FocusProduct.Barcode == $('#BarcodeScan').val();
 }
 function AddBill(item)
{   
    $('#BarcodeScan').val(item)
    BarcodeScan()
 }
function BarcodeScan()
{
    var result = productlist.filter(BarcodeFilter);
    if(result.length  > 0)
    {
    var ls= JSON.parse(localStorage.getItem(result[0].FocusProduct.Barcode));
    
    if(ls != null && ls.Barcode == result[0].FocusProduct.Barcode )
    {
        ls.Qty=parseInt(ls.Qty)+1;
        var elem =document.getElementById('Qty-'+result[0].FocusProduct.Barcode);
        $('#Qty-'+ result[0].FocusProduct.Barcode).val(parseInt(elem.value) + 1);
        Updateinput(result[0].FocusProduct.Barcode)
        $('#BarcodeScan').val("")
    }
    else
    {
    
        //, id2: 200, "tag with spaces": 300 ,"Qty":"1","price":result[0].SalePrice,"Barcode"=result[0].Barcode
        var ProductItem = {Id: result[0].Id,Qty: "1",Name:result[0].ProductName ,price: result[0].FocusProduct.SalePrice,Barcode: result[0].FocusProduct.Barcode};
        var AddItem=''+
            '<div class="bill-list" id="p-'+result[0].FocusProduct.Barcode+'">'+
                '<div class="d-flex justify-content-center align-items-start">'+
                    '<img class="img-fluid" src="'+ result[0].Pic +'" alt="' + result[0].ProductName + '">'+
                    '<div class="bill-content">'+
                        '<div class="bill-delete d-flex justify-content-between align-items-center">'+
                        '<h6>' + result[0].ProductName + '</h6>'+
                        '<i class="fa-sharp fa-solid fa-trash " onclick="RemoveProduct(`'+result[0].FocusProduct.Barcode+'`)"></i>'+
                        '</div>'+
                        '<div class="bill-input">'+
                            '<div style="width: 100px;text-align:center;">'+
                                '<button onclick="minusQty(`'+result[0].FocusProduct.Barcode+'`)" class="btn btnqty"><i class="fa-sharp fa-solid fa-minus"></i></button>'+
                                '<input id="Qty-'+result[0].FocusProduct.Barcode+'" type="tel" value="1" class="inputqty" name="itemqty"id="itemqty" oninput="Updateinput(`'+result[0].FocusProduct.Barcode+'`)" style="width:30px;">'+
                                '<button onclick="AddQty(`'+result[0].FocusProduct.Barcode+'`)" class="btn btnqty"><i class="fa-sharp fa-solid fa-plus"></i></button>'+
                            '</div>'+
                            '<div style="width: 160px;text-align:center;">'+
                                '<label for="rupee">Rs.</label>'+
                                '<input id="p_price-'+result[0].FocusProduct.Barcode+'" type="tel" value="' + result[0].FocusProduct.SalePrice + '" class="inputqty btnprice" name="itemqty" id="itemqty" oninput="Updateinput(`'+result[0].FocusProduct.Barcode+'`)">'+
                            '</div>'+
                            '<div style="width: 110px;text-align:center;">'+
                                '<label for="rupee">Total.</label>'+
                                '<label><b id="p_total-'+result[0].FocusProduct.Barcode+'">'+result[0].FocusProduct.SalePrice+'</b></label>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                // '<div class="notif-icon">'+
                //    '<i class="fa-sharp fa-solid fa-trash "></i>'+
                // '</div>'+
            '</div>'+
        '';
        $('#bill-item').append(AddItem);
        $('#BarcodeScan').val("")
        localStorage.setItem(result[0].FocusProduct.Barcode,JSON.stringify(ProductItem));
    
}
Updateinput(result[0].FocusProduct.Barcode);
}
     //var  x= document.getElementById("BarcodeScan").value;
    // var element = document.getElementById(x);
    // if (element !== null ) 
    // {
    // document.getElementById(x).setAttribute("selected", "selected"); 
    // document.getElementById("cmbproduct").setAttribute("disabled", "disabled"); 
    // }
    // else 
    // {
    // document.getElementById("cmbproduct").removeAttribute("disabled"); 
    // }
    
}
function AddQty(code)
{
    
    var elem =document.getElementById('Qty-'+ code);
    $('#Qty-'+ code).val(parseInt(elem.value) + 1);
    // var ls= JSON.parse(localStorage.getItem(code));
    //     ls.Qty=parseInt(elem.value);
    //     localStorage.setItem(code,JSON.stringify(ls));
    //lem.value =parseInt(elem.value)+ 1;
    //var result = productlist.find(x => x.barcode = code)
    //$('#p_total-'+ code).text(parseInt(elem.value) * $('#p_price-'+ code).val() );
    Updateinput(code);
}
function minusQty(code)
{
    var elem =document.getElementById('Qty-'+ code);
    if(parseInt(elem.value) > 0)
    {
        $('#Qty-'+ code).val(parseInt(elem.value) - 1);
        // var ls= JSON.parse(localStorage.getItem(code));
        // ls.Qty=parseInt(elem.value);
        // localStorage.setItem(code,JSON.stringify(ls));
        //var result = productlist.find(x => x.barcode = code)
       // $('#p_total-'+ code).text(parseInt(elem.value) * $('#p_price-'+ code).val() );
       Updateinput(code);
    }
}

function Updateinput(code)
{
    
    var elem =document.getElementById('Qty-'+ code);
    var ls= JSON.parse(localStorage.getItem(code));
        ls.price=$('#p_price-'+ code).val();
        ls.Qty =elem.value
        localStorage.setItem(code,JSON.stringify(ls));
        $('#p_total-'+ code).text(parseInt(elem.value) * $('#p_price-'+ code).val() );

        Updatedata();
    
    
}
function Updatedata()
{

    var keys=Object.keys(localStorage);
    var subtotal=0;
    for(var key of keys){
        var item =JSON.parse(localStorage.getItem(key));
        subtotal+=item.Qty*item.price;
    }
   var discount= parseInt($('#inputdiscount').val());
    var IsDiscount=$('#toggle').is(":checked");
    if(!IsDiscount)
    {
        discount=  (subtotal*discount)/100;
    }
   
   var grandtotal=subtotal-discount;

   $('#Subtotal').text("Rs. "+subtotal);
   $('#Grandtotal').text("Rs. "+grandtotal);
   var amount=$('#Amount').val();

   $('#RemaningAmout').text("Rs. "+(grandtotal-amount));
}
function openpopup()
{
    var keys=Object.keys(localStorage);
    var subtotal=0;
    var Arr = [];
    var count=0;
    for(var key of keys){
        var item =JSON.parse(localStorage.getItem(key));
        Arr[count]=item;
        subtotal+=item.Qty*item.price;
        count++;
    }

    $('#ProductListJson').val(JSON.stringify(Arr));
    $('#SubTotalSave').val(subtotal);
   var discount= parseInt($('#inputdiscount').val());
    $('#PkrOrDiscountValue').val(discount);
    var IsDiscount=$('#toggle').is(":checked");
    $('#PkrOrDiscount').val(IsDiscount);
    $('#Warehouse').val($('#SelectWarehouse').val());
    if(!IsDiscount)
    {
        $('#PkrOrDiscountValue').val(true);
        discount=  (subtotal*discount)/100;
    }
   
   var grandtotal=subtotal-discount;
   $('#GrandTotalSave').val(grandtotal);
   
    $('#myModal').modal('show');


}
function closepopup()
{
    $('#myModal').modal('hide');
}
function RemoveProduct(item)
{
    localStorage.removeItem(item);
    document.getElementById('p-'+item).innerHTML = "";
}

function CustomerOther()
{
    if($('#customer').val()==-1)
    {
        $("#CustomerShow").show();
    }
    else
    {
        $("#CustomerShow").hide();
    }
}
function notify()
{
        $("#notify").hide();
}

var ajaxurl = ajaxurl;
function Submit(action) {
    var Obj = {
        ProductListJson: $('#ProductListJson').val(),
        PkrOrDiscount: $('#PkrOrDiscount').val(),
        SubTotalSave: $('#SubTotalSave').val(),
        GrandTotalSave: $('#GrandTotalSave').val(),
        PkrOrDiscountValue: $('#PkrOrDiscountValue').val(),
        Amount: $('#Amount').val(),
        customer: $('#customer').val(),
        Name: $('#Name').val(),
        PhoneNo: $('#PhoneNo').val(),
        Warehouse: $('#Warehouse').val(),
    }

    if (true) {
        
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'PosList': JSON.stringify(Obj),
                    'action': 'admin_ajax_request' //this is the name of the AJAX method called in WordPress
                }, success: function (result) {
                    window.location.href = "./admin.php?page=pos-List"
                },
                error: function () {
                    console.log("error");
                }
            });
        
    }
    else
        console.log("name is required")
}
</script>