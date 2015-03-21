<?php
/**
 * Publications
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 08.12.2014
 * @since 1.0.0
 */
namespace skeeks\cms\widgets\publicationsAll;

use skeeks\cms\base\Widget;
use skeeks\cms\models\Publication;
use skeeks\cms\models\Search;
use skeeks\cms\models\Tree;
use skeeks\cms\widgets\base\hasModels\WidgetHasModels;
use skeeks\cms\widgets\base\hasModelsSmart\WidgetHasModelsSmart;
use skeeks\cms\widgets\WidgetHasTemplate;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Class Publications
 * @package skeeks\cms\widgets\PublicationsAll
 */
class PublicationsAll extends WidgetHasModelsSmart
{
    public $modelClassName          = '\skeeks\cms\models\Publication';

    public function getDescriptorConfig()
    {
        return ArrayHelper::merge(parent::getDescriptorConfig(), [
            'name' => 'Список публикаций ( + постраничная навигация)'
        ]);
    }

    /**
     * @var null|string
     */
    public $title                   = '';
    public $types                   = [];
    public $statuses                = [];
    public $statusesAdults          = [];
    public $useCurrentTree          = 0;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'string'],
            [['types', 'statuses', 'statusesAdults', 'useCurrentTree'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'title'                         => 'Название виджета',
            'types'                         => 'Типы публикаций',
            'statuses'                      => 'Статусы',
            'statusesAdults'                => 'Статусы приватности',
            'useCurrentTree'                => 'Добавлять условия выбора записей, страницы где находится этот виджет',
        ]);
    }


    /**
     * Подготовка данных для шаблона
     * @return $this
     */
    public function bind()
    {
        /*$this->buildSearch();
        $this->getSearch()->search(\Yii::$app->request->queryParams);*/
        parent::bind();
        $dataProvider = $this->getSearch()->getDataProvider();
        $find = $dataProvider->query;

        if ($this->useCurrentTree)
        {
            $tree = \Yii::$app->cms->getCurrentTree();
            if ($tree)
            {
                $ids[] = $tree->id;
                if ($tree->hasChildrens())
                {
                    if ($childrens = $tree->fetchChildrens())
                    {
                        foreach ($childrens as $chidren)
                        {
                            $ids[] = $chidren->id;
                        }
                    }
                }

                foreach ($ids as $id)
                {
                    $find->orWhere("(FIND_IN_SET ('{$id}', tree_ids) or tree_id = '{$id}')");
                }
            }
        }


        if ($this->statuses)
        {
            $find->andWhere(['status' => $this->statuses]);
        }

        if ($this->statusesAdults)
        {
            $find->andWhere(['status_adult' => $this->statuses]);
        }

        if ($this->types)
        {
            $find->andWhere(['type' => $this->types]);
        }


        if ($this->createdBy)
        {
            $find->andWhere(['created_by' => $this->createdBy]);
        }


        if ($this->updatedBy)
        {
            $find->andWhere(['updated_by' => $this->updatedBy]);
        }

        return $this;
    }




    /**
     * @return array|null|Tree
     */
    public function fetchFirstTree()
    {
        if ($id = $this->getFirstTreeId())
        {
            return Tree::find()->where(['id' => $id])->one();
        } else
        {
            return null;
        }
    }

    /**
     * @return int
     */
    public function getFirstTreeId()
    {
        if ($this->tree_ids)
        {
            return (int) array_shift($this->tree_ids);
        } else
        {
            return 0;
        }
    }
}
