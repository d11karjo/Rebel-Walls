<!DOCTYPE html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style>
.hidden{
	background-color: #ffffff;
	margin: 5px;
	border: 2px solid #000000;
	border-radius: 4px;
	padding: 2px;
	display:none;
	z-index: 1;
	position: fixed;
	left: 2%;
    top: 2%;
	width: 1000px;
	height: 90%;
	overflow:scroll;
}
.hide{
	position: absolute;
	left: 90%;
	background-color: #00aaaa;
}
button {
	background-color: #00aa00;
    border: none;
    color: white;
    padding: 5px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
	border-radius: 8px;
}
img{
	padding: 2px;
}
</style>



<html>
<body>

<?php

$xml=simplexml_load_file("articlesx.xml") or die("Error: Cannot create object");

foreach($xml->children() as $articles) {// För varje artikel som finns i xml-filen lägger koden till ett nytt objekt.
    echo $articles->productName . "<br>";
	if ($articles->descriptionTitle == ""){
		
	}
	else{
		echo $articles->descriptionTitle . "<br>";
	}
	
	echo "<button id='show". $articles->id ."'>Show more</button><br>";// Objekten differentieras främst med sina respektive ID.
	
	echo "<div class='hidden' id='". $articles->id ."'>";
	echo "<button class='hide' id='hide". $articles->id ."'>Close</button>";
	echo "<p>" . $articles->productName . "<br>";
	if ($articles->descriptionTitle == ""){// Ibland är beskrivningstiteln tom, och då skrivs den inte ut.
		
	}
	else{
		echo $articles->descriptionTitle . "<br>";
	}
	echo "Price: " . $articles->price->value . " " . $articles->price->currency . "</p>";
	echo "<hr>";
	if ($articles->descriptionText == ""){// Likt med beskrivningstiteln kan det hända att beskrivningen är tom, varvid den inte skrivs ut.
		
	}
	else{// Beskrivningen delas in i tre delar; dom första 40 tecken, en text man kan klicka på för att visa mer, och det som blir kvar av beskrivningen.
		echo "<span id=p" . $articles->id . ">" . $articles->descriptionText . "</span><span id=more" . $articles->id . ">... [More]</span><span id=extra" . $articles->id . " style='display: none;'>Merf</span><br><br>";
	}
		foreach($articles->images->image as $images){
			echo "<a href=" . $images->url . "><img src=" . $images->thumbnail . " alt=" . $images->alt . " height='250px' width='250px'></a>";
		}
	echo "</div>";

	echo "<script>";
	echo "$(document).ready(function(){";// Detta stycke hanterar allt man kan klicka på för att dölja eller visa
	echo 	"$('#hide". $articles->id ."').click(function(){";// Knappen för att dölja den fulla rutan.
	echo 		"$('#". $articles->id ."').fadeOut(300);";
	echo 	"});";
	echo 	"$('#show". $articles->id ."').click(function(){";// Knappen för att visa den fulla rutan.
	echo  		"$('#". $articles->id ."').fadeIn(300);";
	echo 	"});";
	echo 	"$('#more". $articles->id ."').click(function(){";// Knappen för att visa den långa beskrivningen.
	echo  		"$('#more". $articles->id ."').hide();";
	echo  		"$('#extra". $articles->id ."').show();";
	echo 	"});";
	echo "});";


	echo	"$(function(){";// Ser till att beskrivningstexten kapas om den är för lång, och sparar det som blir över separat.
	echo		"$('#p" . $articles->id . "').each(function(i){";
	echo			"len=$(this).text().length;";
	echo			"lim=40;";
	echo			"if(len>lim)";
	echo			"{";
	echo				"var short" . $articles->id . " = $(this).html().substr(0,lim);";
	echo				"var long" . $articles->id . " = $(this).html().substr(lim);";

	echo				"$(this).text(short" . $articles->id . ");";
	echo				"$('#extra". $articles->id ."').text(long" . $articles->id . ");";

	echo			"}";
	echo		"});";
	echo	"});";
	
	echo "";
	echo "";


	echo "</script>";
	echo "<br>";
} 

?>

</body>
</html>