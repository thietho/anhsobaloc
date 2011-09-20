<?php
final class Validation
{
	function _checkLetterOnly( $string )
	{
		$Message = true ;
		(ereg("^[a-zA-Z]+$", $string)) ? $Message = true : $Message = false ;
		return $Message ;
	}
	
	function _isId( $string )
	{
		$Message = true ;
		(ereg("^[a-zA-Z0-9]+$", $string)) ? $Message = true : $Message = false ;
		return $Message ;
	}
	
	function _checkLetterNunberOnly( $string )
	{
		$Message = true ;
		(ereg("^[a-zA-Z0-9 ]+$", $string)) ? $Message = true : $Message = false ;
		return $Message ;
	}
	
	function _checkTextOnly( $string )
	{
		$Message = true ;
		(ereg("^[a-zA-Z0-9_* ]+$", $string)) ? $Message = true : $Message = false ;
		return $Message ;
	}
	
	function _checkEmail( $string )
	{
		$Message = NULL ;
		(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $string)) ? $Message = true : $Message = false ; 
		return $Message ;
	}
	
	function _checkNumberOnly( $string )
	{
		$Message = NULL ;
		(ereg("^[_0-9-]+$", $string)) ? $Message = true : $Message = false  ;
		return $Message ;
	}
	
	function checkEmty( $string )
	{
		if(empty($string)) return true;
		return false;
	}
}
?>
