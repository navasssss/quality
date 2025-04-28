<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AllDocument extends Model
{
    protected $table = 'all_documents'; // Placeholder, we override it

    public static function query(): Builder
    {
        $query = DB::table('quality_manuals')
            ->selectRaw("'Quality Manual' as type, document_number as number, document_title as title, revision")
            ->union(DB::table('quality_policies')
                ->selectRaw("'Quality Policy' as type, policy_number as number, policy_title as title, revision"))
            ->union(DB::table('quality_procedures')
                ->selectRaw("'Quality Procedure' as type, number, title, revision"))
            ->union(DB::table('ndt_reports')
                ->selectRaw("'NDT Report' as type, number, title, revision"))
            ->union(DB::table('ndt_instructions')
                ->selectRaw("'NDT Instruction' as type, number, title, revision"));

        return static::query()->fromSub($query, 'all_documents'); // ✅ Convert to Eloquent Builder
    }
}