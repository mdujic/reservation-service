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
    var redfield_id = [];
    var sivi_dan = '';
    

    fillStartingTable(test);

    var dan = ''
    var odKad = ''
    var doKad = ''
    <?php
        if(isset($dan)) { ?>
    dan = <?php echo json_encode($dan); ?>;
    odKad = <?php echo json_encode($od); ?>;
    doKad = <?php echo json_encode($do); ?>;
    odKad = odKad.toString().split(':')[0]
    doKad = doKad.toString().split(':')[0]
    console.log('#' + dan + '-' + odKad);
    for(let i =odKad; i < doKad; ++i){
        $('#' + dan + '-' + i).css("background-color", 'gray');
        broj_sivih++;
        sivi_dan = dan;
        field_id.push(dan + '-' + i)
    }
    forma_za_unos()
    <?php
        }
        ?>
    console.log(dan, odKad, doKad)
    
    $( document ).ready( function()
    {
        
        var role = <?php echo json_encode($_SESSION['role'])?>;
        var classroom = <?php echo json_encode($title)?>;
        //za dodavanje u raspored
        $( "#tablebody" ).on("mousedown","th", function(event)
            {
                //console.log("id je ", $(this).attr('id'));
                if(role === 'student')
                    return; //student je read-only tip
                if((role === 'demos' || role === 'gl_demos') && (classroom[0] != 'P' || classroom[1] != 'R')){
                    return;
                    //demos ne moze mijenjati prostorije koje nisu praktikumi
                }

                //console.log("moj role je ", role);
                //console.log("Ulazim ", broj_sivih, field_id);
                if( event.button === 0 && $(this).text() ==='' && broj_crvenih === 0)
                {
                    let sad = $(this).attr('id');
                    //console.log("Ulazim ovdje");
                    var color = $( this ).css( "background-color" );
                    //console.log(color);
                    let d = sad[0] + sad[1] + sad[2];
                    console.log("sad je ", d, " a sivi dan je " , sivi_dan);
                    console.log("broj sivih je ", broj_sivih);
                    if((sivi_dan === '' || sivi_dan === d) && (color === 'rgba(0, 0, 0, 0)' || color === 'rgb(255, 255, 255)'))
                    {
                        //console.log("Sada sam tu");
                        $(this).css("background-color", 'gray');
                        broj_sivih++;
                        field_id.push($(this).attr('id'));
                        dan = $(this).attr('id').split('-')[0];
                        if(broj_sivih === 1){
                            sivi_dan = d;
                            forma_za_unos();
                        }

                    }
                    else if(broj_sivih > 0 && !(color === 'rgba(0, 0, 0, 0)' || color === 'rgb(255, 255, 255)'))
                    {
                        $(this).css("background-color", 'white');
                        broj_sivih--;
                        field_id = arrayRemove(field_id, $(this).attr('id'));
                        if(broj_sivih === 0){
                            sivi_dan = '';
                            $('#unos_u_tablicu').empty();
                        }
                    }
                }
                else if(event.button === 0 && $(this).text() !=='' && broj_sivih === 0)
                {
                    var id = $(this).attr('id');
                    console.log("Ovo je za crveni: ");
                    console.log(id);
                    var relax = '';
                    if(role === 'gl_demos')
                        relax = 'gl_demos';
                    else if(role === 'satnicar')
                        relax = 'satnicar';

                    if(checkAppointment(id, relax))
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

    function checkAppointment(id, relax)
    {
        for(let i = 0; i < test.length; i++)
        {
            var pocetak = parseInt(test[i].sati.split('-')[0])
            var dan = test[i].dan;
            var id_dan = id.split('-')[0];
            var id_sat = parseInt(id.split('-')[1]);
            var ime = <?php echo json_encode($name); ?>;
            var prezime = <?php echo json_encode($surname); ?>;
            var flag = false;
            if(relax === 'satnicar')
                flag = true;
            else if(relax === 'gl_demos' && test[i].vrsta === 'dem'){
                flag = true;
            }
            //if(i == 0){
            //    console.log('vrsta je ', test[i].vrsta);
            //}
            if(id_dan === dan && id_sat === pocetak && (flag || (test[i].ime === ime && test[i].prezime === prezime)) )
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
                    .html(test[i].prezime +'<br>' + test[i].kolegij);
                    $('#' + test[i].dan + '-' + j)
                    .attr('rowspan', razlika);
                } else {
                    $('#' + test[i].dan + '-' + j).remove();
                }
            }
        }
    }

    function format_date(day, month) {
        let final = '';
		if (day - 10 < 0) {
			final = '0' + day + ".";
		}else {
			final = day + ".";
		}
        if(month-10 < 0){
            final += '0' + month;
        }else{
            final += month
        }
        return final;
    }

    function dodaj_sve_datume() {
        const d = new Date();
        const today_day = d.getDay();
        const today_date = [d.getUTCDate(), d.getUTCMonth() + 1];
		var reservation_day = -1;
		var new_date = parseInt(today_date[0]);
		switch(dan){
			case 'PON':
				reservation_day = 1;
				break;
			case 'UTO':
				reservation_day = 2;
				break;
			case 'SRI':
				reservation_day = 3;
				break;
			case 'ČET':
				reservation_day = 4;
				break;
			case 'PET':
				reservation_day = 5;
				break;
		}
		if (reservation_day > today_day) {
			new_date += reservation_day - today_day;
		} else if (today_day > reservation_day){
			new_date += 7-(today_day-reservation_day);
		}
        datumi =  []
        let day = new_date;
        let month = today_date[1];
        let duzi_mjesec = true;
        for(let i = 0; i < 15; ++i) {
            let broj_dana = 30;
            if (duzi_mjesec) broj_dana++;
            if(day - broj_dana > 0){
                day -= broj_dana;
                if(duzi_mjesec && month != 7) duzi_mjesec = false
                else duzi_mjesec = true
                month++;
            }
            let dann = $('</br><option value="' + format_date(day, month) + '">' + format_date(day, month) + '</option>');
            dann.appendTo('#datumi');
            day += 7;
        }
    }

    function forma_za_unos()
    {
        var html_tekst = $('<label for="predmet">Predmet: </label><input id="predmet" name="predmet" type="text" />');
        var radio = $('</br><input type="radio" name="odabir" id="predavanja" value="predavanja" checked>Predavanja</input></br><input type="radio" name="odabir" id="vjezbe" value="vjezbe" >Vježbe</input></br><input type="radio" name="odabir" id="dem" value="dem" >Demonstrature</input></br><input type="radio" name="odabir" id="sem" value="sem">Seminar</input></br><input type="radio" name="odabir" id="ost" value="ost">Ostalo</input></br>');
        var datum = $('<select id="datumi"></select>');
        var button_unesi = $('</br><button onclick=sendDataToPhp()>Unesi u raspored!</button>');
        html_tekst.appendTo('#unos_u_tablicu');
        radio.appendTo('#unos_u_tablicu');
        datum.appendTo('#unos_u_tablicu')
        button_unesi.appendTo('#unos_u_tablicu');
        dodaj_sve_datume();
    }
    function forma_za_brisanje()
    {
        var button_unesi = $('</br><button onclick=sendDataToClear()>Izbrisi iz rasporeda!</button>');
        button_unesi.appendTo('#unos_za_brisanje');
    }

    function sendDataToPhp()
    {
        var src = "index.php?rt=lectures/addLecture&termini="+field_id+"&subject="+$('#predmet').val()+"&tip="+$('[name="odabir"]:checked').val() + "&datum=" + $('#datumi option:selected').text() +"&classroom=" +<?php echo json_encode($title); ?>;
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
