<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<button type="button" onclick= deleteLectures()>Očisti cijeli raspored!</button> 
<br><br>

<form action = "index.php?rt=schedule/addSchedule" enctype="multipart/form-data" method = "post">
  <label for="myfile">Odaberi datoteku:</label>
  <input type="file" id="myfile" name="myfile"><br><br>
  <input type="submit" value = "Izvrši">
</form>

<script>

    /*function loadingDB()
    {
<button type="button" onclick=loadingDB()>Unesi cijeli raspored!</button> 

        var src = "index.php?rt=schedule/addSchedule";
        window.location.href=src;
    }*/

    function deleteLectures()
    {
        var src = "index.php?rt=schedule/removeSchedule";
        window.location.href=src;
    }

</script>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>