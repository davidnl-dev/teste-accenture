<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearchAndSort
{
    /**
     * Aplica busca na query usando os campos especificados
     */
    public function scopeSearch(Builder $query, ?string $searchTerm, array $searchFields): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where(function ($q) use ($searchTerm, $searchFields) {
            foreach ($searchFields as $field) {
                if (str_contains($field, '.')) {
                    // Busca em relacionamentos (ex: 'cliente.nome')
                    [$relation, $relationField] = explode('.', $field);
                    $q->orWhereHas($relation, function ($relationQuery) use ($relationField, $searchTerm) {
                        $relationQuery->where($relationField, 'like', "%{$searchTerm}%");
                    });
                } else {
                    // Busca em campos diretos
                    $q->orWhere($field, 'like', "%{$searchTerm}%");
                }
            }
        });
    }

    /**
     * Aplica ordenação na query usando os campos permitidos
     */
    public function scopeSort(Builder $query, ?string $sortField, ?string $sortDirection, array $allowedFields, string $defaultField = 'id'): Builder
    {
        $sortField = $sortField ?? $defaultField;
        $sortDirection = $sortDirection ?? 'asc';

        if (in_array($sortField, $allowedFields)) {
            return $query->orderBy($sortField, $sortDirection);
        }

        return $query->orderBy($defaultField, 'asc');
    }
}
