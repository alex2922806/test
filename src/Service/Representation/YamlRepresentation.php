<?php


namespace App\Service\Representation;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Yaml\Yaml;

final class YamlRepresentation implements EntityRepresentationInterface
{
    public function represent(array $data): Response
    {
        $yaml = Yaml::dump($data);

        $response = new StreamedResponse(
            function () use ($yaml) {
                $handle = fopen('php://output', 'r+');

                fwrite($handle, $yaml);

                fclose($handle);
            }
        );
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="entity.yaml"');

        return $response;
    }
}