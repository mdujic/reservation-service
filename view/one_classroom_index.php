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
    <tbody>
        <tr>
            <th class='first'>8-9</th>
            <th id='PON-8'></th>
            <th id='UTO-8'></th>
            <th id='SRI-8'></th>
            <th id='ČET-8'></th>
            <th id='PET-8'></th>
        </tr>
        <tr>
            <th class='first'>9-10</th>
            <th id='PON-9'></th>
            <th id='UTO-9'></th>
            <th id='SRI-9'></th>
            <th id='ČET-9'></th>
            <th id='PET-9'></th>
        </tr>
        <tr>
            <th class='first'>10-11</th>
            <th id='PON-10'></th>
            <th id='UTO-10'></th>
            <th id='SRI-10'></th>
            <th id='ČET-10'></th>
            <th id='PET-10'></th>
        </tr>
        <tr>
            <th class='first'>11-12</th>
            <th id='PON-11'></th>
            <th id='UTO-11'></th>
            <th id='SRI-11'></th>
            <th id='ČET-11'></th>
            <th id='PET-11'></th>
        </tr>
        <tr>
            <th class='first'>12-13</th>
            <th id='PON-12'></th>
            <th id='UTO-12'></th>
            <th id='SRI-12'></th>
            <th id='ČET-12'></th>
            <th id='PET-12'></th>
        </tr>
        <tr>
            <th class='first'>13-14</th>
            <th id='PON-13'></th>
            <th id='UTO-13'></th>
            <th id='SRI-13'></th>
            <th id='ČET-13'></th>
            <th id='PET-13'></th>
        </tr>
        <tr>
            <th class='first'>14-15</th>
            <th id='PON-14'></th>
            <th id='UTO-14'></th>
            <th id='SRI-14'></th>
            <th id='ČET-14'></th>
            <th id='PET-14'></th>
        </tr>
        <tr>
            <th class='first'>15-16</th>
            <th id='PON-15'></th>
            <th id='UTO-15'></th>
            <th id='SRI-15'></th>
            <th id='ČET-15'></th>
            <th id='PET-15'></th>
        </tr>
        <tr>
            <th class='first'>16-17</th>
            <th id='PON-16'></th>
            <th id='UTO-16'></th>
            <th id='SRI-16'></th>
            <th id='ČET-16'></th>
            <th id='PET-16'></th>
        </tr>
        <tr>
            <th class='first'>17-18</th>
            <th id='PON-17'></th>
            <th id='UTO-17'></th>
            <th id='SRI-17'></th>
            <th id='ČET-17'></th>
            <th id='PET-17'></th>
        </tr>
        <tr>
            <th class='first'>18-19</th>
            <th id='PON-18'></th>
            <th id='UTO-18'></th>
            <th id='SRI-18'></th>
            <th id='ČET-18'></th>
            <th id='PET-18'></th>
        </tr>
        <tr>
            <th class='first'>19-20</th>
            <th id='PON-19'></th>
            <th id='UTO-19'></th>
            <th id='SRI-19'></th>
            <th id='ČET-19'></th>
            <th id='PET-19'></th>
        </tr>

    </tbody>
</table>
<script>
    
    $( document ).ready( function()
        {
            var test = <?php echo json_encode($lectures); ?>;
            
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
            
        })
        
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
