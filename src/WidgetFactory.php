<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\WidgetFactory;


class WidgetFactory {
    private $_view;
    private $_className;
    private $_params = array();

    /**
     * @return string
     */
    public static function className() {
        return get_called_class();
    }

    /**
     * @param string $className
     * @return $this
     */
    public function setClassName($className) {
        $this->_className = $className;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassName() {
        return $this->_className;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params) {
        $this->_params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam($name) {
        return $this->_params[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setParam($name, $value) {
        $this->_params[$name] = $value;
        return $this;
    }

    /**
     * @param mixed $view
     * @return $this
     */
    public function setView($view) {
        $this->_view = $view;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getView() {
        return $this->_view;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function createInstance(array $params = null) {
        $params && $this->setParams(array_merge($this->getParams(), $params));

        if (!$this->_view) {
            throw new \Exception('In widget factory is not set param `view`');
        }

        if (!$this->_className) {
            throw new \Exception('In widget factory is not set param `className`');
        }

        return $this->_view->widget($this->_className, $this->_params);
    }
}
