<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use RuntimeException;
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
        if (empty($data)) {
            return ''; // Return an empty string if data is empty
        }

        $fp = fopen('php://memory', 'w+');
        if (!$fp) {
            throw new RuntimeException('Unable to open memory stream for CSV writing.');
        }

        // Add header row (keys of the first array element)
        fputcsv($fp, array_keys($data[0]));

        // Add data rows
        foreach ($data as $row) {
            if ($row instanceof Model || $row instanceof Collection) {
                $row = $row->toArray();
            } elseif (is_object($row)) {
                $row = get_object_vars($row);
            }

            // Flatten nested arrays or objects (optional, depending on your needs)
            $row = array_map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return json_encode($value); // Convert nested structures to a string
                }
                return $value;
            }, $row);

            fputcsv($fp, $row);
        }

        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);

        return $csv;
    }
}
