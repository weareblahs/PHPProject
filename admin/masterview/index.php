<?php
$title = '';
require_once '../../elements/layout.php';


function get_content()
{
    function convert_to_currency_format($number)
    {
        $float_value = (float) $number;
        return number_format($float_value, 2, '.', '');
    }
    require_once '../../backend/sql_init.php';
?>
    <div class="container p-2">
        <h1>Issued tickets</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Booking user</th>
                    <th>Movie name</th>
                    <th>Date / time</th>
                    <th>Seats</th>
                    <th>Hall name</th>
                    <th>Total amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tids = mysqli_fetch_all(mysqli_query($cn, "SELECT ticketID FROM tickets"), MYSQLI_ASSOC);
                foreach ($tids as $tid) : ?>
                    <?php
                    $tid = $tid['ticketID'];
                    $userID = mysqli_fetch_all(mysqli_query($cn, "SELECT userID FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['userID'];
                    $username = mysqli_fetch_all(mysqli_query($cn, "SELECT username FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['username'];
                    $fullname = mysqli_fetch_all(mysqli_query($cn, "SELECT firstName FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['firstName'] . " " . mysqli_fetch_all(mysqli_query($cn, "SELECT lastName FROM users WHERE userUniqID = '$userID'"), MYSQLI_ASSOC)[0]['lastName'];
                    $preFN = mysqli_fetch_all(mysqli_query($cn, "SELECT filmID FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['filmID'];
                    $filmName = mysqli_fetch_all(mysqli_query($cn, "SELECT name FROM films WHERE filmID = '$preFN'"), MYSQLI_ASSOC)[0]['name'];
                    $datetime = mysqli_fetch_all(mysqli_query($cn, "SELECT time FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['time'];
                    $seats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC);
                    $preHN = mysqli_fetch_all(mysqli_query($cn, "SELECT assignedShowtimeID FROM assignedseats WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['assignedShowtimeID'];
                    $preHN2 = mysqli_fetch_all(mysqli_query($cn, "SELECT hallID FROM showtimes WHERE showtimeID = '$preHN'"), MYSQLI_ASSOC)[0]['hallID'];
                    $hallName = mysqli_fetch_all(mysqli_query($cn, "SELECT hallName FROM halls WHERE hallUniqID = '$preHN2'"), MYSQLI_ASSOC)[0]['hallName'];
                    $totalAmount = mysqli_fetch_all(mysqli_query($cn, "SELECT totalPrice FROM tickets WHERE ticketID = '$tid'"), MYSQLI_ASSOC)[0]['totalPrice'];
                    ?>
                    <tr>
                        <td class="QR"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $tid ?></td>
                        <td><?php echo $fullname ?> (<?php echo $username ?>)</td>
                        <td><?php echo $filmName ?></td>
                        <td><?php echo date("Y-m-d h:i A", $datetime) ?></td>
                        <td>
                            <?php
                            foreach ($seats as $seat) {
                                echo $seat['seat'] . " ";
                            }
                            ?>
                        </td>
                        <td><?php echo $hallName ?></td>
                        <td>RM<?php echo convert_to_currency_format($totalAmount) ?></td>
                        <td><a href="https://qrcode.tec-it.com/API/QRCode?data=<?php echo $tid ?>" download="qr_<?php echo $tid ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}
?>