<?php


namespace App\Service\Representation;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class CsvRepresentation implements EntityRepresentationInterface
{
    public function represent(array $data): Response
    {
        $response = new StreamedResponse(
            function () use ($data) {
                $handle = fopen('php://output', 'r+');
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            }
        );
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="entity.csv"');

        return $response;
    }
}