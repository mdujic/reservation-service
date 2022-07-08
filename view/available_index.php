<?php require_once __SITE_PATH . '/view/_header_for_calendar.php'; ?>

Izaberite dan u tjednu:
<div id="app">
  <select name="LeaveType" @change="change()" class="form-control" v-model="day">
    <option value="PON">PON</option>
    <option value="UTO">UTO</option>
    <option value="SRI">SRI</option>
    <option value="ČET">ČET</option>
    <option value="PET">PET</option>
  </select>
<br />
Trajanje rezervacije:
od
  <input type="time" id="start" name="start" v-model="start"
       min="08:00" max="19:00" @change="change()" required>
do
  <input type="time" id="end" name="end" v-model="end"
       min="09:00" max="20:00" @change="change()" required>
    
    <br />
    Popis slobodnih prostorija u traženom terminu ( morate izabrati dan i vrijeme):
    <br />
    <div id="zadravec" style="display:flex; flex-wrap: wrap;">
      <div @click="test(termin.ime)" class="title" id="classroom" style="background-color: lightgrey;
  width: 30px;
  border: 5px solid green;
  padding: 20px;
  margin: 5px;" v-for="termin in termini">{{ termin.ime }}</div>
    </div>
    <p v-model="opomena">{{ opomena }}</p>
    <br />
    <div id="hahah">
</div>
</div>

<script>
  var dan = ''
  var od = ''
  var doKad = ''
//http://localhost/index.php?rt=classrooms/showById&id_classroom=PR3
//http://localhost/~matija/reservation-service/index.php?rt=classrooms/showById&id_classroom=PR3
function test(x){
  console.log("Ovo je proradilo", x)
  console.log("ide sad ovo:", dan, od, doKad)
  var src = "index.php?rt=classrooms/showById&id_classroom=" + x + "&dan=" + dan + "&od=" + od + "&do=" + doKad;
  window.location.href=src;
}

new Vue({
  el: "#app",
  data: {
    day: "",
    start : "12:00",
    end : "13:00",
    termini: [],
    opomena: ""
  },
  methods: {
  	change: function() {
      this.termini.splice(0);
      this.opomena = "";
      if(this.start >= this.end ){
        this.opomena = "Početak mora biti prije kraja!"
      }
      else if(this.day != ""){
        var zauzete = [];
        var slobodne = [];
        dan = this.day
        od = this.start
        doKad = this.end
        // one koje su s drugih fakulteta zabranimo
        var zabranjene = ["GF", "F08", "MPZ", "KO"];

        for(let i = 0; i < $("tr").length; i++){
          let result = $("tr").eq(i).find("td:eq(1)").html().split('-');
          //console.log(result[0]+":00", result[1]+":00", this.start, this.end, result[0]+":00" < this.start);
          let x1 = result[0]+":00", x2 = result[1]+":00", y1 = this.start, y2 = this.end;
          if( ((x1 >= y1 && x1 < y2) ||
                (x2 > y1 && x2 <= y2) ||
                (y1 >= x1 && y1 < x2) ||
                (y2 > x1 && y2 <= x2)) && 
                ($("tr").eq(i).find("td:eq(0)").html() == this.day) &&
               !(zauzete.includes( $("tr").eq(i).find("td:eq(2)").html() ) ) ){
                  zauzete.push( $("tr").eq(i).find("td:eq(2)").html() );
              }
            
        }
        console.log("zauzete: ", zauzete);
        console.log(zauzete.includes("A102"));
        for(let i = 0; i < $("tr").length; i++){
          let result = $("tr").eq(i).find("td:eq(1)").html().split('-');
          //console.log(result[0]+":00", result[1]+":00", this.start, this.end, result[0]+":00" < this.start);
          let x1 = result[0]+":00", x2 = result[1]+":00", y1 = this.start, y2 = this.end;
          if( !(zauzete.includes( $("tr").eq(i).find("td:eq(2)").html() ) ) &&
              !(slobodne.includes( $("tr").eq(i).find("td:eq(2)").html() ) ) )
                  slobodne.push($("tr").eq(i).find("td:eq(2)").html());
                  
              
        }
        console.log("slobodne: ", slobodne);
        console.log(slobodne.length);
        for(let i = 0; i < slobodne.length; i++) {
          if( !( zabranjene.includes(slobodne[i]) ) ) 
            this.termini.push( { ime: slobodne[i]});
        }     
          //this.poslovi.push( { ime: $( "#txt" ).val(), obavljen: false } );
      }
      
    }
  }
})

</script>



<table hidden>
	<?php 
		foreach( $reservationsArray as $classroomReservations )
		{
            foreach($classroomReservations as $reservation){
               $t = ($reservation -> prostorija)[0] . ($reservation -> prostorija)[1];
			         if(($_SESSION['role'] === 'demos' || $_SESSION['role'] === 'gl_demos') && $t !== 'PR')
                continue;

               echo '<tr>' .
			          '<td>' . $reservation->dan . '</td>
                 <td>' . $reservation->sati . '</td>
                 <td>' . $reservation->prostorija . '</td>' .
			           '</tr>';
         }
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
