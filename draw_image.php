<?php

$dimension = $_GET['dimension'];
$number_of_sides = $_GET['number_of_sides'];
$angle_from_center = $_GET['angle_from_center'];
$circumradius_length = $_GET['circumradius_length'];
$bool_inscribed = $_GET['bool_inscribed'];

if ($_GET['type'] == 'png')
{
	
	
	$circle_diameter = $dimension / 2;
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


}
else
{


	header('Content-Type: image/svg+xml');
		
	$circle_radius = $dimension / 4;
	$center_coordinate = $dimension / 2;
	
	
	echo '<?xml version="1.0" standalone="no"?>
	<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
	"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
	 
	<svg width="'.$dimension.'" height="'.$dimension.'" version="1.1"
	xmlns="http://www.w3.org/2000/svg">';
	
	$x_vertices = array();
	$y_vertices = array();
	
	$str_list_of_points = '';
	
	for ($i = 0; $i < $number_of_sides; $i++)
	{
		$x_vertices[$i] = $circle_radius * $circumradius_length * cos(deg2rad($angle_from_center * $i)) + ($dimension / 2);
		$y_vertices[$i] = $circle_radius * $circumradius_length * sin(deg2rad($angle_from_center * $i)) + ($dimension / 2);
		
		$str_list_of_points .= "$x_vertices[$i],$y_vertices[$i] ";
	}
	
	if ($bool_inscribed == 1)
	{
		echo '<circle stroke="blue" stroke-width="1" fill="#ccddff" cx="'.$center_coordinate.'" cy="'.$center_coordinate.'" r="'.$circle_radius.'" />';
		echo '<polygon stroke="red" stroke-width="1" fill="#ffcccc" points="'.$str_list_of_points.'" />';
	}
	else
	{
		echo '<polygon stroke="red" stroke-width="1" fill="#ffcccc" points="'.$str_list_of_points.'" />';
		echo '<circle stroke="blue" stroke-width="1" fill="#ccddff" cx="'.$center_coordinate.'" cy="'.$center_coordinate.'" r="'.$circle_radius.'" />';
	}
	
	
	/* Draw the circumradius line */
	echo '<line stroke="green" stroke-width="1" x1="'.$center_coordinate.'" y1="'.$center_coordinate.'" x2="'.$x_vertices[0].'" y2="'.$y_vertices[0].'" />';
	
	/* Draw the apothem line */
	$avg_of_first_two_x_coords_of_vertices = ($x_vertices[0] + $x_vertices[1]) / 2;
	$avg_of_first_two_y_coords_of_vertices = ($y_vertices[0] + $y_vertices[1]) / 2;
	echo '<line stroke="purple" stroke-width="1" x1="'.$center_coordinate.'" y1="'.$center_coordinate.'" x2="'.$avg_of_first_two_x_coords_of_vertices.'" y2="'.$avg_of_first_two_y_coords_of_vertices.'" />';
	
	echo '</svg>';

	
}

?>