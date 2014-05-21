yii-widget-factory
==================
[![Travis CI](https://travis-ci.org/petrgrishin/yii-widget-factory.png "Travis CI")](https://travis-ci.org/petrgrishin/yii-widget-factory)
[![Coverage Status](https://coveralls.io/repos/petrgrishin/yii-widget-factory/badge.png?branch=master)](https://coveralls.io/r/petrgrishin/yii-widget-factory?branch=master)

Фабрика виджетов

Установка
------------
Добавите зависимость для вашего проекта в composer.json:
```json
{
    "require": {
        "petrgrishin/yii-widget-factory": "dev-master"
    }
}
```

Постановка проблемы
------------
Необходимо использовать виджеты реализованные в модуле, которые имеют зависимости от модуля, например знание о контроллере модуля.

Решение
------------
Реализовать в модуле создание фабрики виджетов и проинициализировать его знаниями расположеными в нем. Для использования виджета в приложении, использовать созданную фабрику.

Пример решения
------------
####Класс модуля
```php
use \PetrGrishin\WidgetFactory\WidgetFactory;

class CommentsModule extends CWebModule {
    public function getCommentsWidgetFactory() {
        if (empty($this->_commentsWidgetFactory)) {
            $this->_commentsWidgetFactory = new WidgetFactory();
            $this->_commentsWidgetFactory
                ->setClassName(Widgets\CommentsWidget::className())
                ->setParams(array(
                    'listUrl' => $this->createModuleUrlBuilder('comments/list'),
                ));
        }
        return $this->_commentsWidgetFactory;
    }
}
```

####Контроллер основного приложения
```php
class SiteController extends CController {
    public function actionDetail() {
        $this->render('detail', array(
            'commentsWidgetFactory' => $this->getCommentsWidgetFactory(),
        ));
    }
    
    /**
     * @return CommentsModule
     */
    protected function getCommentsWidgetFactory() {
        return $this->getCommentsModule()->getCommentsWidgetFactory()
            ->setView($this);
    }
    
    /**
     * @return CommentsModule
     */
    protected function getCommentsModule() {
        return Yii::app()->getModule('comments');
    }
}
```

####Представление контроллера
```php
    $commentsWidgetFactory->createInstance(array('param' => 'value'))->run();
```
