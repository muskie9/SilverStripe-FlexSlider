<?php

class Slide extends DataObject {

	static $db = array(
		"Name" => "Text",
		'Description' => 'Text',
		'SortOrder' => 'Int'
	);
	
	static $has_one = array(
		"Image" => "SlideImage",
		"Page" => "Page",
		"PageLink" => "SiteTree"
	);
	
	static $singular_name = "Slide";
	static $plural_name = "Slides";
	
	static $default_order = "SortOrder";
	
	static $summary_fields = array (
		'Name' => 'Caption',
		'GridThumb' => 'Image'
	);
		
	public function GridThumb() {
		$Image = $this->Image();
		if ( $Image ) 
			return $Image->CMSThumbnail();
		else 
			return null;
	}
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$ImageField = new UploadField('Image', 'Image');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
		$ImageField->setFolderName('Uploads/SlideImages');
		$ImageField->setConfig('allowedMaxFileNumber', 1);
	   	
	   	$fields->addFieldsToTab('Root.Main',array(
	   		new TextField('Name'),
			TextareaField::create('Description'),
			$ImageField,
			new TreeDropdownField("PageLinkID", "Choose a page to link to:", "SiteTree")
		));
		$fields->removeFieldsFromTab('Root.Main',array(
			'SortOrder',
			'PageID'));
		return $fields;
	}
	
	public function Thumbnail() {
		return $this->Image()->CroppedImage(80,80);
	}
	
	public function Large() {
		if ($this->Image()->GetHeight() > 700) {
			return $this->Image()->SetHeight(700);
		} else {
			return $this->Image();
		}
	}
	
	/*
	public function PaddedSlide() {
		if ($this->Page() && $this->Page()->SliderWidth && $this->Page()->SliderHeight) {
			$width = $this->Page()->SliderWidth;
			$height = $this->Page()->SliderHeight;
		} else {
			$width = 640;
			$height = 400;
		}
		return $this->Image()->PaddedImage($width, $height);
	}
	*/
	
	public function CroppedSlide() {
		if ($this->Page() && $this->Page()->SliderWidth && $this->Page()->SliderHeight) {
			$width = $this->Page()->SliderWidth;
			$height = $this->Page()->SliderHeight;
		} else {
			$width = 640;
			$height = 400;
		}
		return $this->Image()->CroppedImage($width, $height);
	}
	
	function canCreate($member=null) { return true; } 
	function canEdit($member=null) { return true; } 
	function canDelete($member=null) { return true; }
	function canView($member=null) { return true; }
}

class SlideImage extends Image {

	function generateThumb($gd) {
		return $gd->croppedResize(85,85);
	}

	function generatePaddedSlide($gd, $width = 600, $height = 400, $color = "000"){
		return $gd->paddedResize($width, $height, $color);
	}

}