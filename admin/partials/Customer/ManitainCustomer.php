<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
</head>

<body style="background-color:#f0f0f1">

    <div class="container-fluid mt-3">
        <div class="container">
            <div class="form-center">
                <div class="form-card mt-4 mb-4">
                    <h3>
                        <?php if (isset($_GET['id']))
                            echo 'Edit';
                        else
                            echo 'Add' ?> Customer Detail
                        </h3>
                    <?php if (!isset($_GET['id'])) { ?>
                        <div class="row g-3" method="POST">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Name<span style="color: red;"> *</span></label>
                                <input required type="text" id="Name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Email</label>
                                <input type="email" id="Email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Phone No</label>
                                <input type="email" id="Phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Address</label>
                                <input type="text" id="Address" class="form-control" placeholder="Address">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="inputprice" class="form-label">Notes</label>
                                <textarea id="Notes" type="text" class="form-control" placeholder="Note"></textarea>
                            </div>
                            <div class="">
                                <div class="btn-layout">
                                    <button name="submit" type="submit" class="btn btn-main" onclick="bthSave('Save')"><i
                                            class="fa-sharp fa-solid fa-check mx-2"></i>Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row g-3" method="POST">
                        <div class="col-lg-6 col-md-6 col-sm-12" hidden>
                                <label for="inputqty" class="form-label">Id</label>
                                <input type="text" value="<?php echo $Customer[0]->Id ?>" id="Id"
                                    class="form-control" >
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Name<span style="color: red;"> *</span></label>
                                <input required type="text" value="<?php echo $Customer[0]->Name ?>" id="Name"
                                    class="form-control" placeholder="Name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Email</label>
                                <input type="email" id="Email" class="form-control" placeholder="Email"
                                    value="<?php echo $Customer[0]->Email ?>">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Phone No</label>
                                <input type="email" id="Phone" class="form-control" placeholder="Phone Number"
                                    value="<?php echo $Customer[0]->Phone ?>">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="inputqty" class="form-label">Address</label>
                                <input type="text" id="Address" class="form-control" placeholder="Address"
                                    value="<?php echo $Customer[0]->Address ?>">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="inputprice" class="form-label">Notes</label>
                                <textarea id="Notes" type="text" class="form-control" placeholder="Note"
                                    value="<?php echo $Customer[0]->Notes ?>"><?php echo $Customer[0]->Notes ?></textarea>
                            </div>
                            <div class="">
                                <div class="btn-layout">
                                    <button name="submit" type="submit" class="btn btn-main" onclick="bthSave('Update')"><i
                                            class="fa-sharp fa-solid fa-check mx-2"></i>Update
                                    </button>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_GET['id'])) { ?>
    <div class="Background-section m-2">
        <h3>Activity </h3>
        <table id="ActivityTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Activity</th>
                    <th>Created on</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($activitylist as $item)
                {
                    echo '<tr>';
                    echo '<td>'.$item->Id.'</td>';
                    echo '<td>'.$item->Activity.'</td>';
                    $utc_datetime = $item->CreatedOn;
                    $utc = new DateTime($utc_datetime, new DateTimeZone('UTC'));
                    $local = $utc;
                    $local->setTimezone(new DateTimeZone(FocasGetTimeZone()));
                    echo '<td>'.$local->format('Y-m-d h:i:s').'</td>';
                    echo '<td><a class="btn btn-edit-outline" href="./admin.php?page=Activity-Log&id='.$item->Id.'" target="_blank"> <i class="fa-sharp fa-solid fa-pen-to-square mx-2"></i>View</a></td>';
                    echo '</tr>';
                }
                ?>
                
                
            </tbody>
        </table>
    </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $('#ActivityTable').DataTable({
        order: [[0, 'desc']],
            columnDefs: [
                {
                    target: 0,
                    visible: false,
                }
            ],
        });

        var ajaxurl = ajaxurl;
        function bthSave(action) {
            var Obj = {
                name: $('#Name').val(),
                email: $('#Email').val(),
                phone: $('#Phone').val(),
                address: $('#Address').val(),
                notes: $('#Notes').val(),
            }

            if (Obj.name != "") {
                if (action == 'Save') {
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            'AddCustomerData': JSON.stringify(Obj),
                            'action': 'admin_ajax_request' //this is the name of the AJAX method called in WordPress
                        }, success: function (result) {
                            window.location.href = "./admin.php?page=Customer-List"
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
                else{
                    Obj.id =  $('#Id').val()
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            'UpdateCustomeData': JSON.stringify(Obj),
                            'action': 'admin_ajax_request' //this is the name of the AJAX method called in WordPress
                        }, success: function (result) {
                            window.location.href = "./admin.php?page=Customer-List"
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
            }
            else
                console.log("name is required")
        }
    </script>
</body>

</html>