<?php
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Youtube Channel Information</title>
	<link rel="stylesheet" type="text/css" href="Style.css" />
</head>
<body>

<?php
	
	if(isset($_POST['KanalURL'])){

?>
	<center><h2>Youtube Channel Information</h2></center>

	<div class="Duzen">
		
		<div class="GenelBilgiler">
			<div class="Bilgiler Bold" style="width: 40px;">Count</div>
			<div class="Bilgiler Bold KanalAdi">Channel Name</div>
			<div class="Bilgiler Bold">Views</div>
			<div class="Bilgiler Bold">Videos</div>
			<div class="Bilgiler Bold">Subscriber</div>
			<div class="Bilgiler Bold SonDiv" style="width: 150px;">Date</div>
			<div class="Temizle"></div>
		</div>
							
<?php
		$YtApiKey = 'AIzaSyCEH_YAW2PM9ExOwijpKkbEzjl8_GPXUIc';

		$Kanallar = $_POST['KanalURL'];
		$Kanallar = explode("\n", $Kanallar);
		$Kanallar = array_map('trim', $Kanallar);
		foreach ($Kanallar as $Key => $Kanal) {

			$KanalUser 	= explode('/',$Kanal);
			$KanalUser 	= end($KanalUser);
			$ApiUrl = 'https://www.googleapis.com/youtube/v3/channels?part=id,statistics,snippet&'.(strlen($KanalUser)==24?'id='.$KanalUser:'forUsername='.$KanalUser).'&key='.$YtApiKey;

			$Kaynak = file_get_contents($ApiUrl);
			$KaynakDecode = json_decode($Kaynak);

            $KanalID = $KaynakDecode->items[0]->id;

            $KanalTakipAdi = $KaynakDecode->items[0]->snippet->title;
            $KanalTarihi = $KaynakDecode->items[0]->snippet->publishedAt;
            $KanalTarihi = strtotime($KanalTarihi);
            $KanalTarihi = date('d.m.Y H:i:s',$KanalTarihi);

            $ToplamIzlenme = $KaynakDecode->items[0]->statistics->viewCount;
            $ToplamAbone = $KaynakDecode->items[0]->statistics->subscriberCount;
            $ToplamVideo = $KaynakDecode->items[0]->statistics->videoCount;

            $Baglanti = 'https://www.youtube.com/channel/'.$KanalID;
?>

			<div class="GenelBilgiler" <?=$Key%2?'':'style="background-color: #eff7ff;"'?>>
				<div class="Bilgiler" style="width: 40px;"><?=($Key+1)?></div>
				<div class="Bilgiler KanalAdi"><a href="<?=$Baglanti?>" target="_blank"><?=$KanalTakipAdi?></a></div>
				<div class="Bilgiler"><?=number_format($ToplamIzlenme)?></div>
				<div class="Bilgiler"><?=number_format($ToplamVideo)?></div>
				<div class="Bilgiler"><?=number_format($ToplamAbone)?></div>
				<div class="Bilgiler SonDiv" style="width: 150px;"><?=$KanalTarihi?></div>
				<div class="Temizle"></div>
			</div>


<?php

		}

?>

	</div>

<?php

	}

?>
	<center><h2>Youtube Channel Links</h2></center>
	<div class="Duzen">
		
		<form action="" method="post">
			<label style="margin-left: 10px; margin-top: 5px; font-weight: bold; color: #474747; float: left;">Channel Links</label>
			<textarea placeholder="Examples:&#10;https://www.youtube.com/user/googlechrome&#10;https://www.youtube.com/user/Google&#10;https://www.youtube.com/channel/UCtxkCXCD8bWpE8Ea_l4tV2A" name="KanalURL" id="KanalURL"></textarea>
			<input type="submit" value="Check" id="KontrolEt">
		</form>
		<div class="Temizle"></div>

	</div>

</body>
</html>