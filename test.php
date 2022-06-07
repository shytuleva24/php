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
    <form action="test.php" method="POST">
        <div class="table table-statistics">
            <table>
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
                    session_unset();
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
                        header('Location: test.php');
                    }
                    if (isset($_POST["delete"])) {
                        array_splice($students, $_POST["delete"], 1);
                        header('Location: test.php');
                    }
                
                    $countDays = 5;
                    $schedule1Start = 9;
                    $schedule2Start = 18;
                    $schedule1 = [];
                    $schedule2 = [];
                    $schedule3 = [];
                    for ($i = 0, $k = $schedule1Start, $m = $schedule2Start; $i < $countDays; $i++, $k++, $m--) {
                        $time1 = "";
                        $time2 = "";
                    
                        if ($k < 10) {
                            $time1 .= 0;
                        }
                        if ($m < 10) {
                            $time2 .= 0;
                        }
                    
                        $time1 .= $k . ":00";
                        $time2 .= $m . ":00";

                        $schedule1[] .= $time1;
                        $schedule2[] .= $time2;
                    }


                    while (count($schedule3) < $countDays) {
                        $t = rand($schedule1Start, $schedule2Start);
                        if ($t < 10) {
                            $t = 0 . $t;
                        }
                        $t = $t . ":00";
                        if (!in_array($t, $schedule3) && $schedule1[count($schedule3)] != $t && $schedule2[count($schedule3)] != $t) {
                            $schedule3[] .= $t;
                        }
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
            <p class="form">
                <label>
                    <input type="text" name="name" id="name" placeholder="Ім'я">
                </label>
                <label class="select">
                    <select name="group">
                        <option value="БО-11" selected disabled>Група</option>
                        <option value="11-ЕУ">11-ЕУ</option>
                        <option value="ПЦБ-1107">ПЦБ-1107</option>
                        <option value="БО-11">БО-11</option>
                    </select>
                </label>
                <label>
                    <input class="btn" name="add" type="submit" value="Добавити">                
                </label>          
            </p>
        </div>
    </form>
</body>
</html>