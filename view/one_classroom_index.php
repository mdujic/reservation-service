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

<div id = "unos_u_tablicu" >

</div>
<div id = "unos_za_brisanje" >

</div>
<script>

    var test = <?php echo json_encode($lectures); ?>;
    var broj_sivih = 0;
    var field_id = [];
    var broj_crvenih = 0;
    var redfield_id = []
    fillStartingTable(test);
    
    
    $( document ).ready( function()
    {
        //za dodavanje u raspored
        $( "#tablebody" ).on("mousedown","th", function(event)
            {
                console.log("Ulazim ", broj_sivih, field_id);
                if( event.button === 0 && $(this).text() ==='' && broj_crvenih === 0)
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
                else if(event.button === 0 && $(this).text() !=='' && broj_sivih === 0)
                {
                    var id = $(this).attr('id');
                    console.log("Ovo je za crveni: ");
                    console.log(id);
                    if(checkAppointment(id))
                    {
                        console.log("Ulazim ovdje");
                        var color = $( this ).css( "background-color" );
                        if(color === 'rgba(0, 0, 0, 0)' || color === 'rgb(255, 255, 255)')
                        {
                            $(this).css("background-color", 'red');
                            broj_crvenih++;
                            redfield_id.push($(this).attr('id'));
                            if(broj_crvenih === 1)
                                forma_za_brisanje();
                        }
                        else
                        {
                            $(this).css("background-color", 'white');
                            broj_crvenih--;
                            redfield_id = arrayRemove(redfield_id, $(this).attr('id'));
                            if(broj_crvenih === 0)
                                $('#unos_za_brisanje').empty();
                        }
                    }
                    
                }
            });
            
            
    });

    function checkAppointment(id)
    {
        for(let i = 0; i < test.length; i++)
        {
            var pocetak = parseInt(test[i].sati.split('-')[0])
            var dan = test[i].dan;
            var id_dan = id.split('-')[0];
            var id_sat = parseInt(id.split('-')[1]);
            var ime = <?php echo json_encode($name); ?>;
            var prezime = <?php echo json_encode($surname); ?>;
            if(id_dan === dan && id_sat === pocetak && test[i].ime === ime && test[i].prezime === prezime )
                return true;
        }
        return false;
    }

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
        var radio = $('</br><input type="radio" name="odabir" id="predavanja" value="predavanja" checked>Predavanja</input></br><input type="radio" name="odabir" id="vjezbe" value="vjezbe" >Vježbe</input>');
        var button_unesi = $('</br><button onclick=sendDataToPhp()>Unesi u raspored!</button>');
        html_tekst.appendTo('#unos_u_tablicu');
        radio.appendTo('#unos_u_tablicu');
        button_unesi.appendTo('#unos_u_tablicu');
    }
    function forma_za_brisanje()
    {
        var button_unesi = $('</br><button onclick=sendDataToClear()>Izbrisi iz rasporeda!</button>');
        button_unesi.appendTo('#unos_za_brisanje');
    }

    function sendDataToPhp()
    {
        var src = "index.php?rt=lectures/addLecture&termini="+field_id+"&subject="+$('#predmet').val()+"&tip="+$('[name="odabir"]:checked').val()+"&classroom="+<?php echo json_encode($title); ?>;
        window.location.href=src;
    }

    function sendDataToClear()
    {
        var src = "index.php?rt=lectures/removeLecture&termini="+redfield_id+"&classroom="+<?php echo json_encode($title); ?>;
        window.location.href=src;
    }


    function arrayRemove(arr, value) { 
        return arr.filter(function(ele){ 
            return ele != value; 
    });
}
    
        
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
