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
        <h1>Products Details</h1>
        <div style="display: flex;justify-content: end;align-items: center;margin-bottom: 10px; margin-top: -40px;">
           <img class="right" width=150 src="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png" alt="">
        </div>    
</div>   
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
    <?php
date_default_timezone_set('Asia/Karachi');
$utc_datetime = "2023-02-04 10:03:48";
$utc_timestamp = strtotime($utc_datetime);
$local_datetime = date('Y-m-d H:i:s', $utc_timestamp);
echo $local_datetime;
?>

            
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

</body>
</html>
<script>
     $('#ActivityTable').DataTable({
        order: [[1, 'desc']],
            columnDefs: [
                {
                    target: 0,
                    visible: false,
                }
            ],
        });
</script>