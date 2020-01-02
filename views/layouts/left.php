<aside class="main-sidebar">

    <section class="sidebar">
        <?=
        $rol = 'None';
        $items[] =['label' => Yii::t('app','CRM'), 'options' => ['class' => 'header']];
        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Login', 'url' => ['/user/login']];
            $items[] =['label' => 'Sign Up', 'url' => ['/user/register']];
        } else {
            $rol = Yii::$app->user->identity->profile;
            $clientes = ['label' => Yii::t('app','Clientes'),'icon' => 'bullseye','url' => '#',
                'items' => [
                    ['label' => Yii::t('app','Prospectos'),'icon' => 'user','url' => '/clientes/prospectos',],
                    ['label' => Yii::t('app','Preinstalacion'), 'icon' => 'key', 'url' => ['/contrato/preinstalaciones'],],
                    ['label' => Yii::t('app','Instalaciones'),'icon' => 'user','url' => '/contrato/instalaciones',],
                    ['label' => Yii::t('app','Clientes Activos'),'icon' => 'user','url' => '/clientes/clientes',],

                    ['label' => Yii::t('app','Clientes'),'icon' => 'user','url' => '/clientes',],
                    ['label' => Yii::t('app','Ventas'), 'icon' => 'key', 'url' => ['/ventas'],],
                    ['label' => Yii::t('app','Contratos'), 'icon' => 'key', 'url' => ['/contrato'],],
                    ['label' => Yii::t('app','Servicio Cliente'), 'icon' => 'shield', 'url' => ['/serviciocliente'],],
                ],
            ];

            $servicios =['label' => Yii::t('app','Servicio'),'icon' => 'bolt','url' => '#',
                'items' => [
                    ['label' => Yii::t('app','Servicios'),'icon' => 'user','url' => '/servicios',],
                    ['label' => Yii::t('app','Servicio Cliente'), 'icon' => 'shield', 'url' => ['/serviciocliente'],],
                ],
            ];
            $configuracion =['label' => Yii::t('app','Configuracion'),'icon' => 'cog','url' => '#',
                'items' => [
                    ['label' => Yii::t('app','Productos'),'icon' => 'key','url' => '/producto/index',],
                    ['label' => Yii::t('app','Planes'),'icon' => 'key','url' => '/plan/index',],
                    ['label' => Yii::t('app','Promociones'), 'icon' => 'line-chart', 'url' => '/promocion'],
                    ['label' => Yii::t('app','Promociones Disponibles'), 'icon' => 'line-chart', 'url' => '/promodisponible'],
                    ['label' => Yii::t('app','Financiacion'), 'icon' => 'line-chart', 'url' => '/financiacion'],
                    ['label' => Yii::t('app','Financiacion Disponible'), 'icon' => 'line-chart', 'url' => '/financiaciondisponible'],
                    ['label' => Yii::t('app','Tipo de Servicios'),'icon' => 'user','url' => '/servicios',],
                    ['label' => Yii::t('app','Zonas'),'icon' => 'user','url' => '/zonas',],
                ],
            ];
            $facturas =['label' => Yii::t('app','Facturacion'),'icon' => 'cog','url' => '#',
                'items' => [
                    ['label' => Yii::t('app','Facturas'),'icon' => 'key','url' => '/factura/index',],
                    ['label' => Yii::t('app','Recibos'),'icon' => 'key','url' => '/recibo/index',],
                    ['label' => Yii::t('app','Estado Cuenta'),'icon' => 'key','url' => '/estadocuenta/index',],
                    ['label' => Yii::t('app','Periodos'),'icon' => 'calendar','url' => '/periodos/index',],

                ],
            ];
            if ($rol == 'Admin') {
                $items[] = $clientes;
                $items[] = $servicios;
                $items[] = $configuracion;
                $items[] = $facturas;

            } else if ($rol == 'Vendedor'){
                $clientes = ['label' => Yii::t('app','Clientes'),'icon' => 'bullseye','url' => '#',
                    'items' => [
                        ['label' => Yii::t('app','Prospectos'),'icon' => 'user','url' => '/clientes/prospectos',],
                        ['label' => Yii::t('app','Clientes'),'icon' => 'user','url' => '/clientes',],
                        ['label' => Yii::t('app','Ventas'), 'icon' => 'key', 'url' => ['/ventas'],],
                        ['label' => Yii::t('app','Servicio Cliente'), 'icon' => 'shield', 'url' => ['/serviciocliente'],],
                    ],
                ];
                $items[] = $clientes;
            }else if ($rol == 'Tecnico'){
                $tecnicos = ['label' => Yii::t('app','Servicios'),'icon' => 'bullseye','url' => '#',
                    'items' => [
                        ['label' => Yii::t('app','Servicios asignados'),'icon' => 'user','url' => '/serviciocliente/indextecnico',],

                    ],
                ];
                $items[] = $tecnicos;
            }else{
                $items[] = ['label' => Yii::t('app','Estadisticas'), 'icon' => 'line-chart', 'url' => '/charts'];
                $items[] = ['label' =>Yii::t('app','Campaings'), 'icon' => 'bullhorn', 'url' => '/campaing'];
                $items[] = ['label' => Yii::t('app','Avisos'), 'icon' => 'film', 'url' => '/avisos'];
                //$items[] = ['label' => 'Pagos', 'icon' => 'share', 'url' => '/pagos'];
                $items[] = ['label' =>Yii::t('app','Facturacion'), 'icon' => 'money', 'url' => '/facturas'];
            }

            $items [] =['label' => Yii::t('app','Logout').'(' . Yii::$app->user->identity->username .' | ' .Yii::$app->user->identity->empresa . ')',
                'url' => ['/site/logout'],
                'template' => '<a href="{url}" data-method="post">{label}</a>',
                'linkOptions' => ['data-method' => 'post']];
        }
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'sidebar-menu tree','data-widget'=> 'tree'],
            //    'options' => ['class' => 'sidebar-menu tree'],
            'items' => $items
        ]);
                ?>

    </section>

</aside>
<?php
