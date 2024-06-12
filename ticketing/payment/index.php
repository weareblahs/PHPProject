<?php

$title = 'Payment';
require_once '../../elements/layout.php';

function get_content()
{
    require_once '../../backend/optionalTextStrings.php';
    $date = $_POST['date'];
    $filmID = $_POST['filmID'];
    $showtimeID = $_POST['showtimeID'];
    $seats = $_POST['seats'];
    $time = $_POST['time'];
    $addons = $_POST['productProperties'];
    // get required stuff
    require_once '../../backend/sql_init.php';
    $filmInfo = mysqli_fetch_all(mysqli_query($cn, "SELECT * FROM films WHERE filmID = '$filmID'"), MYSQLI_ASSOC)[0];
    $hallID = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$showtimeID'"), MYSQLI_ASSOC)[0]['hallID'];
    // "session remembering so it can be used later on"
    $_SESSION['filmTicketing']['date'] = $date;
    $_SESSION['filmTicketing']['filmID'] = $filmID;
    $_SESSION['filmTicketing']['showtimeID'] = $showtimeID;
    $_SESSION['filmTicketing']['seats'] = $seats;
    $_SESSION['filmTicketing']['time'] = $time;
    $_SESSION['filmTicketing']['addons'] = $addons;
    $_SESSION['filmTicketing']['experienceID'] = mysqli_fetch_all(mysqli_query($cn, "SELECT experienceID FROM halls WHERE hallUniqID = '$hallID'"), MYSQLI_ASSOC)[0]['experienceID'];
    // thanks, google gemini
    function convert_to_currency_format($number)
    {
        $float_value = (float) $number;
        return number_format($float_value, 2, '.', '');
    }

    $ticketID = rand(10000000, 99999999);
    $_SESSION['filmTicketing']['ticketID'] = $ticketID;
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
                    <i class="current-fill bi bi-4-circle-fill"></i>
            </div>
            </h1>
            <div class="">
                <div class="row">
                    <div class="col-5 text-end"><img src="<?php echo $filmInfo['imagePosterPath'] ?>" alt="" class="img-responsive" width="100px"></div>
                    <div class="col-7 d-block" style="margin-top: auto; margin-bottom: auto">
                        <h1><?php echo $filmInfo['name'] ?></h1>
                        <div class="d-flex">
                            <div style="width:55px;"><img src="/assets_public/images/filmRatings/<?php echo $filmInfo['filmRating'] ?>.png" alt="" style="margin-left: auto; margin-right: auto" class="img-responsive" width="40px"></div>
                            <div style="margin-top: auto; margin-bottom: auto">
                                <h6><?php echo $filmInfo['filmGenre'] ?> | <i class="bi bi-volume-up-fill"></i> <?php echo $filmInfo['language'] ?><br><i class="fa-regular fa-closed-captioning"></i> <?php echo $filmInfo['subtitle'] ?> | <i class="fa fa-clock" aria-hidden="true"></i> <?php echo $filmInfo['length'] ?> minutes</h6>
                            </div>
                        </div>
                        <p class=""><i class="fa fa-calendar" aria-hidden="true"></i> <i>Currently booking tickets for <?php $timeStr = strtotime($date);
                                                                                                                        echo date("d M Y", $timeStr) ?></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- payment -->
    <form action="/backend/gateway" method="POST">
        <div class="container p-3">
            <div class="row">
                <div class="col-6">
                    <h6>Summary</h6>
                    <p><i>Please check if the information below is correct before finalizing your ticket booking.</i></p>
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

                    <?php if (isset($_COOKIE['userID'])) : ?>
                        <div>
                            <h4>Personal information</h4>
                            <p>Some information are automatically inserted according to your profile information. You can change it if you want.</p>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="firstName" value="
                            <?php
                            $userID = $_COOKIE['userID'];
                            $process =  mysqli_fetch_all(mysqli_query($cn, "SELECT firstName FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['firstName'];
                            echo preg_replace('/\s+/', ' ', $process);
                            ?>">
                                    <label for="floatingInput">First name</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="lastName" value="
                            <?php
                            $userID = $_COOKIE['userID'];
                            $target = mysqli_fetch_all(mysqli_query($cn, "SELECT lastName FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['lastName'];
                            echo preg_replace('/\s+/', ' ', $target);
                            ?>">
                                    <label for="floatingInput">Last name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email" value="
                            <?php
                            $userID = $_COOKIE['userID'];
                            echo mysqli_fetch_all(mysqli_query($cn, "SELECT email FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['email'];
                            ?>">
                            <label for="floatingInput">Email</label>
                        </div>
                        <input type="hidden" name="isGuest" value="0">
                    <?php else : ?>
                        <div>
                            <h4>Personal information</h4>
                            <p>It seems that you are a guest. To continue, please fill in your personal information.</p>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="firstName" value="">
                                    <label for="floatingInput">First name</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="lastName" value="">
                                    <label for="floatingInput">Last name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email" value="">
                            <label for="floatingInput">Email</label>
                        </div>
                        <input type="hidden" name="isGuest" value="1">
                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <h4>Payment summary</h4>
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

                    <!-- stuff to pass to the payment processor -->
                    <input type="hidden" name="amount" value="<?php echo $totalAmount ?>">
                    <input type="hidden" name="ticketID" value="<?php echo $ticketID ?>">
                    <!-- stuff to pass to the processing / update form -->
                    <button class="btn btn-success w-100">Proceed to Payment</button>
                </div>

            </div>

    </form>
    </div>
<?php
}
?>