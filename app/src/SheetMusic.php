<?php

namespace ChristelMusic;

use Spatie\PdfToImage\Pdf;

class SheetMusic
{
    const TEMP_DIR = __DIR__ . '/../cache/sheetmusic/';
    const PDF_DIR = __DIR__ . '/../public/assets/sheetmusic/';

    private ?Pdf $pdf = null;

    public function __construct(
        public string $songName,
        public string $pdfFilename
    ) {
        if (!file_exists(self::TEMP_DIR)) {
            mkdir(self::TEMP_DIR, 0777, true);
        }
    }

    private function getPdf(): Pdf
    {
        if ($this->pdf === null) {
            $this->pdf = new Pdf($this->getPdfPath());
        }

        return $this->pdf;
    }

    public function getPdfPath(): string
    {
        return self::PDF_DIR . $this->pdfFilename;
    }

    public function getPdfUrl(): string
    {
        return '/assets/sheetmusic/' . $this->pdfFilename;
    }

    public function getNumberOfPages(): int
    {
        // Cache in a file, since it is very slow to create the Pdf instances.
        $cacheFile = self::TEMP_DIR . basename($this->pdfFilename, '.pdf') . '.json';

        if (!file_exists($cacheFile)) {
            $jsonData = [
                'numberOfPages' => $this->getPdf()->getNumberOfPages(),
            ];
            file_put_contents($cacheFile, json_encode($jsonData));
        }

        return json_decode(file_get_contents($cacheFile))->numberOfPages;
    }

    public function getBase64encodedPngData(): string
    {
        $pngPath = self::TEMP_DIR . basename($this->pdfFilename, '.pdf') . '.png';

        if (!file_exists($pngPath)) {
            $this->getPdf()->saveImage($pngPath);
        }

        return base64_encode(file_get_contents($pngPath));
    }
}
