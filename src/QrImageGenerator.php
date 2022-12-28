<?php

namespace MagpieLib\QrTools;

use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh as EndroidErrorCorrectionLevelHigh;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface as EndroidErrorCorrectionLevelInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow as EndroidErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium as EndroidErrorCorrectionLevelMedium;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile as EndroidErrorCorrectionLevelQuartile;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter as EndroidPngWriter;
use Exception;
use Magpie\Exceptions\OperationFailedException;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Concepts\BinaryContentable;
use Magpie\General\Contents\SimpleBinaryContent;

/**
 * QR-code image generator
 */
class QrImageGenerator
{
    /**
     * @var EndroidQrCode Underlying target
     */
    protected readonly EndroidQrCode $target;


    /**
     * Constructor
     * @param string $data
     */
    protected function __construct(string $data)
    {
        $this->target = EndroidQrCode::create($data);
    }


    /**
     * Specify the image size
     * @param int $size
     * @return $this
     */
    public function withSize(int $size) : static
    {
        $this->target->setSize($size);
        return $this;
    }


    /**
     * Specify the error correction level
     * @param QrCorrectionLevel $level
     * @return $this
     */
    public function withCorrection(QrCorrectionLevel $level) : static
    {
        $this->target->setErrorCorrectionLevel(static::translateQrCorrectionLevel($level));
        return $this;
    }


    /**
     * Generate a PNG image output
     * @return BinaryContentable
     * @throws SafetyCommonException
     */
    public function generatePng() : BinaryContentable
    {
        $writer = new EndroidPngWriter();

        try {
            $data = $writer->write($this->target);
        } catch (Exception $ex) {
            throw new OperationFailedException(previous: $ex);
        }

        return SimpleBinaryContent::create($data->getString(), $data->getMimeType());
    }


    /**
     * Create a new generator instance
     * @param string $data
     * @return static
     */
    public static function for(string $data) : static
    {
        return new static($data);
    }


    /**
     * Translate the QR-code correction level
     * @param QrCorrectionLevel $level
     * @return EndroidErrorCorrectionLevelInterface
     */
    protected static function translateQrCorrectionLevel(QrCorrectionLevel $level) : EndroidErrorCorrectionLevelInterface
    {
        return match ($level) {
            QrCorrectionLevel::L => new EndroidErrorCorrectionLevelLow(),
            QrCorrectionLevel::M => new EndroidErrorCorrectionLevelMedium(),
            QrCorrectionLevel::Q => new EndroidErrorCorrectionLevelQuartile(),
            QrCorrectionLevel::H => new EndroidErrorCorrectionLevelHigh(),
        };
    }
}