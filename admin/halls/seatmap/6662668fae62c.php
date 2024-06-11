<?php
function getSeatmap()
{
    // Change here. Due to some reasons = "$seatColumns" is for rows while "$seatRows" is for columns
    $seatColumns = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O");
    $seatRows = array("1", "2", "3", "4", "5", "6", "blank", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "blank", "27", "28", "29", "30", "31", "32");
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
            <div style="margin-top: auto; margin-bottom: auto; text-align: center">
                <h5>Screen</h5>
            </div>
        </div>
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
                        echo '<td style="margin-top: auto; margin-bottom: auto">'  . $seatRows . "</td>";
                        foreach ($seats as $seat) {
                            if ($seat[0] == $seatRows) {
                                if (strpos($seat, "_reserved") !== false) {
                                    echo '<td class="text-center"><span class="reserved"></span></td>';
                                } else {
                                    if (strpos($seat, "_blank") !== false) {
                                        echo "<td></td>";
                                    } else {
                                        echo '<td class="text-center"><input type="checkbox" class="seats" name="seats[]" id="seats[]" value="' . $seat . '"></td>';;
                                    }
                                }
                            }
                        }
                    }
                } else if ($tempReservedSeats == []) {
                    foreach ($seatColumns as $seatColumn) {
                        echo "<tr>";
                        echo '<td><span style="margin-top: auto; margin-bottom: auto">' . $seatColumn . "</span></td>";
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