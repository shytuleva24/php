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
        <?php
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

            if ($_POST) {
                array_push($students, [$_POST['name'], $_POST['group']]);
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
        ?>
        <div class="table table-statistics">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Ім'я</th>
                        <th rowspan="2">№ Группи</th>
                        <th colspan="5">Графік чергування</th>
                        <th rowspan="2">Видалити</th>

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
                    <?php foreach($students as $val) : ?>
                    <tr>
                        <td><?php echo "$val[0]"; ?></td>
                        <td><?php echo "$val[1]"; ?></td>
                        <?php 
                            if ($val[1] == "11-ЕУ") {
                                foreach($schedule1 as $val1) :
                                echo "<td>$val1</td>"; 
                                endforeach;
                            } else if ($val[1] == "ПЦБ-1107") {
                                foreach($schedule2 as $val2) :
                                echo "<td>$val2</td>";
                                endforeach;
                            } else {
                                foreach($schedule3 as $val3) :
                                echo "<td>$val3</td>";
                                endforeach;
                            }
                        ?>
                        <td></td> 
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="plus">
                <label class="form-row">
                    <input type="text" name="name" id="name" required><label for="name">Ім'я</label>
                </label>
                <label class="form-row">
                    <input type="text" name="group" id="group" required><label for="group">Группа</label>
                </label>                
                <input class="btn" type="submit" value="Добавити"><br>                
            </div>
        </div>
    </form>
    
</body>
</html>