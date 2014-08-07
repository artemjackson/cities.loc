<?php

namespace App\Controllers\Helpers;

use App\Form\RegionForm;
use App\Managers\MapManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

class RegionsActionController extends Controller
{
    const itemsPerPage = 3;

    public function page($id = null)
    {
        if (Identifier::identity() !== 'admin') {
            $view = new View();
            $view->setTemplate('errors/403');
            return $view;
        }

        $totalItems = MapManager::countRegions();

        if (ceil($totalItems / self::itemsPerPage) < $id) {
            $view = new AdminView();
            $view->setTemplate('errors/404');
            return $view;
        }

        $id = $id > 0 ? $id : 1;

        return new AdminView(array(
            'regions' => MapManager::getRegions(
                    ($id - 1) * self::itemsPerPage,
                    self::itemsPerPage
                ),
            'activePage' => $id,
            'itemsTotal' => $totalItems,
            'itemsPerPage' => self::itemsPerPage
        ));
    }

    public function index()
    {
        if (Identifier::identity() !== 'admin') { //TODO move to constants. also you can create method isAdmin()
            $view = new View();
            $view->setTemplate('errors/403');
            return $view;
        }

        return $this->page(1);
    }

    public function edit($regionId)
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::safeRegion(
                        $post['region_name'],
                        $post['region_id']
                    ) ? //TODO safeRegion????  do you mean saveRegion
                        $this->flashMessager->addSuccessMessage(
                            "Region name was changed successfully\n"
                        ) : //Suggest to wrap $this->flashMessager->addSuccessMessage to $this->success('message')
                        $this->flashMessager->addErrorMessage("Region name has not been changed\n");
                    //Suggest to wrap $this->flashMessager->addErrorMessage to $this->error('message')
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/editRegion"); //TODO why do you use "" insteadof ''
        $view->setData(array('regionId' => $regionId));

        return $view;
    }

    public function add()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::safeRegion($post['region_name']) ?
                        $this->flashMessager->addSuccessMessage("New region was successfully added\n") :
                        $this->flashMessager->addErrorMessage("New region hasn't been added\n");
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/addRegion");
        return $view;
    }

    public function delete()
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']) ?
                    $this->flashMessager->addSuccessMessage("Region was successfully deleted\n") :
                    $this->flashMessager->addErrorMessage("Region has not been deleted\n");

                $this->redirect("admin/regions");
            }
        }
    }
}