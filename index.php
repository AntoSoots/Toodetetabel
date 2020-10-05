<?php
require_once 'connection.php';

error_reporting(E_ERROR);
$error = error_get_last();
if ($error['type'] === E_ERROR) {
    location . reload();
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$per_page = 50;
$offset = ($page) * $per_page;
$total_items = count($result1);
$total_pages = ceil($total_items / $per_page);
$min_per_page = ($offset - $per_page);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>VeebiApp</title>
    <style>
        .hide {
            display: none;
        }

        .table:active {
            cursor: wait;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nimi</th>
                    <th>Tootekood</th>
                    <th>EAN</th>
                    <th>Tootja</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($jrk = $min_per_page; $jrk < $offset; $jrk++) { ?>
                    <tr role="button" class="table" data-toggle="modal" data-target="#orderModal">
                        <th scope="row"><?php print_r(($jrk + 1)) ?></th>
                        <td><?php print_r(isset($result1[$jrk]['name']['et']) ? $result1[$jrk]['name']['et'] : ""); ?></td>
                        <td><?php print_r(isset($result1[$jrk]['reference']) ? $result1[$jrk]['reference'] : ""); ?></td>
                        <td><?php print_r(isset($result1[$jrk]['barcodes'][0]) ? $result1[$jrk]['barcodes'][0] : ""); ?></td>
                        <td><?php print_r(isset($result1[$jrk]['brand']['name']) ? $result1[$jrk]['brand']['name'] : ""); ?></td>
                        <td class="hide"><?php print_r(isset($result1[$jrk]['_links']['resources']) ? $result1[$jrk]['_links']['resources'] : ""); ?></td>
                        <td class="hide"><?php print_r(isset($result1[$jrk]['_links']['stock']) ? $result1[$jrk]['_links']['stock'] : ""); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $(".modal").on("hidden.bs.modal", function() {
                $(".modal-body").html("Laadin...");
            });
            $("tr.table").click(function() {
                var tableData = $(this).children("td").map(function() {
                    return $(this).text();
                }).get();
                var resoursesid = $.trim(tableData[4]);
                var stockid = $.trim(tableData[5]);

                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        resourses: resoursesid,
                        stock: stockid
                    },
                    success: function(result) {
                        $("#orderDetails").html(result);
                    },
                    error: function(error) {
                        $("#orderDetails").html(error);
                    }
                });
            });
        });
    </script>
    <div id="orderModal" class="modal fade" role="dialog" aria-labelledby="orderModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="orderDetails" class="modal-body">Laadin...</div>
                <div class="modal-footer">
                    <button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php $range = 8;
        if ($page > 1) {
            echo "<a href='index.php?page=1' class='btn btn-danger'>Esimene</a>";
        }
        for ($pagination = ($page - $range); $pagination < (($page + $range) + 1); $pagination++) {
            if (($pagination > 0) && ($pagination <= $total_pages)) {
                if ($pagination == $page) {
                    echo " <a href='' class='btn btn-success'>$pagination</a> ";
                } else {
                    echo " <a href='index.php?page=" . $pagination . "' class='btn btn-primary'>$pagination</a> ";
                }
            }
        }
        if ($total_pages > $page) {
            echo "<a href='index.php?page=" . ($total_pages) . "' class='btn btn-danger'>Viimane</a>";
        } ?>
    </footer>
</body>

</html>