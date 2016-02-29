<?php
$pageTitle = 'Списък';
include 'includes/header.php';
?>
<a href="form.php">Добави нов разход</a>
<form method="get">
    <div>
        <select name="group">
            <option value="0">Всички</option> 
            <?php
            foreach ($groups as $kay => $value) {
                echo '<option value="' . $kay . '">' . $value . '</option>';
            }
            ?>
        </select><input type="submit" value="Филтрирай"/>
    </div>
</form>
<table border="1">
    <tr>
        <td>Дата</td>
        <td>Име</td>
        <td>Сума</td>
        <td>Вид</td>
    </tr>
    <?php
    
    //proverka dali faila go ima
    if (file_exists('data.txt')) {
        
        //otvarqme faila kato file ni vrushta masiv (array)
        $result = file('data.txt');
        
        //sumata zapo4va ot 0 bgn
        $totalsum = 0;
        
        //obhojdane na promenlivata $result, red po red
        foreach ($result as $value) {
        
            
            //Primer :  $value = '02.12.2015!Пилешка паржола на канапе!5!1'; 
            
            //explodvame stringa i go pravim na masiv
            $colums = explode('!', $value);
            
            
            //Proverqva 3 usloviq
            // 1 proverqva dali ima $_GET['group'] ne e NULL (nishto)
            // 2 proverka za  $_GET['group'] da e po golqmo ot 0 
            // 3 proverqva dali $_GET['group'] e razli4no ot na tekushtiq red groupata
            if (isset($_GET['group']) && $_GET['group'] > 0 && (int) $_GET['group'] != (int) $colums[3]) {
                
                #preska4ame vsiki koito ne sa vuv fuktriranata groupa 
                continue;
            }         
            $totalsum+=$colums[2];
            echo '<tr>
                        <td>' . $colums[0] . '</td>
                        <td>' . $colums[1] . '</td>
                <td>' . number_format($colums[2], 2, '.', '') . '</td>
                <td>' . $groups[trim($colums[3])] . '</td>
                        </tr>';
        }
        echo '<tr><td></td><td></td><td>' . number_format($totalsum, 2, '.', '') . '</td><td></td></tr>';
    }
    ?>
</table>
<?php
include 'includes/footer.php';
?>