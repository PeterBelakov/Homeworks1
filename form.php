<?php
# slaga utf-8 encoding za da raboti kirilica
mb_internal_encoding('UTF-8');

$pageTitle = 'Форма';
include 'includes/header.php';

#proverka dali $_POST ne e prazno 
if($_POST) {

    #vzimame data
    $date = date("d.m.Y"); 
    
    #maha prazni intervali ' '
    $name = trim($_POST['name']);
   
    #ako sumata e 2,33 to trq se transformira v 2.33
    $sum = floatval(str_replace(',','.',$_POST['sum']));
    
    #vzima $_POST['group'] koeto e klu4a 
    $selectedGroup =(int)$_POST['group'];
    
    $error=false; # po default nqma greshki 
    
    # $name dali e po malko ot 4 simvola
    if(mb_strlen($name) < 4) {
        
        #izpisvame greshkata
        echo '<p>Името е прекалено късо</p>';
       
        #otbelqzvame 4e ima greshka
        $error=true;
    }
    
    # dali $sum da ne e po malko ili ravno na 0
    if($sum<=0) {
        echo '<p>Не валидна сума</p>';
        //otbelqzvame 4e ima greshka
        $error=true;
    }
    
    # dali $selectedGroup e validan klu4 sushtestvuvash v masiva $groups
    if(!array_key_exists($selectedGroup, $groups)) {
        echo '<p>Невалиден тип</p>';
        $error=true;
    }
    
    #proverka dalli ima namerena greshka
    if(!$error){
        
        #dolepqme udivitelni 
        $result=$date.'!'.$name.'!'.$sum.'!'.$selectedGroup."\n";
        
        #pishem vuv faila
        if(file_put_contents('data.txt', $result, FILE_APPEND));
        {
              echo 'Записа е успешен';
        }
    }
}
?>
<form method="POST">
    <a href="index.php">Списък</a>
    <div>Име<input type="text"name="name"/></div>
    <div>Сума<input type="text"name="sum"/></div>
    <div>
        <select name="group">
            <?php
            foreach ($groups as $kay => $value) {
                echo '<option value="' . $kay . '">' . $value . '</option>';
            }
            ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Добави"/>
    </div>
</form>
<?php
include 'includes/footer.php';
?>
    