<p>Hello <?php   echo $name ;?>,</p>

<p>We detected a login attempt from a new device:</p>
<p>IP: <?php  echo $ip ?></p>

<p>Browser <?php echo $agent ?></p>

<p>If this was you, click below: <br/>
<a href="<?php echo $link ?>"  >verify</a><br />
If not, please reset your password immediately.</p>