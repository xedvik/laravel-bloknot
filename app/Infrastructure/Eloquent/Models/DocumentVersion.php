<?php
namespace App\Infrastructure\Eloquent\Models;
use Illuminate\Database\Eloquent\Model;

class  DocumentVersion extends Model
{
    protected $table = 'document_versions';
    protected $fillable = ['content','document_id'];

    public function versions(){
        return $this->belongsTo(Document::class);
    }
}

