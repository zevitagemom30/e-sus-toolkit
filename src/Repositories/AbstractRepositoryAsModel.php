<?php

namespace OM30\EsusToolkit\Repositories;

use OM30\EsusToolkit\Exceptions\ResourceNotFoundException;
use OM30\EsusToolkit\Helpers\DateTimeHelper;
use OM30\EsusToolkit\Models\AbstractModel;

abstract class AbstractRepositoryAsModel extends AbstractRepository
{
    protected AbstractModel $model;

    /**
     * Campo que representa o id da entidade pai
     *
     * @var string
     */
    protected $parentIdField;

    /**
     * Campo que representa o id da entidade que será sincronizada
     *
     * @var string
     */
    protected $entityIdField;

    public function setModel(AbstractModel $model)
    {
        $this->model = $model;
    }

    public function getModel(): AbstractModel
    {
        return $this->model;
    }

    public function getTable(): string
    {
        return $this->getModel()->getTable();
    }

    public function getDeletedAtColumn()
    {
        return $this->getModel()->getDeletedAtColumn();
    }

    public function getCreatedAtColumn()
    {
        return $this->getModel()->getCreatedAtColumn();
    }

    public function getUpdatedAtColumn()
    {
        return $this->getModel()->getUpdatedAtColumn();
    }

    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    public function updateOrCreate(array $condition, array $data)
    {
        return $this->getModel()->updateOrCreate($condition, $data);
    }

    public function updateOrFail(int $id, array $data)
    {
        $entity = $this->getModel()->findOrFail($id);
        $entity->update($data);

        return $entity;
    }

    public function deleteByCondition(array $condition)
    {
        return $this->getModel()->where($condition)->delete();
    }

    public function insert(array $data)
    {
        return $this->getModel()->insert($data);
    }

    public function update(AbstractModel $model)
    {
        return $model->save();
    }

    public function delete(AbstractModel $model)
    {
        return $model->delete();
    }

    public function deleteOrFail(int $id)
    {
        $query = $this->getById($id);

        if (is_null($query)) {
            throw new ResourceNotFoundException();
        }

        return $query->deleteOrFail();
    }

    public function getActives()
    {
        return $this->getModel()->where([
            'active' => 1,
        ])->get();
    }

    public function get()
    {
        return $this->getModel()->get();
    }

    public function destroy(int $id)
    {
        return $this->getModel()->destroy($id);
    }

    public function getById(int $id)
    {
        return $this->getModel()->find($id);
    }

    public function deleteIfNotIn(array $ids, int $parentId)
    {
        return $this->getModel()->where($this->parentIdField, $parentId)->whereNotIn('id', $ids)->delete();
    }

    /**
     * Sincroniza os registros de uma entidade com o id pai
     *
     * @param int $id Id do pai
     * @param array $syncIds Ids da entidade que será sincronizada
     */
    public function syncRecords(int $id, array $syncIds)
    {
        $existingRecords = $this->model
            ->where($this->parentIdField, $id)
            ->whereIn($this->entityIdField, $syncIds)
            ->get();
        $existingRecordIds = $existingRecords->pluck('id')->toArray();
        $existingEntityIds = $existingRecords->pluck($this->entityIdField)->toArray();
        $this->deleteIfNotIn($existingRecordIds, $id);
        $notPresentEntityIds = array_diff($syncIds, $existingEntityIds);
        $insertData = [];
        foreach ($notPresentEntityIds as $syncId) {
            $insertData[] = [
                $this->parentIdField => $id,
                $this->entityIdField => $syncId,
                $this->getUpdatedAtColumn() => now(),
                $this->getCreatedAtColumn() => now(),
            ];
        }

        return $this->insert($insertData);
    }

    /**
     * Insere os registros de uma entidade com o id pai
     *
     * @param int $id Id do pai
     * @param array $insertIds Ids da entidade que será sincronizada
     */
    public function insertRecords(int $id, array $insertIds)
    {
        $insertData = [];
        foreach ($insertIds as $insertId) {
            $insertData[] = [
                $this->parentIdField => $id,
                $this->entityIdField => $insertId,
                $this->getUpdatedAtColumn() => now(),
                $this->getCreatedAtColumn() => now(),
            ];
        }

        return $this->insert($insertData);
    }

    /**
     * Insere registro com a chave do campo relacional
     * com o ID inserido na tabela Pai.
     * @param string $key
     * @param int $value
     * @param array $payloadItens
     * @return mixed
     */
    public function insertValueObjectsRelation(string $key, int $value, array $payloadItens)
    {
        $insertData = [];
        foreach ($payloadItens as $item) {
            $item[$key] = $value;
            $insertData[] = $item;
        }

        $insertData = DateTimeHelper::addTimestampColumns($insertData, $this->getModel());

        return $this->insert($insertData);
    }

    /**
     * Captura o registro de acordo com a coluna e o valor passado
     *
     * @param string $column
     * @param bool|int|string $value
     */
    public function findByColumn(string $column, bool|int|string $value)
    {
        $query = $this->getModel()->where($column, $value);
        return $query->get();
    }
}
