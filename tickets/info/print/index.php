<?php
$tid = $_GET['tid'];
$title = "Ticket information for ticket " . $tid;
require_once '../../../elements/layout.php';

function get_content()
{
    function convert_to_currency_format($number)
    {
        $float_value = (float) $number;
        return number_format($float_value, 2, '.', '');
    }
    $tid = $_GET['tid'];
    require_once '../../../backend/sql_init.php';
    $preGFI = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['filmID'];
    $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$preGFI'"), MYSQLI_ASSOC)[0];
    $datetime = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['time'];
    $showtimeID = mysqli_fetch_all(mysqli_query($cn, "SELECT assignedShowtimeID FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['assignedShowtimeID'];
    $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0];
    $firstPageTotal = mysqli_fetch_all(mysqli_query($cn, "SELECT totalPrice FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['totalPrice'];
?>

    <div class="exclude-from-print p-5 container">
        <h1 class="text-center">Print window should load immediately.</h1>
        <h3 class="text-center">If the print window is not loading, please click on the button below or use Ctrl+P or Cmd+P to print. Alternatively, click the button below:</h3>
        <center>
            <button class="w-50 btn btn-success" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print receipt</button>
        </center>
    </div>


    <!-- page 1: qr -->
    <div class="container exclude-from-screen" data-bs-theme="light" style="color: black">
        <!-- page 1: qr code and basic info -->
        <div class="container p-5">
            <center>
                <div class="p-5" style="border: 5px solid black">
                    <h4>QR Ticket:</h4>
                    <img src="https://qrcode.tec-it.com/API/QRCode?data=<?php echo $tid ?>" alt="" class="img-responsive" width="80%">
                    <h1 class="QR"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $tid ?></h1>
                </div>

                <p><i>Please show this code for validation.</i></p>

                <div>
                    <h4>Information</h4>
                </div>
                <table class="table table-striped-columns w-100">
                    <tbody>
                        <tr>
                            <td>Movie name</td>
                            <td><?php echo $filmInfo['name'] ?></td>
                        </tr>
                        <tr>
                            <td>Selected date</td>
                            <td><?php echo date("Y-m-d", $datetime) ?></td>
                        </tr>
                        <tr>
                            <td>Selected time</td>
                            <td><?php echo date("h:i A", $datetime) ?></td>
                        </tr>
                        <tr>
                            <td>Hall</td>
                            <td><?php
                                $hallID = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
                                echo mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$hallID'"), MYSQLI_ASSOC)[0]['hallName'] ?></td>
                        </tr>
                        <tr>
                            <td>Selected seats</td>
                            <td>
                                <?php
                                foreach ($seats as $seat) {
                                    echo $seat . " ";
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <center>
                    <h4>Total amount: RM<?php echo convert_to_currency_format($firstPageTotal) ?></h4>
                    <h5><i>For receipt, see next page</i></h5>
                </center>

            </center>
        </div>
        <div class="container p-2" style="page-break-before: always;">
            <div class="container">
                <!-- receipt -->
                <h2 class="text-center">Receipt</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Particulars</th>
                            <th class="text-startP">Quantity</th>
                            <th class="text-end">Price (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- seating part -->
                        <tr>
                            <th colspan="3" class="text-center" style="background-color: lightgray;"><b>Seats</b></th>
                        </tr>
                        <?php
                        $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC);
                        $showtimeID = mysqli_fetch_all(mysqli_query($cn, "SELECT assignedShowtimeID FROM assignedSeats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['assignedShowtimeID'];
                        $preHallExperienceInfo1 = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
                        $preHallExperienceInfo2 = mysqli_fetch_all(mysqli_query($cn, "SELECT experienceID FROM halls WHERE hallUniqID = '$preHallExperienceInfo1'"), MYSQLI_ASSOC)[0]['experienceID'];
                        $hallExperienceInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM cinemaexperiences WHERE uniqID = '$preHallExperienceInfo2'"), MYSQLI_ASSOC)[0];
                        $totalPrice = 0;
                        foreach ($seats as $seat) {
                            echo '<tr>';
                            echo '<td>' . $hallExperienceInfo['name'] . ' (Seat ' . $seat['seat'] . ')</td>';
                            echo '<td>1</td>';
                            echo '<td class="finalPricing">' . convert_to_currency_format($hallExperienceInfo['ticketPrice']) . '</td>';
                            $totalPrice += $hallExperienceInfo['ticketPrice'];
                            echo '</tr>';
                        }
                        ?>

                        <?php
                        $addonID = mysqli_fetch_all(mysqli_query($cn, "SELECT addonID FROM tickets WHERE ticketID = $tid"),  MYSQLI_ASSOC)[0]['addonID'];
                        $addons = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM addonorders WHERE addonOrderID = '$addonID'"), MYSQLI_ASSOC);
                        if ($addons !== []) {
                            echo '<tr>
                                      <th colspan="3" class="text-center" style="background-color: lightgray;"><b>Addons</b></th>
                                  </tr>';
                            foreach ($addons as $addon) {
                                // locate addon properties
                                $addonID = $addon['addonID'];
                                $addonProps = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM addon WHERE addonUniqID = '$addonID'"), MYSQLI_ASSOC)[0];
                                echo '<tr>';
                                echo '<td>' . $addonProps['addonName'] . '</td>';
                                echo '<td>' . $addon['addonQuantity'] . '</td>';
                                $finalAddonPricing = $addonProps['addonPrice'] * $addon['addonQuantity'];
                                echo '<td class="finalPricing">' . convert_to_currency_format($finalAddonPricing) . '</td>';
                                $totalPrice += $finalAddonPricing;
                                echo '</tr>';
                            }
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td colspan="1" class="text-center" style="background-color: lightgray;"><b>Total</b></td>
                            <td class="text-end finalPricing"><?php echo convert_to_currency_format($totalPrice) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
<?php

}

?>