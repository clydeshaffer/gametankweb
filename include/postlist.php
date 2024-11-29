<?php
		function makePostBox($filename, $dir) {
			$path = $dir . "/" . $filename;
			$f = fopen($path, 'r');
			$content = fread($f, filesize($path));

			$metadata = [
			    "title" => $filename,
			    "thumb" => "/img/whomst.jpg",
			    "link" => $path,
			];

			foreach(explode(PHP_EOL, $content) as $line) {
				if(substr($line, 0, 4) !== "<!--") continue;

				$info = explode("=", substr($line, 4, -4));
				if(count($info) < 2) continue;
				
				$val = join("=", array_slice($info, 1));

				$metadata[trim($info[0])] = trim($val);
			}

			$th = $metadata["thumb"];
			$t = $metadata["title"];
			$link = $metadata["link"];

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