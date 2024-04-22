<?php

namespace App\Services\VesselTracking;

use Illuminate\Support\Collection;
use Spatie\ArrayToXml\ArrayToXml;
use SplTempFileObject;
use Illuminate\Http\Response;

class VesselTrackingResponseMapper
{
    public function map(string $contentType, Collection $data) : Response
    {
        $contentType = ContentType::from($contentType);

        $data = $this->transformPointToCoordinate($data);

        return match ($contentType->name) {
            'XML' => $this->mapToXml($contentType, $data),

            'CSV' => $this->mapToCsv($contentType, $data),

            'JSON' => $this->mapToJson($contentType, $data),

            'API_JSON' => $this->mapToApiJson($contentType, $data),

            default => null,
        };
    }

    private function mapToXml(ContentType $contentType, Collection $data): Response
    {
        $xmlString = ArrayToXml::convert(['data' => $data->toArray()], 'root', true, 'UTF-8');

        return response($xmlString, Response::HTTP_OK, [
            'Content-Type' => $contentType->value
        ]);
    }

    private function mapToCsv(ContentType $contentType, Collection $data) : Response
    {
        if ($data->isEmpty() === true) {
            return response($data->toJson(), Response::HTTP_OK, [
                'Content-Type' => $contentType->value,
            ]);
        }

        $tempFile = new SplTempFileObject();

        $tempFile->fputcsv(array_keys($data->toArray()[0]));

        $data->each(function ($item) use ($tempFile) {
            $tempFile->fputcsv($item->toArray());
        });

        $csvContent = '';
        foreach ($tempFile as $line) {
            $csvContent .= $line;
        }

        return response($csvContent, Response::HTTP_OK, [
            'Content-Type' => $contentType->value,
            'Content-Disposition' => 'attachment; filename="data.csv"',
        ]);
    }

    private function mapToJson(ContentType $contentType, Collection $data) : Response
    {
        return response($data->toJson(), Response::HTTP_OK, [
            'Content-Type' => $contentType->value,
        ]);
    }

    private function mapToApiJson(ContentType $contentType, Collection $data) : Response
    {
        $data = $data->map(function ($item) {
            $id = $item['id'];
            unset($item['id']);

            $jsonApiData['data'][] = [
                'type' => 'items',
                'id' => $id,
                'attributes' => $item,
            ];

            return $jsonApiData;
        });

        return response($data, Response::HTTP_OK, [
            'Content-Type' => $contentType->value
        ]);
    }

    private function transformPointToCoordinate(collection $data): Collection
    {
        return $data->map(function ($item) {
            $array =$item->toArray();
            $array['lat'] = $item->coordinates->latitude;
            $array['log'] = $item->coordinates->longitude;
            unset($array['coordinates']);

            return collect($array);
        });
    }
}
