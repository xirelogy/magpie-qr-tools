<?php

namespace MagpieLib\QrTools\Codecs\Parsers;

use Magpie\Codecs\Parsers\EnumParser;
use MagpieLib\QrTools\QrCorrectionLevel;

/**
 * QrCorrectionLevel parser
 * @extends EnumParser<QrCorrectionLevel>
 */
class QrCorrectionLevelParser extends EnumParser
{
    /**
     * @inheritDoc
     */
    protected static function getEnumClassName() : string
    {
        return QrCorrectionLevel::class;
    }
}