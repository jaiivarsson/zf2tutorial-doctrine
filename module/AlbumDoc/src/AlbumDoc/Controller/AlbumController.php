<?php

namespace AlbumDoc\Controller;

use Zend\Mvc\Controller\ActionController,
    AlbumDoc\Entity,
    AlbumDoc\Form\AlbumForm;

class AlbumController extends ActionController {

    public function indexAction() {
        $em = $this->getLocator()->get('doctrine_em');

        $query = $em->createQuery('SELECT a FROM \AlbumDoc\Entity\Album a');
        $albums = $query->getResult();
        
        return array(
            'albums' => $albums,
        );
    }

    public function addAction() {
        $form = new AlbumForm();
        $form->submit->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $em = $this->getLocator()->get('doctrine_em');
                $album = new \AlbumDoc\Entity\Album();
                $album->artist = $form->getValue('artist');
                $album->title  = $form->getValue('title');
                $em->persist($album);
                $em->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'albumdoc',
                    'action'     => 'index',
                ));

            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $form = new AlbumForm();
        $form->submit->setLabel('Edit');

        $request = $this->getRequest();
        $em = $this->getLocator()->get('doctrine_em');
        if ($request->isPost()) {
            $formData = $request->post()->toArray();

            if ($form->isValid($formData)) {
                
                $album = $em->find('AlbumDoc\Entity\Album', $form->getValue('id'));
                
                if ($album) {
                    $album->artist = $form->getValue('artist');
                    $album->title = $form->getValue('title');
                    $em->flush();
                }
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('default', array(
                            'controller' => 'albumdoc',
                            'action' => 'index',
                        ));
            }
        } else {
            $id = $request->query()->get('id', 0);
            if ($id > 0) {
                $album = $em->find('AlbumDoc\Entity\Album', $id);
                $form->populate(get_object_vars($album));
            }
        }

        return array('form' => $form);
    }

    public function deleteAction() {
        $em = $this->getLocator()->get('doctrine_em');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = $request->post()->get('id');
                $albumEntity = $em->getRepository('AlbumDoc\Entity\Album')->findOneBy(array('id' => $id));
                $em->remove($albumEntity);
                $em->flush();
                
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('default', array(
                'controller' => 'albumdoc',
                'action'     => 'index',
            ));
        }

        $id = $request->query()->get('id', 0);
        $album = $em->find('AlbumDoc\Entity\Album', $id);
        return array('album' => get_object_vars($album));        
    }
}