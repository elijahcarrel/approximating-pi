<?php

$dimension = $_GET['dimension'];
$circle_diameter = $dimension / 2;

$number_of_sides = $_GET['number_of_sides'];
$angle_from_center = $_GET['angle_from_center'];
$apothem_length = $_GET['apothem_length'];
$circumradius_length = $_GET['circumradius_length'];
$side_length = $_GET['side_length'];
$bool_inscribed = $_GET['bool_inscribed'];
$bool_filled = $_GET['bool_filled'];

$image = imagecreatetruecolor($dimension, $dimension);
$white = imagecolorallocate($image, 255, 255, 255);
$red = imagecolorallocate($image, 255, 0, 0);
$blue = imagecolorallocate($image, 0, 0, 255);
$green = imagecolorallocate($image, 0, 255, 0);
$purple = imagecolorallocate($image, 255, 0, 255);


imagefill($image, 0, 0, $white);

$vertices = array();

for ($i = 0; $i < $number_of_sides; $i++)
{

	$vertices[] = ($circle_diameter / 2) * $circumradius_length * cos(deg2rad($angle_from_center * $i)) + ($dimension / 2);
	$vertices[] = ($circle_diameter / 2) * $circumradius_length * sin(deg2rad($angle_from_center * $i)) + ($dimension / 2);
}

/** 
 * The following if/else statements just ensure that the
 * outer object (either circle or n-gon) gets drawn before
 * the inner object, so that neither gets covered up.
 * 
 * They also ensure that if and only if bool_filled is
 * enabled, the objects are filled.
 **/

if ($bool_inscribed == 1)
{
	if ($bool_filled == 1)
	{
		imagefilledellipse($image, $dimension / 2, $dimension / 2, $circle_diameter, $circle_diameter, $blue);
		imagefilledpolygon($image, $vertices, $i, $red);
	}
	else
	{
		imageellipse($image, $dimension / 2, $dimension / 2, $circle_diameter, $circle_diameter, $blue);
		imagepolygon($image, $vertices, $i, $red);
	}	
}
else
{
	if ($bool_filled == 1)
	{
		imagefilledpolygon($image, $vertices, $i, $red);
		imagefilledellipse($image, $dimension / 2, $dimension / 2, $circle_diameter, $circle_diameter, $blue);
	}
	else
	{
		imagepolygon($image, $vertices, $i, $red);
		imageellipse($image, $dimension / 2, $dimension / 2, $circle_diameter, $circle_diameter, $blue);
	}
}

/* Draw the circumradius line */
imageline($image, $dimension / 2, $dimension / 2, $vertices[0], $vertices[1], $green);

/* Draw the apothem line */
imageline($image, $dimension / 2, $dimension / 2, ($vertices[0] + $vertices[2]) / 2, ($vertices[1] + $vertices[3]) / 2, $purple);




header('Content-type: image/png');
imagepng($image);
imagedestroy($image);

?>