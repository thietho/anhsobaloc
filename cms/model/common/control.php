<?php
class ModelCommonControl extends Model 
{ 
	public function getButton($id, $name, $title, $link)
	{
		return '<input id="'.$id.'" name="'.$id.'" class="button '.$id.'" value="'.$title.'" type="button" onclick="linkto(\''.$link.'\')"/>&nbsp;';
	}
	
	public function getSubmit($id, $name, $title, $link)
	{
		return '<input id="'.$id.'" name="'.$name.'" class="button '.$id.'" value="'.$title.'" type="submit" /> &nbsp;';
	}
	
	public function getControlEdit($id, $name, $title, $link)
	{
		return '<a id="'.$id.'" class="button '.$name.'" href="'.$link.'" title="'.$title.'">[Edit]&nbsp;</a>';
	}
	
	public function getControlDelete($id, $name, $title, $link)
	{
		return '<a id="'.$id.'" class="button '.$name.'" href="'.$link.'" title="'.$title.'">[Delete]&nbsp;</a>';
	}
	
	public function getControlAddMember($id, $name, $title, $link)
	{
		return '<a id="'.$id.'" class="'.$name.'" href="'.$link.'" title="'.$title.'"><img src="'.DIR_VIEW.'image/addmember.png"></a>';
	}
	
	public function getComboboxData($id, $data, $selectedvalue)
	{
		foreach($data as $key => $value)
		{
			$selected = "";
			if($key == $selectedvalue) $selected = "selected='selected'";
			$str .= "<option value='".$key."' ".$selected.">".$value."</option>";
		}
		return $str;
	}
}
?>