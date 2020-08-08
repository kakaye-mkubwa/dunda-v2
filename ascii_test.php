<?php //Forgive me for i am try

/*
	Simple ASCII > Text & Text < ASCII script.

	Live version available at: http://nioxed.com/tools/ascii_converter.php
*/


if(isset($_POST['string'])){

    $string = $_POST['string'];

    if($_POST['mode'] == "A>P"){

        $array = explode( "\\", $string);

        echo "String: <code>";

        for ($i = 0; $i < count($array); ++$i) {
            print chr($array[$i]);
        }

        echo "</code>";
    }else{

        $stringl = strlen( $string );
        for( $i = 0; $i <= $stringl; $i++ ) {

            if($i != $stringl){
                $char = substr( $string, $i, 1 );
                echo $char . " = " . ord($char) . "<br>";
                $charstr .= "\\".ord($char);
            }
        }

        echo "<br>ASCII String: <code>" . $charstr . "</code>";

    }

    echo "<hr>";

}
?>

<form method="POST" action="<?= $_SERVER['SCRIPT_NAME']; ?>">

    <p>Convert ASCII to PlainText or vice versa easily.</p>

    <input type="text" name="string" id="string" autocomplete="off" placeholder="Anter your string of text or ASCII characters" width="1000px" /><br><br>

    <select name="mode">
        <option value="A>P" Selected >ASCII > Text</option>
        <option value="P>A">Text  > ASCII</option>
    </select>

    <input type="submit" value="Convert"/>

</form>