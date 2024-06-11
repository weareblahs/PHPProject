<?php
function getSeatmap()
{
    // Change these variables below as an array format. Use "blank" if you want a gap.
    // Add your seat rows and columns here as an array (format: "A", "B", "C", etc...)
    $seatColumns = array();
    $seatRows = array();
    // don't change anything beyond this point to ensure prosperity for your whole family during the next chinese new year
    foreach ($seatColumns as $seatColumn) {
        foreach ($seatRows as $seatRow) {
            if ($seatColumn . $seatRow != $seatColumn . "blank") {
                $seats[] = $seatColumn . $seatRow;
            } else {
                $seats[] = $seatColumn . "_blankseat";
            }
        }
    }

    // get reserved seats
    require_once '../../ticketing/seatSelection/index.php';
    // Change here to connect to your MySQL database (yes, not everything is the same, for my example, I use "mts" as the database)
    $cn = mysqli_connect('127.0.0.1', "root", "", "mts");
    $seatTime = $_GET['time'];
    $showtimeID = $_GET['showtimeID'];

    // functions
    function filter_array($array, $letter)
    {
        $filtered_array = array();
        foreach ($array as $key => $val) {
            if ($val[0] == $letter) {
                $filtered_array[] = $val;
            }
        }
        return $filtered_array;
    }
?>


    <div>
        <div class="w-100" style="color: #ffffff; background-color: #ff0000; padding: 1em">
            <!-- change the styling of "screen" here -->
            <div style="margin-top: auto; margin-bottom: auto; text-align: center">
                <h5>Screen</h5>
            </div>
        </div>
        <!-- ...and do not change anything beyond this point -->
        <table class="table table-dark">
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($seatRows as $seatRow) : ?>
                        <?php if ($seatRow == "blank") : ?>
                            <th></th>
                        <?php else : ?>
                            <th class="text-center"><?php echo $seatRow ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // the below code is the result of https://twitter.com/ThisIsTYX/status/1796328187607298122
                $tempReservedSeats = mysqli_fetch_all(mysqli_query($cn, "SELECT seat FROM assignedseats WHERE assignedShowtimeID = '$showtimeID' AND time = $seatTime;"), MYSQLI_ASSOC);
                if ($tempReservedSeats !== []) {

                    foreach ($tempReservedSeats as $tempReservedSeat) {
                        $TRS[] = $tempReservedSeat['seat'];
                    }
                    foreach ($seatColumns as $seatColumn) {
                        foreach ($seatRows as $seatRow) {
                            foreach ($TRS as $reservedSeat) {
                                $tempSeat = $seatColumn . $seatRow;
                                if ($reservedSeat == $tempSeat) {
                                    if (($key = array_search($reservedSeat, $seats)) !== false) {
                                        $seats[$key] = $tempSeat . "_reserved";
                                    }
                                }
                            }
                        }
                    }

                    foreach ($seatColumns as $seatRows) {
                        echo "<tr></tr>";
                        echo '<td style="margin-top: auto; margin-bottom: auto">' . $seatRows . "</td>";
                        foreach ($seats as $seat) {
                            if ($seat[0] == $seatRows) {
                                if (strpos($seat, "_reserved") !== false) {
                                    echo '<td class="text-center"><span class="reserved"></span></td>';
                                } else {
                                    if (strpos($seat, "_blank") !== false) {
                                        echo "<td></td>";
                                    } else {
                                        echo '<td><input type="checkbox" class="seats" name="seats[]" id="seats[]" value="' . $seat . '"></td>';;
                                    }
                                }
                            }
                        }
                    }
                } else if ($tempReservedSeats == []) {
                    foreach ($seatColumns as $seatColumn) {
                        echo "<tr>";
                        echo "<td>$seatColumn</td>";
                        foreach ($seatRows as $seatRow) {
                            if ($seatRow != "blank") {
                                echo '<td class="text-center"><input type="checkbox" class="seats" name="seats[]" id="seats[]" value="' . $seatColumn . $seatRow . '"></td>';
                            } else {
                                echo "<td></td>";
                            }
                        }
                    }
                }

                echo "</tr>"; ?>

            </tbody>
        </table>
    </div>
<?php
}
?>