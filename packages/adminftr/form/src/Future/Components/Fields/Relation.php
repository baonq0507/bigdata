<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class Relation extends Field
{
    protected string $title = 'Relation';
    protected string $search = '';
    protected string $model;
    protected array $columns = [];
    protected string $orderBy = 'id';
    protected string $order = 'ASC';
    protected int $limit = 20;

    /**
     * Cấu hình model và các tham số truy vấn liên quan.
     *
     * @param string $model Tên đầy đủ của lớp mô hình.
     * @param array $columns Các cột cần chọn. Có thể bao gồm mối quan hệ và tìm kiếm tùy chỉnh.
     * @param string $orderBy Cột để sắp xếp.
     * @param string $order Hướng sắp xếp, 'asc' hoặc 'desc'.
     * @param int $limit Số lượng kết quả tối đa.
     * @return $this
     */
    public function model(
        string $model,
        array $columns = ['id' => 'id', 'name' => 'name'],
        string $orderBy = 'id',
        string $order = 'asc',
        int $limit = 20
    ): self {
        // Định nghĩa các cột được phép
        $allowedColumns = ['id', 'name', 'description', 'avatar','sub_title'];

        // Lọc các cột để chỉ lấy các cột được phép
        $this->columns = array_intersect_key($columns, array_flip($allowedColumns));
        $this->model = $model;
        $this->orderBy = $orderBy;
        $this->order = strtolower($order) === 'desc' ? 'desc' : 'asc';
        $this->limit = $limit;

        return $this;
    }

    /**
     * Lấy các bản ghi liên quan dựa trên tiêu chí tìm kiếm.
     *
     * @param string $search Thuật ngữ tìm kiếm.
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function relation(string $search)
    {
        $this->search = $search;

        if (empty($this->model)) {
            throw new Exception('Model is not set.');
        }

        /** @var Model $modelClass */
        $modelClass = $this->model;

        // Khởi tạo mảng cho các cột trực tiếp và các mối quan hệ cần eager load
        $directColumns = [];
        $withRelations = [];

        foreach ($this->columns as $key => $column) {
            if (is_array($column)) {
                if (isset($column['relation'])) {
                    $withRelations[] = $column['relation'];
                }
                if (isset($column['name'])) {
                    $directColumns[] = $column['name'];
                }
            } else {
                $directColumns[] = $column;
            }
        }

        // Đảm bảo rằng 'id' luôn được chọn để xử lý mối quan hệ đúng cách
        if (!in_array('id', $directColumns)) {
            $directColumns[] = 'id';
        }

        // Xây dựng truy vấn
        $query = $modelClass::query()
            ->select($directColumns)
            ->with($withRelations)
            ->orderBy($this->orderBy, $this->order)
            ->limit($this->limit);

        // Áp dụng điều kiện tìm kiếm nếu có
        if (!empty($this->search)) {
            $query->where(function (Builder $q) {
                foreach ($this->columns as $key => $column) {
                    if (is_array($column)) {
                        if (isset($column['search'])) {
                            if (is_callable($column['search'])) {
                                // Áp dụng logic tìm kiếm tùy chỉnh
                                $column['search']($q, $this->search);
                            } elseif (isset($column['column'])) {
                                // Áp dụng tìm kiếm 'like' mặc định
                                $q->orWhere($column['column'], 'like', '%' . $this->search . '%');
                            }
                        }
                    } else {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        // Thực thi truy vấn
        $results = $query->limit($this->limit)->get();

        // Chuyển đổi kết quả
        return $results->map(function ($item) {
            $result = [];
            foreach ($this->columns as $key => $column) {
                if (is_array($column)) {
                    if (isset($column['column']) && is_callable($column['column'])) {
                        $result[$key] = call_user_func($column['column'], $item);
                    } elseif (isset($item->{$column['column']})) {
                        $result[$key] = $item->{$column['column']};
                    } else {
                        $result[$key] = null;
                    }
                } else {
                    $result[$key] = $item->{$column};
                }
            }
            return $result;
        });
    }

    /**
     * Thiết lập tiêu đề cho trường quan hệ.
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Render view cho trường quan hệ.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('form::base.form.relation', [
            'name' => $this->name,
            'title' => $this->title,
            'label' => $this->label,
            'required' => $this->isRequired,
        ]);
    }
}
