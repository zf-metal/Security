<?php

namespace ZfMetal\Security\Helper\View;

use Zend\View\Helper\AbstractHelper;

class NotyFlash extends AbstractHelper {

    public function __invoke($current = false) {

        if ($current) {
            echo $this->view->flashMessenger()->renderCurrent('success', array('alert', 'alert-success'));
            echo $this->view->flashMessenger()->renderCurrent('warning', array('alert', 'alert-warning'));
            echo $this->view->flashMessenger()->renderCurrent('default', array('alert', 'alert-info'));
            echo $this->view->flashMessenger()->renderCurrent('error', array('alert', 'alert-danger'));
            $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('default');
            $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('success');
            $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('warning');
            $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('error');
        } else {

            echo $this->view->flashMessenger()->render('success', array('alert', 'alert-success'));
            echo $this->view->flashMessenger()->render('warning', array('alert', 'alert-warning'));
            echo $this->view->flashMessenger()->render('default', array('alert', 'alert-info'));
            echo $this->view->flashMessenger()->render('error', array('alert', 'alert-danger'));
        }
    }

}
