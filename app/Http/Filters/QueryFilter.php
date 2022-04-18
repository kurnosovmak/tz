<?php
namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = QueryFilter::camelCase($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array)$value);
            }
        }
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return array_filter(
            array_map('trim', $this->request->all())
        );
    }

    /**
     * Get query.
     *
     * @return array|string|null
     */
    public function filters(): array|string|null
    {
        return $this->request->query();
    }

    /**
     * @return string
     */
    public static function camelCase($string, $dontStrip = []): string
    {

        return lcfirst(str_replace(' ', '', ucwords(preg_replace('/^a-z0-9' . implode('', $dontStrip) . ']+/', ' ', $string))));
    }
}
