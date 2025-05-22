<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportDbController extends Controller
{
    public function export()
    {
        $dumpPath = env('MYSQLDUMP_PATH', 'D:\\xampp\\mysql\\bin\\mysqldump.exe');
        $host = '127.0.0.1';
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $dbName = env('DB_DATABASE', '');

        if (!$dbName) {
            return response()->json(['error' => 'Database name not set'], 500);
        }

        $fileName = 'backupbier.sql';
        $filePath = storage_path("app/{$fileName}");

        $command = "$dumpPath -h $host -u $username";

        if ($password !== '') {
            $command .= " -p$password";
        }

        $command .= " $dbName";

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return response()->json(['error' => 'Backup failed, return code: ' . $returnVar], 500);
        }

        file_put_contents($filePath, implode("\n", $output));

        $fileName = 'backupbier.sql';
        $filePath = storage_path("app/{$fileName}");

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Backup file not found'], 404);
        }

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,txt',
        ]);

        $file = $request->file('sql_file');
        $filePath = $file->getPathname();

        $mysqlPath = env('MYSQL_PATH', 'C:\\xampp\\mysql\\bin\\mysql.exe');
        $host = '127.0.0.1';
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $dbName = env('DB_DATABASE', '');

        if (!$dbName) {
            return response()->json(['error' => 'Database name not set'], 500);
        }

        $command = "\"$mysqlPath\" -h $host -u $username";

        if ($password !== '') {
            $command .= " -p$password";
        }

        $command .= " $dbName < \"$filePath\"";

  
        $output = null;
        $returnVar = null;

        $fullCommand = "\"$mysqlPath\" -h $host -u $username";
        if ($password !== '') {
            $fullCommand .= " -p$password";
        }
        $fullCommand .= " $dbName < \"$filePath\"";

        $result = shell_exec($fullCommand . ' 2>&1');// récupère la sortie d'erreur aussi

        if (strpos($result, 'ERROR') !== false || strpos($result, 'error') !== false) {
            return response()->json(['error' => 'Import failed: ' . $result], 500);
        }

        return response()->json(['message' => 'Database imported successfully']);
    }
}
