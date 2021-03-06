<?php

namespace Dainsys\Locky\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

trait PaginationTrait
{
    use WithPagination;
    /**
     * Indicates livewire to render the bootstrap view. 
     * Comment / Delete if you are using tailwind.
     */
    protected $paginationTheme = 'bootstrap';
    /**
     * Field to sort by
     */
    public string $sortBy = '';
    /**
     * Search query string
     */
    public string $search = '';
    /**
     * Sorting direction. Default Asc, will toggle to Desc
     */
    public string $sortDirection = 'asc';
    /**
     * Pagination Amount
     */
    public int $amount = 10;
    /**
     * Eloquent model placeholder
     */
    protected Builder $model;
    /**
     * Array of fields that will be searched. 
     * Passed as second parameter in the getPaginatedData() method.
     */
    protected array $searchabeFields;
    /**
     * The default field to sort the model by. 
     * If this field does not exists in the model, override in the component's render() method.
     */
    protected string $defaultSortField = 'name';
    /**
     * Retrieve the paginated data. It serves as the controller of this class.
     *
     * @param Builder $model
     * @param array $searchabeFields
     * @return void
     */
    public function getPaginatedData(Builder $model, array $searchabeFields = ['name'])
    {
        $this->model = $model;

        $this->searchabeFields = $searchabeFields;

        $this->handleSearch()
            ->handleSort();

        return $this->model->paginate($this->amount);
    }
    /**
     * Reset the page query string when searching.
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    /**
     * Perform the sort by the given field. Called from the view.
     *
     * @param string $field
     * @return void
     */
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }
    /**
     * return the sort icon. Called from the view.
     *
     * @param string $field
     * @return void
     */
    public function getIcon($field)
    {
        $icons = config('locky.icons');

        if (!$this->sortBy || $this->sortBy !== $field) {
            return $icons['both'];
        }

        return $icons[$this->sortDirection];
    }
    /**
     * Return an array of with the filter amounts
     */
    public function filterAmounts(int $number, array $defaults = [10, 25, 50, 100]): array
    {
        $intervals = array();
        $intervals = array_filter($defaults, function ($item) use ($number) {
            return $item < $number;
        });
        if (!in_array($number, $intervals)) {
            $intervals[] = $number;
        }
        return (array)$intervals;
    }
    /**
     * Toggle the sortDirection var.
     *
     * @return void
     */
    protected function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
    /**
     * Perform the searching logic.
     *
     * @return object
     */
    protected function handleSearch(): object
    {
        if ($this->search && strlen($this->search) > 0) {
            foreach (explode(" ", $this->search) as $value) {
                $this->model->where(function ($query) use ($value) {
                    foreach ($this->searchabeFields as $field) {
                        $fields = explode('.', $field, 2);
                        if (count($fields) == 1) {
                            $query->orWhere($fields[0], 'like', "%{$value}%");
                        } else {
                            $relation = $fields[0];
                            $field_name = $fields[1];
                            $query->orWhereHas($relation, function ($query) use ($field_name, $value) {
                                $query->where($field_name, 'like', "%{$value}%");
                            });
                        }
                    }
                });
            }
        }

        return $this;
    }
    /**
     * Perform the sorting in the model.
     *
     * @return object
     */
    protected function handleSort(): object
    {
        if (!$this->sortBy || $this->sortBy == '') {
            $this->sortBy = $this->defaultSortField;
            $this->model->orderBy($this->defaultSortField);
        } else {
            $sorts = explode('.', $this->sortBy);

            if (count($sorts) == 1) {
                $this->model->orderBy($sorts[0], $this->sortDirection);
            }
        }

        return $this;
    }
}
