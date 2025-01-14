<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseHelper
{
    public static function formatResponse($data, $statusCode = Response::HTTP_OK): Response
    {
        $format = self::getResponseFormat(request());

        if ($format === 'csv') {
            if (!isset($data[0])) {
                $data = [$data];
            }

            try {
                $csv = self::toCsv($data);
                return response($csv, $statusCode)->header('Content-Type', 'text/csv');
            } catch (\Exception $e) {
                error_log("CSV Conversion Error: " . $e->getMessage());
                return self::formatResponse(['error' => 'Failed to convert data to CSV'], 500);
            }
        }

        return response()->json($data, $statusCode);
    }

    static private function getResponseFormat(Request $request): string
    {
        $acceptHeader = $request->header('Accept');
        if (str_contains($acceptHeader, 'text/csv')) {
            return 'csv';
        }

        return 'json';
    }

    static private function toCsv($data)
    {
        $fp = fopen('php://memory', 'w+');

        if (!empty($data)) {
            fputcsv($fp, array_keys($data[0]));
        }

        foreach ($data as $row) {
            if ($row instanceof Model || $row instanceof Collection) {
                $row = $row->toArray();
            } elseif (is_object($row)) {
                $row = get_object_vars($row);
            }

            fputcsv($fp, $row);
        }

        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);

        return $csv;
    }
}
