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

            $countDays = 6;
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

        ?>
        <div class="table table-statistics">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Ім'я</th>
                        <th rowspan="2">№ Группи</th>
                        <th colspan="6">Графік чергування</th>
                        <th rowspan="2">Видалити</th>

                    </tr>
                    <tr>
                        <th>Понеділок</th>
                        <th>Вівторок</th>
                        <th>Середа</th>
                        <th>Четверг</th>
                        <th>П'ятниця</th>
                        <th>Субота</th>

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