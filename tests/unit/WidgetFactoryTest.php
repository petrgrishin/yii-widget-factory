<?php
use PetrGrishin\WidgetFactory\WidgetFactory;

/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

class View {
    const TEST_WIDGET_CLASS = 'testWidgetClass';
    public function widget($className, $params) {
        return self::TEST_WIDGET_CLASS;
    }
}

class WidgetFactoryTest extends PHPUnit_Framework_TestCase {

    public function testCreateInstance() {
        $testWidgetParams = array(
            'title' => 'title'
        );

        /** @var \PHPUnit_Framework_MockObject_MockObject $view */
        $view = $this
            ->getMockBuilder('View')
            ->disableOriginalConstructor()
            ->setMethods(array('widget'))
            ->getMock();

        $view
            ->expects($this->once())
            ->method('widget')
            ->with(View::TEST_WIDGET_CLASS, $testWidgetParams);

        $widgetFactory = new WidgetFactory();
        $widgetFactory->setClassName(View::TEST_WIDGET_CLASS);
        $widgetFactory->setParams($testWidgetParams);
        $widgetFactory->setView($view);
        $widget = $widgetFactory->createInstance();

    }
}
 