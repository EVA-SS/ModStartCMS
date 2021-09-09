<?php

namespace ModStart\Grid;

use ModStart\Grid\Filter\AbstractFilter;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use ModStart\Grid\Filter\DatetimeRange;
use ModStart\Grid\Filter\Eq;
use ModStart\Grid\Filter\Field\AbstractFilterField;
use ModStart\Grid\Filter\Like;
use ModStart\Grid\Filter\Likes;
use ModStart\Grid\Filter\Range;
use ReflectionClass;


class GridFilter
{
    
    protected $model;

    
    protected $filters = [];

    
    protected $supports = [
        'eq',
        'like',
        'likes',
        'range',
    ];

    
    private $field;

    
    private $search;

    
    private $scopes;



    
    public function __construct(Model $model = null)
    {
        $this->model = $model;
        $this->fixedScopes = collect();
        $this->scopes = collect();
    }

    
    public function setSearch(array $search)
    {
        $this->search = $search;
        return $this;
    }

    
    public function scope()
    {
        $scope = new GridFilterScope($this);
        $this->scopes->push($scope);
        return $scope;
    }

    
    public function addFilter(AbstractFilter $filter)
    {
        $filter->setTableFilter($this);
        return $this->filters[] = $filter;
    }

    
    public function clearFilter()
    {
        $this->filters = [];
    }

    
    public function filters()
    {
        return $this->filters;
    }

    public function getConditions()
    {
        $conditions = [];
        $search = $this->search;
        if (!empty($search)) {
            while ($searchGroup = array_shift($search)) {
                foreach ($searchGroup as $columnName => $queryInfo) {
                    foreach ($this->filters() as $filter) {
                        if ($columnName === $filter->column() && isset($queryInfo[$filter->name()])) {
                            $condition = $filter->condition($queryInfo);
                            if (!empty($condition)) {
                                $keys = array_keys($condition);
                                if (count($keys) > 1 || (count($keys) == 1 && $keys[0] === 0)) {
                                    $conditions = array_merge($conditions, $condition);
                                } else {
                                    $conditions[] = $condition;
                                }
                            }
                        }
                    }
                }
            }
        }
        return array_filter($conditions);
    }

    public function execute()
    {
        $conditions = array_merge(
            $this->getScopeConditions(),
            $this->getConditions()
        );
        return $this->model->addConditions($conditions)->buildData();
    }

    private function getScopeConditions()
    {
        return [];
    }




    
    public function __call($method, $arguments)
    {
        if (in_array($method, $this->supports)) {
            $className = '\\ModStart\\Grid\\Filter\\' . ucfirst($method);
            $reflection = new ReflectionClass($className);
            return $this->addFilter($reflection->newInstanceArgs($arguments));
        }
    }
}
