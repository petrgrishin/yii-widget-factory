yii-widget-factory
==================
[![Travis CI](https://travis-ci.org/petrgrishin/yii-widget-factory.png "Travis CI")](https://travis-ci.org/petrgrishin/yii-widget-factory)
[![Coverage Status](https://coveralls.io/repos/petrgrishin/yii-widget-factory/badge.png?branch=master)](https://coveralls.io/r/petrgrishin/yii-widget-factory?branch=master)

Фабрика виджетов Yiiframework

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
####Модуль
Класс модуля. Инициализируем фабрику виджета комментариев знанием (параметр виджета `listUrl`) о контроллере `comments/list`, расположеном в текущем модуле. 
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

####Основное приложение
Класс контроллера
```php
class SiteController extends CController {
    public function actionDetail() {
        $this->render('detail', array(
            'commentsWidgetFactory' => $this->getCommentsWidgetFactory(),
        ));
    }
    
    /**
     * @return \PetrGrishin\WidgetFactory\WidgetFactory
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

Представление контроллера и создание виджета в нем
```php
    $commentsWidget = $commentsWidgetFactory->createInstance(array('param' => 'value'));
    $commentsWidget->run();
```
