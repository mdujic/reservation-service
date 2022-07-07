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
    

  <p>Day : {{day}}</p>
  <p>Start : {{start}}</p>
  <p>End : {{end}}</p>
  <p>Good interval : {{start < end}}</p>

    <ul style= "color:white">
        <li v-for="termin in termini"> {{ termin.ime }} </li>
    </ul>
    <br />
</div>

<script>


new Vue({
  el: "#app",
  data: {
    day: "",
    start : "12:00",
    end : "13:00",
    termini: [
        {ime: "003"},
        {ime: "006"},
        {ime: "002"}
    ]
  },
  methods: {
  	change: function() {
        //this.poslovi.push( { ime: $( "#txt" ).val(), obavljen: false } );
    }
  }
})

</script>



<table>
	<?php 
		foreach( $reservationsArray as $classroomReservations )
		{
            foreach($classroomReservations as $reservation)
			echo '<tr>' .
			     '<td>' . $reservation->dan . ' ' . $reservation->sati . 
                 '<br>' . $reservation->prostorija . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
