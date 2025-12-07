<table class="table">
  <thead>
    <tr>
      <th scope="col">Letter</th>
      <th scope="col">Frequency</th>
    
    </tr>
  </thead>
  <tbody>
  <?php
	foreach($encode_text['Calculate_character_Frequencies'] as $key => $frequency)
		  { 
			  ?>
		
		  <tr>
			  <td><?php echo $key ;   ?></td>
			  <td><?php echo $frequency ;   ?></td>
		
			</tr>
		  
		  <?php
		  }
		  ?>
    
   
  </tbody>
</table>
<p class="encoded-output">
    <strong>Encoded message:</strong>
    <?= $encode_text['encoded_text'] ?>
</p>