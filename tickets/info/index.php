<?php
$tid = $_GET['tid'];
$title = "Ticket information for ticket " . $tid;
require_once '../../elements/layout.php';

function get_content()
{
    function convert_to_currency_format($number)
    {
        $float_value = (float) $number;
        return number_format($float_value, 2, '.', '');
    }
    $tid = $_GET['tid'];
    require_once '../../backend/sql_init.php';
?>

    <div class="container p-2">
        <h1>Ticket details</h1>
        <div class="row container">
            <div class="col-lg-5 col-sm-12">
                <?php
                $fid = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['filmID'];
                $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$fid'"), MYSQLI_ASSOC)[0];
                ?>
                <h2>Information</h2>
                <div class="row">
                    <div class="col-1" style="margin-top: auto; margin-bottom: auto">
                        <h1><i class="fa fa-film" aria-hidden="true"></i></h1>
                    </div>
                    <div class="col-11">
                        <h4><?php echo $filmInfo['name'] ?></h4>
                        <?php
                        if (strlen($filmInfo['altName']) > 0) {
                            echo "<h6><i>" . $filmInfo['altName'] . "</i></h6>";
                        } else {
                        }
                        ?>
                    </div>
                </div>
                <a href="/filmDetails?id=<?php echo $fid ?>" class="btn btn-success w-100"><i class="fa fa-info-circle" aria-hidden="true"></i> View information</a>
                <div>
                    <h5 class="my-2">Selected seats</h5>
                    <div class="d-flex row">
                        <?php
                        $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC);
                        foreach ($seats as $seat) :
                        ?>
                            <h3 class="label col-3 text-center"><span class="badge text-bg-primary mx-2"><?php echo $seat['seat'] ?></span></h3>
                        <?php endforeach; ?>
                        <?php
                        $datetime = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['time'];
                        ?>
                    </div>
                    <div class="center-div">
                        <h5 class="text-center">Date</h5>
                        <h1> <?php echo date("d M Y", $datetime) ?></h1>
                    </div>
                    <div class="center-div">
                        <h5 class="text-center">Time</h5>
                        <h1> <?php echo date("h:i A", $datetime) ?></h1>
                    </div>
                    <a href="/tickets/info/print?tid=<?php echo $tid ?>" class="btn btn-success w-100"><i class="fa fa-print" aria-hidden="true"></i> Print or save ticket</a>
                </div>
            </div>

            <div class="col-lg-7 col-sm-12">
                <!-- receipt -->
                <h2>Receipt</h2>
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
                            <th colspan="3" class="text-center" style="background-color: lightgray; color: black"><b>Seats</b></th>
                        </tr>
                        <?php
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
                                      <th colspan="3" class="text-center" style="background-color: lightgray; color: black"><b>Addons</b></th>
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
                            <td colspan="1" class="text-center" style="background-color: lightgray; color: black"><b>Total</b></td>
                            <td class="text-end finalPricing"><?php echo convert_to_currency_format($totalPrice) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php

}

?>