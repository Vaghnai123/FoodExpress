<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class ClearDatabaseController extends Controller
{
    protected $blockedTables = [
        'users',
        'migrations',
        'password_reset_tokens',
        'personal_access_tokens',
        'failed_jobs',
        'sessions',
        'cache',
        'cache_locks'
    ];

    public function index()
    {
        $databaseName = DB::connection()->getDatabaseName();
        $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?", [$databaseName]);

        $tableNames = [];
        foreach ($tables as $table) {
            $tableNames[] = $table->TABLE_NAME;
        }

        $allowedTables = array_diff($tableNames, $this->blockedTables);
        sort($allowedTables);

        $path = public_path('uploads');
        $files = [];
        $preserveFiles = ['avatar.png','default.png'];

        if (File::exists($path)) {
            $allFiles = File::allFiles($path);
            foreach ($allFiles as $file) {
                $filename = $file->getFilename();

                if (!in_array($filename, $preserveFiles)) {
                    $files[] = [
                        'name' => $filename,
                        'path' => asset('uploads/' . $filename),
                        'size' => number_format($file->getSize() / 1024, 2) . ' KB',
                        'ext'  => strtolower($file->getExtension())
                    ];
                }
            }
        }

        return view('admin.clear-database.index', compact('allowedTables', 'files'));
    }

    public function clearTable(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string'
        ]);

        $tableName = $request->table_name;

        if (in_array($tableName, $this->blockedTables)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Action Denied: You cannot clear sensitive system tables.'
            ], 403);
        }

        if (!Schema::hasTable($tableName)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: The selected table does not exist.'
            ], 404);
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($tableName)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json([
                'status' => 'success',
                'message' => "Data from table '{$tableName}' has been cleared successfully!"
            ]);

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSelectedFiles(Request $request)
    {
        $request->validate([
            'selected_files' => 'required|array',
            'selected_files.*' => 'string'
        ]);

        try {
            $deletedCount = 0;
            $path = public_path('uploads/');

            foreach ($request->selected_files as $filename) {
                $safeFilename = basename($filename);

                if (File::exists($path . $safeFilename)) {
                    File::delete($path . $safeFilename);
                    $deletedCount++;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => "Successfully deleted {$deletedCount} files!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
