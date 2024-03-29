<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class Attachment extends DataTransferObject
{
	public string $DocumentType;
	public string $FileType;
	public string $FileName;
	public ?string $AttachedData; // base-64 encoded binary
	
	public function __construct(array $data = [])
	{
		if(empty($data['AttachedData'])) {
			unset($data['AttachedData']);
		} //filled but empty. Remove.
		
		parent::__construct($data);
	}

	public function IsValidAttachment(): bool
	{
		if(empty($this->AttachedData)) {
			return false;
		}
		
		switch($this->FileType) {
			case 'PDF': return str_starts_with($this->GetBinaryFile(), '%PDF');
		}
		
		return true;
	}
	
	public function GetBinaryFile(): string
	{
		return base64_decode($this->AttachedData, true);
	}

}
