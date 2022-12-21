<?php
		function makePostBox($filename, $dir) {
			$f = fopen($dir . "/" . $filename, 'r');
			$line = trim(fgets($f));
			$metadata = [];
			while(substr($line, 0, 4) === "<!--") {
				$info = explode("=", substr($line, 4, -4));
				$field = $info[0];
				array_shift($info);
				$value = implode("=", $info);
				$line = trim(fgets($f));
				$metadata[trim($field)] = trim($value);
			}

			if(!$metadata["title"]) {
				$metadata["title"] = $filename;
			}

			if(!$metadata["thumb"]) {
				$metadata["thumb"] = "/img/face-only.png";
			}

			$th = $metadata["thumb"];
			$t = $metadata["title"];
			$link = $dir . "/" . $filename;
			if($metadata["link"]) {
				$link = $metadata["link"];
			}

			echo "
			<a href='$link'>
			<figure class='postPreviewBox'>
      				<img src='$th'>
      		<figcaption>
        		$t
     		 </figcaption>
    		</figure>
    		</a>
			";
		}


		function postlist($dir) {
			$posts = scandir($dir);
			echo "<div class='gallery'>";
			foreach ($posts as $key => $value) {
				$firstchar = substr($value, 0, 1);
				if($firstchar !== "_" && $firstchar !== ".") {
					makePostBox($value, $dir);
				}
			}
			echo "</div>";
		}
	
?>