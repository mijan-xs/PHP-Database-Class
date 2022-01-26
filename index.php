<?php include_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Testing</title>
</head>
<body>
    <?php 
    //Single Insert (We haven't any multiple insert)
    $data = ['shakib75','shakid@xpeedstudio.com','shakib75','75757577575'];
    //$db->insert('users',$data);

    //Delete
    $id = 1;
    //$db->delete('users',$id);

    //Update
    $id = 9;
    $data = ['username'=>'musfiq15','email'=>'musfiq15@xpeedstudio.com','password'=>'musfiq15','phone'=>151515];
    //$db->update('users',$id,$data);

    //Read By ID
    $id = 9;
    //$result = $db->read_by_id('users',$id);
    //var_dump($result);

    //Read All Data from table
    //$result = $db->read_all('users');
    echo '<pre>';
    //print_r($result);
    echo '</pre>';

    ?>
</body>
</html>