<?php declare(strict_types=1);


namespace App\DataCollector;


use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Throwable;

final class CacheSizeCollector extends DataCollector
{
    private string $rootDirectory;

    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

    public function collect(
        Request $request,
        Response $response,
        Throwable $exception = null
    )
    {
        $directorySize = $this->getDirectorySize($this->rootDirectory . '/var/cache') / 1024 / 1024;
        $this->data = [ 'size' => (int) $directorySize ];
    }

    public function getName(): string
    {
        return 'app.cache_size';
    }

    public function reset(): array
    {
        return $this->data = [];
    }

    public function getSize(): int
    {
        return $this->data['size'];
    }

    private function getDirectorySize(string $path): int
    {
        $bytesTotal = 0;
        $path = realpath($path);

        if($path !== false && $path !== '' && file_exists($path)) {

            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {

                $bytesTotal += $object->getSize();

            }
        }

        return $bytesTotal;
    }
}
