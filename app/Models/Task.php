<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'status' => 'string',
    ];


    public static function createTask(string $title, string $description, string $status): Task
    {
        return self::create([
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);
    }

    public static function checkTaskExist(string $title)
    {
        return self::where('title', $title)->exists();

    }

    public static function checkStatusAvaible(string $status): bool
    {
        if ($status != 'Concluído' && $status != 'Pendente' && $status != 'Em andamento') {
            return false;
        }

        return true;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('title', 'ilike', "%$search%")
                ->orWhere('description', 'ilike', "%$search%");
        }

        return $query;
    }


}
