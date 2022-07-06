<?php require_once __SITE_PATH . '/view/_header_for_calendar.php'; ?>

Izaberite datum:
<div id="app">
  <select name="LeaveType" @change="onchange()" class="form-control" v-model="key">
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
       min="08:00" max="end" required>
do
  <input type="time" id="end" name="end" v-model="end"
       min="start" max="20:00" required>
  <p>My Time : {{start}}</p>
  <p>My Time 2 : {{end}}</p>
</div>

<script>


new Vue({
  el: "#app",
  data: {
    key: "",
    start : "12:00",
    end : "12:10",
  },
  methods: {
  	onchange: function() {
    	console.log(this.key);
        alert(this.key, this.start, this.end);
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
