<?php

$title = 'Order successful';
require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/optionalTextStrings.php';
    $ticketingBase = $_SESSION['filmTicketing'];
    $date = $ticketingBase['date'];
    $filmID = $ticketingBase['filmID'];
    $showtimeID = $ticketingBase['showtimeID'];
    $seats = $ticketingBase['seats'];
    $time = $ticketingBase['time'];
    $addons = $ticketingBase['addons'];
    // get required stuff
    require_once '../../backend/sql_init.php';
    $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0];
    $hallID = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
    // thanks, google gemini
    function convert_to_currency_format($number)
    {
        $float_value = (float) $number;
        return number_format($float_value, 2, '.', '');
    }

    $ticketID = $_GET['tid'];
?>

    <div class="bg-dark">
        <div class="container" style="color: #ffffff;">
            <div class="text-center center-div d-flex">
                <h1 class="text-center">
                    <i class="previous-fill bi bi-1-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="previous-fill bi bi-2-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="previous-fill bi bi-3-circle-fill"></i>
                    <i class="previous-fill bi bi-caret-right-fill"></i>
                    <i class="previous-fill bi bi-4-circle-fill"></i>
            </div>
            </h1>
            <div class="row center-div">
                <div class="col-2"><img src="<?php echo $filmInfo['imagePosterPath'] ?>" alt="" class="img-responsive" width="100px"></div>
                <div class="col-10" class="d-flex" style="margin-top: auto; margin-bottom: auto">
                    <h1><?php echo $filmInfo['name'] ?></h1>
                    <div class="d-flex">
                        <div style="width:55px;"><img src="/assets_public/images/filmRatings/<?php echo $filmInfo['filmRating'] ?>.png" alt="" style="margin-left: auto; margin-right: auto" class="img-responsive" width="40px"></div>
                        <div style="margin-top: auto; margin-bottom: auto">
                            <h6><?php echo $filmInfo['filmGenre'] ?> | <i class="bi bi-volume-up-fill"></i> <?php echo $filmInfo['language'] ?><br><i class="fa-regular fa-closed-captioning"></i> <?php echo $filmInfo['subtitle'] ?> | <i class="fa fa-clock" aria-hidden="true"></i> <?php echo $filmInfo['length'] ?> minutes</h6>
                        </div>
                    </div>
                    <p class="center-div"><i class="fa fa-calendar" aria-hidden="true"></i> <i>Currently booking tickets for <?php $timeStr = strtotime($date);
                                                                                                                                echo date("d M Y", $timeStr) ?></i></p>
                </div>
            </div>
        </div>
    </div>

    <!-- success -->
    <?php if (isset($_COOKIE['userID'])) : ?>
        <center>
            <div class="container p-5">
                <h1 class="previous-fill" style="font-size: 5em"><i class="fa-solid fa-circle-check"></i></h1>
                <h1>Booking successful</h1>
                <div class="row w-75">
                    <div class="col-6" style="margin-top: auto; margin-bottom: auto">
                        <h5 class="text-center">You can print or save the tickets by clicking on the button below.</h5>
                        <a href="/ticketing/success/print?tid=<?php echo $ticketID ?>" class="w-100 btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> Print or save ticket</a>
                    </div>
                    <div class="col-6">
                        <h5 class="text-center">All your tickets has been stored in the "My tickets" section. Click to access the page.</h5>
                        <a href="/tickets" class="w-100 btn btn-success"><i class="fa fa-ticket" aria-hidden="true"></i> Manage my tickets</a>
                    </div>
                </div>
            </div>
        </center>
    <?php else : ?>
        <center>
            <div class="container p-5">
                <h1 class="previous-fill" style="font-size: 5em"><i class="fa-solid fa-circle-check"></i></h1>
                <h1>Booking successful</h1>
                <div class="row w-75">
                    <div class="col-12" style="margin-top: auto; margin-bottom: auto">
                        <h5 class="text-center">You can print or save the tickets by clicking on the button below.</h5>
                        <a href="/ticketing/success/print?tid=<?php echo $ticketID ?>" class="w-100 btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> Print or save ticket</a>
                        <h6 class="text-center"><i>As you are booking as a guest, please save the ticket as a file for future usage by clicking on the button above.</i></h6>
                    </div>
                </div>
            </div>
        </center>
    <?php endif; ?>
    <div class="container p-3">
        <div class="row">
            <div class="col-6">
                <h4>Information</h4>
                <table class="table table-striped-columns">
                    <tbody>
                        <tr>
                            <td>Movie name</td>
                            <td><?php echo $filmInfo['name'] ?></td>
                        </tr>
                        <tr>
                            <td>Selected date</td>
                            <td><?php echo $date ?></td>
                        </tr>
                        <tr>
                            <td>Selected time</td>
                            <td><?php echo date("h:i A", $time) ?></td>
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

            </div>
            <div class="col-6">
                <h4>Receipt</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price (RM)</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $totalAmount = 0;
                        foreach ($seats as $seat) {
                            $experienceID = mysqli_fetch_all(mysqli_query($cn, "SELECT experienceID FROM halls WHERE hallUniqID = '$hallID'"), MYSQLI_ASSOC)[0]['experienceID'];
                            $ticketAmount = mysqli_fetch_all(mysqli_query($cn, "SELECT ticketPrice FROM cinemaexperiences WHERE uniqID = '$experienceID'"), MYSQLI_ASSOC)[0]['ticketPrice'];
                            $experienceName = mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM cinemaexperiences WHERE uniqID = '$experienceID'"), MYSQLI_ASSOC)[0]['name'];
                            echo "<tr>";
                            echo "<td>" . $experienceName . " (seat " . $seat . ")</td>";
                            echo "<td>1</td>";
                            echo '<td class="finalPricing">' . convert_to_currency_format($ticketAmount) . "</td>";
                            echo "</tr>";
                            $totalAmount += $ticketAmount;
                        }
                        foreach ($addons as $addon) {
                            $addonID = $addon["'name'"];
                            $addonQuantity = $addon["'quantity'"];
                            if ($addonQuantity != 0) {
                                $itemName = mysqli_fetch_all(mysqli_query($cn, "SELECT addonName FROM addon WHERE addonUniqID = '$addonID'", MYSQLI_ASSOC))[0][0];
                                $itemPrice = mysqli_fetch_all(mysqli_query($cn, "SELECT addonPrice FROM addon WHERE addonUniqID = '$addonID'", MYSQLI_ASSOC))[0][0];
                                $addonTotalAmount = intval($itemPrice) * intval($addonQuantity);
                                echo "<tr>";
                                echo "<td>" . $itemName . "</td>";
                                echo "<td>" . $addonQuantity . "</td>";
                                echo '<td class="finalPricing">' . convert_to_currency_format($addonTotalAmount) . "</td>";
                                echo "</tr>";
                                $totalAmount += $addonTotalAmount;
                            } else {
                            }
                        }
                        if ($totalAmount > 0) {
                            echo "<tr>";
                            echo '<td><i>Ticket ID: <span class="finalPricing">' . $ticketID . '</span></i></td>';
                            echo "<td><b>Total</b></td>";
                            echo '<td class="finalPricing">' . convert_to_currency_format($totalAmount) . "</td>";
                            echo "</tr>";
                            $_SESSION['filmTicketing']['totalAmount'] = $totalAmount;
                        }
                        ?>
                    </tbody>
                </table>
                <!-- payment gateway options can be set at /backend/gateway/index.php -->
                <div class="p-2 center-div">
                    <?php echo $paymentText ?>
                    <div class="p-2"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>