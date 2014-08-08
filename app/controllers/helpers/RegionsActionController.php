<?php

namespace App\Controllers\Helpers;

use App\Form\RegionForm;
use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;

/**
 * Class RegionsActionController
 * @package App\Controllers\Helpers
 */
class RegionsActionController extends Controller
{
    /**
     *
     */
    const itemsPerPage = 3;

    /**
     * @return $this|AdminView
     */
    public function index()
    {
        return $this->page(1);
    }

    /**
     * @param null $id
     * @return $this|AdminView
     */
    public function page($id = null)
    {
        $totalItems = MapManager::countRegions();

        if (ceil($totalItems / self::itemsPerPage) < $id) {
            return $this->notFound();
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

    /**
     * @param $regionId
     * @return $this
     */
    public function edit($regionId)
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::saveRegion(
                        $post['region_name'],
                        $post['region_id']
                    ) ?
                        $this->flashMessenger->addSuccessMessage(
                            "Region name was changed successfully\n"
                        ) : //TODO Suggest to wrap $this->flashMessenger->addSuccessMessage to $this->success('message')
                        $this->flashMessenger->addErrorMessage("Region name has not been changed\n");
                    //TODO Suggest to wrap $this->flashMessenger->addErrorMessage to $this->error('message')
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }
        return (new AdminView(array('regionId' => $regionId)))->setTemplate('admin/editRegion');
    }

    /**
     * @return $this
     */
    public function add()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::saveRegion($post['region_name']) ?
                        $this->flashMessenger->addSuccessMessage("New region was successfully added\n") :
                        $this->flashMessenger->addErrorMessage("New region hasn't been added\n");
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        return (new AdminView())->setTemplate("admin/addRegion");
    }

    /**
     *
     */
    public function delete()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']) ?
                    $this->flashMessenger->addSuccessMessage("Region was successfully deleted\n") :
                    $this->flashMessenger->addErrorMessage("Region has not been deleted\n");
                $this->redirect("admin/regions");
            }
        }
    }
}