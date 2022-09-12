<?php

if (isset($_POST['send'])) {
    // var_dump($_POST);
    if (isset($_POST['allday'])) {
        $startDate = date("Y-m-d H:i:s", strtotime($_POST['start-date']));
        $endDate = date("Y-m-d H:i:s", strtotime($startDate . ' 23 hours 59 minutes'));

        echo $startDate;
        echo "<br>";
        echo $endDate;
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <label for="start-date">Start Date</label>
        <input type="date" id="start-date" name="start-date" required>
        <label for="end-date">End Date</label>
        <input type="date" id="end-date" name="end-date" class="border-black bg-slate-400">
        <input type="checkbox" name="allday" id="allday">
        <button type="submit" name="send" class="bg-gray-200 w-20 rounded-md shadows-md py-2 mt-3">Send</button>
    </form>

    <div>
        <?php

        ?>
    </div>
</body>

</html>