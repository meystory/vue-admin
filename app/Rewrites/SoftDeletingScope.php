<?php

namespace App\Rewrites;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder as Query;
class SoftDeletingScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['ForceDelete', 'Restore', 'WithTrashed', 'OnlyTrashed'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(),0);

        $this->extend($builder);
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        $column = $model->getQualifiedDeletedAtColumn();

        $query = $builder->getQuery();

        //其实就是array_filter()实现  
        $query->wheres = collect($query->wheres)->reject(function ($where) use ($column, $query) {
            
            return $this->isSoftDeleteConstraint($where, $column, $query);
        })->values()->all();
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $column = $this->getDeletedAtColumn($builder);

            return $builder->update([
                $column => time(),
            ]);
        });
    }

    /**
     * Get the "deleted at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getDeletedAtColumn(Builder $builder)
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedDeletedAtColumn();
        } else {
            return $builder->getModel()->getDeletedAtColumn();
        }
    }

    /**
     * Add the force delete extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addForceDelete(Builder $builder)
    {
        $builder->macro('forceDelete', function (Builder $builder) {
            return $builder->getQuery()->delete();
        });
    }

    /**
     * Add the restore extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update([$builder->getModel()->getDeletedAtColumn() => 0]);
        });
    }

    /**
     * Add the with-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithTrashed(Builder $builder)
    {
        $builder->macro('withTrashed', function (Builder $builder) {
            $this->remove($builder, $builder->getModel());

            return $builder;
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $this->remove($builder, $model);

            $builder->getQuery()->where($model->getQualifiedDeletedAtColumn(),'>',0);

            return $builder;
        });
    }

    /**
     * Determine if the given where clause is a soft delete constraint.
     *
     * @param  array   $where
     * @param  string  $column
     * @return bool
     */
    protected function isSoftDeleteConstraint(array $where, $column, Query $query)
    {   
        //判断是否软删除对应的where
        //1 将其从wheres 数组中去掉
        //2 将绑定参数从bindings['where'] 里去掉
        //除了要去掉软删除对应的where数组，也要去掉bindings数组where对应的一个元素
        //(软删除在QueryBuilder实例化时，全局scope对应的参数优先写入where绑定的参数里,也就是必定是where数组中的第一个元素)
    
        $isSoft = $where['value'] === 0 && $where['column'] == $column;
        if($isSoft){
            $bindings = $query->getRawBindings()['where'];
            array_shift($bindings);
            //重新设置where中的绑定数据
            $query->setBindings($bindings);
        }
        return $isSoft;
    }
}
