<?php

namespace MagpieLib\QrTools;

/**
 * QR-code correction level
 */
enum QrCorrectionLevel : string
{
    /**
     * Level L - up to 7% damage correction
     */
    case L = 'l';
    /**
     * Level M - up to 15% damage correction
     */
    case M = 'm';
    /**
     * Level Q - up to 25% damage correction
     */
    case Q = 'q';
    /**
     * Level H - up to 30% damage correction
     */
    case H = 'h';
}