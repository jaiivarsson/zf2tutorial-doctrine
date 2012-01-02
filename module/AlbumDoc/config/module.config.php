<?php

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'albumdoc' => 'AlbumDoc\Controller\AlbumController',
            ),
            'orm_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(
                        'albumdoc' => array(
                            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                            'namespace' => 'AlbumDoc\Entity',
                            'paths' => array(
                                __DIR__ . '/../src/AlbumDoc/Entity'
                            )
                        )
                    )
                )
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options' => array(
                        'script_paths' => array(
                            'albumdoc' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
