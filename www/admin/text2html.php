<?php

function text2html( $string )
{
  $string = str_replace ( '&', '&amp;', $string );
  $string = str_replace ( '\'', '&#039;', $string );
  $string = str_replace ( '"', '&quot;', $string );
  $string = str_replace ( '<', '&lt;', $string );
  $string = str_replace ( '>', '&gt;', $string );
  $string = str_replace ( 'ü', '&uuml;', $string );
  $string = str_replace ( 'Ü', '&Uuml;', $string );
  $string = str_replace ( 'ä', '&auml;', $string );
  $string = str_replace ( 'Ä', '&Auml;', $string );
  $string = str_replace ( 'ö', '&ouml;', $string );
  $string = str_replace ( 'Ö', '&Ouml;', $string );
  $string = str_replace ( 'ß', '&szlig;', $string );
  $string = str_replace ( chr(252), '&uuml;', $string );
  $string = str_replace ( chr(220), '&Uuml;', $string );
  $string = str_replace ( chr(228), '&auml;', $string );
  $string = str_replace ( chr(196), '&Auml;', $string );
  $string = str_replace ( chr(246), '&ouml;', $string );
  $string = str_replace ( chr(214), '&Ouml;', $string );
  $string = str_replace ( chr(223), '&szlig;', $string );
  $string = str_replace ( chr(13), '<br>', $string );
  return $string;
}

function t2h( $string )
{
  $string = str_replace ( '\'', '&#039;', $string );
  $string = str_replace ( 'ü', '&uuml;', $string );
  $string = str_replace ( 'Ü', '&Uuml;', $string );
  $string = str_replace ( 'ä', '&auml;', $string );
  $string = str_replace ( 'Ä', '&Auml;', $string );
  $string = str_replace ( 'ö', '&ouml;', $string );
  $string = str_replace ( 'Ö', '&Ouml;', $string );
  $string = str_replace ( 'ß', '&szlig;', $string );
  $string = str_replace ( chr(252), '&uuml;', $string );
  $string = str_replace ( chr(220), '&Uuml;', $string );
  $string = str_replace ( chr(228), '&auml;', $string );
  $string = str_replace ( chr(196), '&Auml;', $string );
  $string = str_replace ( chr(246), '&ouml;', $string );
  $string = str_replace ( chr(214), '&Ouml;', $string );
  $string = str_replace ( chr(223), '&szlig;', $string );
  return $string;
}

function html2text( $string )
{
  $string = str_replace ( '&amp;', '&', $string );
  $string = str_replace ( '&#039;', '\'', $string );
  $string = str_replace ( '&quot;', '"', $string );
  $string = str_replace ( '&lt;', '<', $string );
  $string = str_replace ( '&gt;', '>', $string );
  $string = str_replace ( '&uuml;', chr(252), $string );
  $string = str_replace ( '&Uuml;', chr(220), $string );
  $string = str_replace ( '&auml;', chr(228), $string );
  $string = str_replace ( '&Auml;', chr(196), $string );
  $string = str_replace ( '&ouml;', chr(246), $string );
  $string = str_replace ( '&Ouml;', chr(214), $string );
  $string = str_replace ( '&szlig;', chr(223), $string );
  $string = str_replace ( '<br>', chr(13), $string );
  return $string;
}


?>
