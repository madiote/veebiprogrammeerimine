    <hr />
    <footer>
		<div class="links"> <!-- Autogenerate list of links in current folder -->
			<p>Selle tunni lehed:
				<?php
					$dirFiles = scandir("./");
					for ($i = 2; $i < count($dirFiles); $i++){
						echo '<a href="./' . $dirFiles[$i] . '">' . $dirFiles[$i]. '</a> ';
					}
				?>
			</p>
		</div>
        <p>See leht on valminud õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
        <a href="https://www.tlu.ee">TLÜ kodulehele saab siit</a>
    </footer>

	<script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
  </body>
</html>