<?php require_once __SITE_PATH . '/view/_header_for_table.php'; ?>
<script>0</script>
<table>
	<thead>
        <tr>
            <th class='first'></th>
            <th colspan="5"><?php echo $title; ?></th>
        </tr>
        <tr>
            <th class='first'></th>
            <th>PON</th>
            <th>UTO</th>
            <th>SRI</th>
            <th>ČET</th>
            <th>PET</th>
        </tr>
    </thead>
    <tbody id = "tablebody">
        <?php
            $start_hour = 8;
            $day = ["PON", "UTO", "SRI", "ČET", "PET"];
            for($i = 0; $i < 12; $i++){
                echo '<tr>';
                echo '<th class = "first">' . ($start_hour + $i) . '-' . ($start_hour + $i + 1) . '</th>';
                for($j = 0; $j < 5; $j++){
                    $cur_id = $day[$j] . '-' . strval($start_hour + $i); 
                    echo '<th id = "' . $cur_id . '"></th>';
                }
                echo '</tr>';
            }
        ?>
    </tbody>
</table>

<div id = "unos_u_tablicu" style = "width: 300px; height: 300px; float: right; position: absolute">
    <form action="<?php echo __SITE_URL . '/index.php?rt=lectures/addLecture'?>" method="post">
    </form>
</div>
<script>

    var test = <?php echo json_encode($lectures); ?>;
    var broj_sivih = 0;
    var field_id = []; 
    fillStartingTable(test);
    
    
    $( document ).ready( function()
    {
        //za dodavanje u raspored
        $( "#tablebody" ).on("mousedown","th", function(event)
            {
                console.log("Ulazim ", broj_sivih, field_id);
                if( event.button === 0 && $(this).text() ==='')
                {
                    console.log("Ulazim ovdje");
                    var color = $( this ).css( "background-color" );
                    console.log(color);
                    if(color === 'rgba(0, 0, 0, 0)' || color === 'rgb(255, 255, 255)')
                    {
                        console.log("Sada sam tu");
                        $(this).css("background-color", 'gray');
                        broj_sivih++;
                        field_id.push($(this).attr('id'));
                        if(broj_sivih === 1)
                            forma_za_unos();

                    }
                    else
                    {
                        $(this).css("background-color", 'white');
                        broj_sivih--;
                        field_id = arrayRemove(field_id, $(this).attr('id'));
                        if(broj_sivih === 0)
                            $('#unos_u_tablicu').empty();
                    }
                }
            });
            
            
    });

    function fillStartingTable(test)
    {
        for(let i = 0; i < test.length; i++) {
            console.log(test[i].dan, test[i].sati)
            let pocetak = parseInt(test[i].sati.split('-')[0])
            let kraj = parseInt(test[i].sati.split('-')[1])
            let razlika = kraj - pocetak;
            for(let j = pocetak; j<kraj; ++j){
                if (j == pocetak){
                    $('#' + test[i].dan + '-' + j)
                    .html(test[i].ime +'<br>' + test[i].kolegij);
                    $('#' + test[i].dan + '-' + j)
                    .attr('rowspan', razlika);
                } else {
                    $('#' + test[i].dan + '-' + j).remove();
                }
            }
        }
    }
    function forma_za_unos()
    {
        var html_tekst = $('<label for="predmet">Predmet: </label><input id="predmet" name="predmet" type="text" />');
        var button_unesi = $('</br><button >Unesi u raspored!</button>')
        html_tekst.appendTo('#unos_u_tablicu');
        button_unesi.appendTo('#unos_u_tablicu');
    }


    function arrayRemove(arr, value) { 
        return arr.filter(function(ele){ 
            return ele != value; 
    });
}
    
        
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
