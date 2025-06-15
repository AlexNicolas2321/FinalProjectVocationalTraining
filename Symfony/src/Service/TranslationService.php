<?php

namespace App\Service;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    private $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate('en');
    }

    public function translateToEnglish(string $text): string
    {
        return $this->translator->translate($text);
    }
}