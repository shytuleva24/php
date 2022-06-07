<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Графік чергування студентів 1-го курсу</title>
</head>
<body>
    <form action="index.php" method="POST">
        <div class="table table-statistics">
            <table class="table">
                    <thead>
                        <tr>
                            <th rowspan="2">Ім'я</th>
                            <th rowspan="2">№ Группи</th>
                            <th colspan="5">Графік чергування</th>
                            <th rowspan="2">Off</th>
                        </tr>
                        <tr>
                            <th>Понеділок</th>
                            <th>Вівторок</th>
                            <th>Середа</th>
                            <th>Четверг</th>
                            <th>П'ятниця</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            session_start();
                            // session_unset();
                            if (isset($_SESSION["students"])){
                                $students = json_decode($_SESSION["students"]);
                            } else {
                                $students = [
                                    ["Петро", "11-ЕУ"],
                                    ["Даніл", "ПЦБ-1107"],
                                    ["Назар", "БО-11"],
                                    ["Оксана", "ПЦБ-1107"],
                                    ["Андрій", "БО-11"],
                                    ["Дана", "11-ЕУ"],
                                    ["Олексій",	"БО-11"],
                                    ["Жанна", "ПЦБ-1107"],
                                    ["Людмила",	"БО-11"],
                                    ["Валентина", "11-ЕУ"],
                                ];
                            }
                            if (isset($_POST["add"])) {
                                $newStudent = [];
                                array_push($newStudent, $_POST['name'], $_POST['group']);
                                array_push($students, $newStudent);
                                header('Location: index.php');
                            }
                            if (isset($_POST["delete"])) {
                                array_splice($students, $_POST["delete"], 1);
                                header('Location: index.php');
                            }
                            $countDays = 5;
                            $schedule1Start = 9;
                            $schedule2Start = 18;
                            $schedule1 = [];
                            $schedule2 = [];
                            $schedule3 = [];
                            for ($i = 0, $k = $schedule1Start, $m = $schedule2Start; $i < $countDays; $i++, $k++, $m--) {
                                $schedule3Start = rand ( $schedule1Start,$schedule2Start);
                                $isNotOk = true;
                                if ($schedule3Start != $k && $schedule3Start != $m) {
                                    $isNotOk = false;
                                    for ($j = 0; $j < count($schedule3); $j++) {
                                        if ($schedule3[$j] == $schedule3Start) {
                                            $isNotOk = true;
                                            break;
                                        }
                                    }
                                }
                                while ($schedule3Start == $k || $schedule3Start == $m || $isNotOk) {
                                    if (count($schedule3) == 0) {
                                        $isNotOk = false;
                                    }
                                    for ($j = 0; $j < count($schedule3); $j++) {
                                        if ($schedule3[$j] == $schedule3Start) {
                                            $isNotOk = true;
                                            break;
                                        }
                                        if (($j + 1) == count($schedule3)) {
                                            $isNotOk = false;
                                        }
                                    }
                                    if (($schedule3Start == $k || $schedule3Start == $m || $isNotOk)) {
                                        $schedule3Start = rand ($schedule1Start,$schedule2Start);
                                        $isNotOk = true;
                                    }
                                }
                                $time1 = "";
                                $time2 = "";
                                $time3 = "";
                                if ($k < 10) {
                                    $time1 .= 0;
                                }
                                if ($m < 10) {
                                    $time2 .= 0;
                                }
                                if ($schedule3Start < 10) {
                                    $time3 .= 0;
                                }
                                $time1 .= $k . ":00";
                                $time2 .= $m . ":00";
                                $time3 .= $schedule3Start . ":00";
                                $schedule1[] .= $time1;
                                $schedule2[] .= $time2;
                                $schedule3[] .= $time3;
                                
                                // array_push($schedule1, $time1);
                                // array_push($schedule2, $time2);
                                // array_push($schedule3, $time3);
                            }  
                            
                            for ($i = 0; $i < count($students); $i++) {
                                echo "<tr>";
                                echo "<td>". $students[$i][0] ."</td>";
                                echo "<td>". $students[$i][1] ."</td>";
                               
                                for  ($j = 0; $j < count($schedule1); $j++) {
                                    if ($students[$i][1] == "11-ЕУ") {
                                        echo "<td>". $schedule1[$j] ."</td>";
                                    } else if ($students[$i][1] == "ПЦБ-1107") {
                                        echo "<td>". $schedule2[$j] ."</td>";
                                    } else if ($students[$i][1] == "БО-11") {
                                        echo "<td>". $schedule3[$j] ."</td>";
                                    }
                                }
                                echo "<td><button type='submit' name='delete' value='$i'>-</button></td>";
                                echo "</tr>";
                            }
                            $_SESSION["students"] = json_encode($students);
                        ?>
                    </tbody>
                </table>
            </div>
            <p>
                <label>
                    <input type="text" name="name" id="name">Ім'я
                </label>
                <label class="select">
                    <select name="group">
                        <option value="БО-11" selected disabled>Група</option>
                        <option value="11-ЕУ">11-ЕУ</option>
                        <option value="ПЦБ-1107">ПЦБ-1107</option>
                        <option value="БО-11">БО-11</option>
                    </select>
                </label>                
                <input class="btn" name="add" type="submit" value="Добавити"><br>                
            </p>

        </div>
    </form>
    
</body>
</html>