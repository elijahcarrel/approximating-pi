<!DOCTYPE html>
<html>
<head>
<title>Approximating Pi</title>

<style>
table {
	border-collapse:collapse;
}

table, td, th {
	border: 2px solid grey;
}
td {
	padding: 2px;
}
</style>

</head>
<body>

<p>All images are automatically generated with the PHP code.</p>
<p>An explanation of what's going on will come shortly!</p>


<?php

/**
 * @author      Elijah Carrel <elijahcarrel@gmail.com>
 * @version     1.0
 * @since       2013-06-11
 */

$starting_number_of_sides = 3;
$ending_number_of_sides = 25;
$max_number_of_sides_with_picture = 25;

$number_of_rows_including_header = $ending_number_of_sides - $starting_number_of_sides + 2;

$bool_filled = $_GET['bool_filled'];

if ($_GET['raster'] == true)
{
	$type = 'png';
	echo '<p><a href="?raster=0">Revert back to vector (SVG) images.</a>';
}
else
{
	$type = 'svg';
	echo '<p><b>Images don\'t display correctly? <a href="?raster=1">Display them as raster (PNG) images</a> instead of vector (SVG) images.</b></p>';
}

?>

<br>

<table style="font-size: 0.9em; font-family:sans-serif;">
<tbody>
<tr>
<td>Number of sides</td>
<td>Angle from center</td>
<td style="vertical-align:text-top;" rowspan="<?php echo $number_of_rows_including_header; ?>"><b>Shape is circumscribed around circle:</b></td>
<td>Length of apothem (shown in <span style="color:purple;">purple</span>)</td>
<td>Length of circumradius (shown in <span style="color:green;">green</span>)</td>
<td>Length of each side of shape</td>
<td>Area of shape</td>
<td>Generated diagram</td>
<td style="vertical-align:text-top;" rowspan="<?php echo $number_of_rows_including_header; ?>"><b>Shape is inscribed in circle:</b></td>
<td>Length of circumradius (shown in <span style="color:green;">green</span>)</td>
<td>Length of apothem (shown in <span style="color:purple;">purple</span>)</td>
<td>Length of each side of shape</td>
<td>Area of shape</td>
<td>Generated diagram</td>
<td><b>Average of the areas of the two shapes</b></td>
</tr>

<?php

for ($number_of_sides = $starting_number_of_sides; $number_of_sides <= $ending_number_of_sides; $number_of_sides++)
{

	echo '<tr>';
	
	$angle_from_center = 360 / $number_of_sides;
	
	echo "<td>$number_of_sides</td>";
	echo "<td>$angle_from_center&deg;</td>";
	
	/* Begin circumscribed shape */
		$apothem_length = 1;
		$circumradius_length = $apothem_length / cos(deg2rad($angle_from_center / 2));
		$side_length = 2 * $apothem_length * tan(deg2rad($angle_from_center / 2));
		$area1 = 0.5 * $number_of_sides * $side_length * $apothem_length;
		
		echo "<td>$apothem_length</td>";
		echo "<td>$circumradius_length</td>";
		echo "<td>$side_length</td>";
		echo "<td>$area1</td>";
		
		if ($number_of_sides <= $max_number_of_sides_with_picture)
			echo "<td><a href=\"./draw_image.php?type=$type&dimension=600&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=0\"><img src=\"./draw_image.php?type=$type&dimension=150&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=0\"></a></td>";
		else
			echo "<td>The processor stops drawing thumbnail pictures after $max_number_of_sides_with_picture shapes to save memory. <a href=\"./draw_image.php?type=$type&dimension=600&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=0\">See this picture</a>.</td>";
	/* End circumscribed shape */
		
	/* Begin inscribed shape */
		$circumradius_length = 1;
		$apothem_length = $circumradius_length * cos(deg2rad($angle_from_center / 2));
		$side_length = 2 * $circumradius_length * sin(deg2rad($angle_from_center / 2));
		$area2 = 0.5 * $number_of_sides * $side_length * $apothem_length;
		echo "<td>$circumradius_length</td>";
		echo "<td>$apothem_length</td>";
		echo "<td>$side_length</td>";
		echo "<td>$area2</td>";
		
		if ($number_of_sides <= $max_number_of_sides_with_picture)
			echo "<td><a href=\"./draw_image.php?type=$type&dimension=600&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=1\"><img src=\"./draw_image.php?type=$type&dimension=150&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=1\"></a></td>";
		else
			echo "<td>The processor stops drawing thumbnail pictures after $max_number_of_sides_with_picture shapes to save memory. <a href=\"./draw_image.php?type=$type&dimension=600&number_of_sides=$number_of_sides&angle_from_center=$angle_from_center&circumradius_length=$circumradius_length&bool_inscribed=1\">See this picture</a>.</td>";
	/* End inscribed shape */
	
	$average_area = ($area1 + $area2) / 2;
	
	echo "<td>$average_area</td>";
	
	echo "</tr>\n\r";
		
}

?>

</tbody>
</table>
</body>
</html>