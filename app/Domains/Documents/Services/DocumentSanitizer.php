<?php
namespace App\Domains\Documents\Services;

use HTMLPurifier;
use HTMLPurifier_Config;
class DocumentSanitizer {

    protected HTMLPurifier $purifier;
public function __construct()
{
    $config = HTMLPurifier_Config::createDefault();
    $this->purifier = new HTMLPurifier($config);
}

public function sanitize(string $html):string
{
    return $this->purifier->purify($html);
}
}