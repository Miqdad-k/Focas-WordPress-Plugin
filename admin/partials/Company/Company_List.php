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

    <!--  echo json_encode($products);?> -->
    <div>
        <h1>Company</h1>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 50px;">
            <a class="btn btn-main-outline" href="./admin.php?page=Maintain-Company"><i
                    class="fa-sharp fa-solid fa-plus mx-2"></i> Add</a>
        </div>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 10px; margin-top: -40px;">
            <img class="right" width=150 src="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png" alt="">
        </div>
    </div>
    <div class="Background-section m-2">
        <table id="Company_data" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Company</th>
                    <th>Action</th>
                </tr>
            </thead>

        </table>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

</body>

</html>

<script>
    $.fn.dataTable.ext.errMode = 'none';
    var ajaxurl = ajaxurl;
    setTimeout(() => {
        var table = $('#Company_data').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxurl + '?action=admin_ajax_request&param=CompanyDatatable',
                type: "GET",
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    defaultContent: `<button id="editCompany" class="btn btn-main-outline">Edit</button>
                    <button id="dltCompany" class="btn btn-main-outline">Delete</button>`,
                },
                {
                    target: 0,
                    visible: false,
                }
            ],
        });

        $('#Company_data tbody').on('click', '#editCompany', function () {
            var data = table.row($(this).parents('tr')).data();
            window.location.href = "./admin.php?page=Maintain-Company&id=" + data[0];
        });
        $('#Company_data tbody').on('click', '#dltCompany', function () {
            var data = table.row($(this).parents('tr')).data();
            var postdata = "action=admin_ajax_request&param=DeleteCompany&Id=" + data[0];
            $.post(ajaxurl, postdata,
                function (data) {
                    var Result = JSON.parse(data);
                    console.log(data);
                    if (Result.Success) {
                        window.location.href = ""
                    }
                }
            );
        });
    }, 500)
</script>